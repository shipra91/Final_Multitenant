<?php
    namespace App\Services;

    use App\Models\ExamSubjectConfiguration;
    use App\Repositories\ExamSubjectConfigurationRepository;
    use App\Repositories\InstitutionSubjectRepository;
    use App\Repositories\ResultRepository;
    use App\Repositories\GradeRepository;
    use Carbon\Carbon;
    use Session;

    class ExamSubjectConfigurationService {

        // Get all grade set
        public function allGradeSet($allSessions){
            $gradeRepository = new GradeRepository();
            return $gradeRepository->all($allSessions);
        }

        public function getAll(){
            $examSubjectConfigurationRepository = new ExamSubjectConfigurationRepository();

            $result = $examSubjectConfigurationRepository->all();
            return $result;
        }

        public function add($resultData, $allSessions){

            $idInstitution = $resultData->id_institute;
            $academicYear = $resultData->id_academic;
            $successCount = 0;
            $existingCount = 0;

            foreach($resultData->subject as $index => $subjectId){

                $examSubjectConfigurationRepository = new ExamSubjectConfigurationRepository();

                $check = $examSubjectConfigurationRepository->checkExistence($resultData->exam, $resultData->standard, $subjectId, $allSessions);

                if(!$check){

                    $data = array(
                        'id_institute' => $idInstitution,
                        'id_academic' => $academicYear,
                        'id_exam' => $resultData->exam,
                        'id_standard' => $resultData->standard,
                        'id_subject' => $subjectId,
                        'id_grade_set' => $resultData->gradeSet,
                        'display_name' => $resultData->display_name[$subjectId],
                        'subject_part' => $resultData->subject_part[$subjectId],
                        'priority' => $resultData->priority[$subjectId],
                        'conversion' => $resultData->conversion_required[$subjectId],
                        'conversion_value' => $resultData->conversion_value[$subjectId],
                        'max_mark' => $resultData->max_mark[$subjectId],
                        'pass_mark' => $resultData->pass_mark[$subjectId],
                        'created_by' => Session::get('userId')
                    );

                    $storeData = $examSubjectConfigurationRepository->store($data);

                }else{

                    $getConfigId = $check->id;

                    $getConfigData = $examSubjectConfigurationRepository->fetch($getConfigId);

                    $getConfigData->id_grade_set = $resultData->gradeSet;
                    $getConfigData->display_name = $resultData->display_name[$subjectId];
                    $getConfigData->subject_part = $resultData->subject_part[$subjectId];
                    $getConfigData->priority = $resultData->priority[$subjectId];
                    $getConfigData->conversion = $resultData->conversion_required[$subjectId];
                    $getConfigData->conversion_value = $resultData->conversion_value[$subjectId];
                    $getConfigData->max_mark = $resultData->max_mark[$subjectId];
                    $getConfigData->pass_mark = $resultData->pass_mark[$subjectId];
                    $getConfigData->modified_by = Session::get('userId');

                    $storeData = $examSubjectConfigurationRepository->update($getConfigData);
                }
            }

            if($storeData) {
                $signal = 'success';
                $msg = 'Data inserted successfully!';

            }else{
                $signal = 'failure';
                $msg = 'Error updating data!';
            }

            $output = array(
                'signal' => $signal,
                'message' => $msg
            );

            return $output;
        }

        public function getExamSubjectConfigDataWithMaxMark($idInstitution, $idAcademics, $exam, $standardId, $studentId, $allSessions){

            $idInstitution = $sessionData['institutionId'];
            $idAcademics = $sessionData['academicYear'];

            $examSubjectConfigurationRepository = new ExamSubjectConfigurationRepository();
            $institutionSubjectRepository = new InstitutionSubjectRepository();
            $resultRepository = new ResultRepository();
            $gradeRepository = new GradeRepository();


            $examSubjectConfiguration = $examSubjectConfigurationRepository->getExamSubjectConfig($exam, $standardId, $allSessions);
            $maxExamDataArray = [];

            foreach($examSubjectConfiguration as $index => $examSubjectConfig){

                $maxExamDataArray[$index]['display_name'] = $examSubjectConfig->display_name;

                $getInstitutionSubjects = $institutionSubjectRepository->fetchSubjectDetail($examSubjectConfig->id_subject, $allSessions);
                // dd($getInstitutionSubjects);
                $theory_max = $practical_max = $theory_score = $practical_score = $grades = '-';
                $totalScore = $totalMax = $totalPercentage = 0;

                foreach($getInstitutionSubjects as $key => $subjectData){

                    $paramArray = array(
                        'id_institute' => $idInstitution,
                        'id_academic_year' => $idAcademics,
                        'id_exam' => $exam,
                        'id_subject' => $subjectData['id'],
                        'id_standard' => $standardId,
                        'id_student' => $studentId
                    );

                    $getStudentResult = $resultRepository->fetch($paramArray);

                    if($getStudentResult){

                        if($subjectData->subject_type === 'THEORY'){
                            $theory_score = $getStudentResult->total_score;
                        }

                        if($subjectData->subject_type === 'PRACTICAL'){
                            $practical_score = $getStudentResult->total_score;
                        }
                    }

                    if($subjectData->subject_type === 'THEORY'){
                        $theory_max = $subjectData->max_marks;
                    }

                    if($subjectData->subject_type === 'PRACTICAL'){
                        $practical_max = $subjectData->max_marks;
                    }

                    // MAX
                    if($theory_max == '-'){
                        $theoryMax = 0;
                    }else{
                        $theoryMax = $theory_max;
                    }

                    if($practical_max == '-'){
                        $practicalMax = 0;
                    }else{
                        $practicalMax = $practical_max;
                    }

                    // SCORE
                    if($theory_score == '-'){
                        $theoryScore = 0;
                    }else{
                        $theoryScore = $theory_score;
                    }

                    if($practical_score == '-'){
                        $practicalScore = 0;
                    }else{
                        $practicalScore = $practical_score;
                    }

                    $totalMax = $theoryMax + $practicalMax;
                    $totalScore = $theoryScore + $practicalScore;

                    if($totalScore > 0){
                        $totalPercentage = round((($totalScore/$totalMax) * 100), 2);
                    }

                    $grade = $gradeRepository->getGrade($idInstitution, $idAcademics, $exam, $standardId, $totalPercentage);

                    if($grade){
                        $grades = $grade->grade;
                    }
                }

                $maxExamDataArray[$index]['theory_max'] = $theory_max;
                $maxExamDataArray[$index]['practical_max'] = $practical_max;
                $maxExamDataArray[$index]['theory_score'] = $theory_score;
                $maxExamDataArray[$index]['practical_score'] = $practical_score;
                $maxExamDataArray[$index]['percentage'] = $totalPercentage;
                $maxExamDataArray[$index]['grade'] = $grades;

            }
            // dd($maxExamDataArray);
            return $maxExamDataArray;
        }

        // Check if grade set is already in use
        public function checkIfGradeSetIsUsed($id_gradeSet){
            return ExamSubjectConfiguration::where('id_grade_set', $id_gradeSet)->get();
        }
    }

