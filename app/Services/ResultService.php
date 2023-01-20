<?php
    namespace App\Services;
    use App\Models\Result;
    use App\Repositories\ResultRepository;
    use App\Repositories\AcademicYearRepository;
    use App\Repositories\InstitutionRepository;
    use App\Repositories\ExamMasterRepository;
    use App\Repositories\ExamTimetableRepository;
    use App\Services\ExamSubjectConfigurationService;
    use App\Repositories\ExamTimetableSettingRepository;
    use App\Repositories\InstitutionSubjectRepository;
    use App\Repositories\SubjectTypeRepository;
    use App\Repositories\SubjectRepository;
    use App\Repositories\StudentMappingRepository;
    use App\Repositories\StudentRepository;
    use App\Services\InstitutionStandardService;
    use App\Repositories\GradeRepository;
    use Carbon\Carbon;
    use Session;
    use DB;

    class ResultService {

        // Get all standards
        public function getAllData($allSessions){

            $institutionStandardService = new InstitutionStandardService();

            $institutionStandards = $institutionStandardService->fetchStandard($allSessions);
            return $institutionStandards;
        }

        // Get students data
        public function getAllStudentData($request, $allSessions){

            $studentMappingRepository = new StudentMappingRepository();
            $examTimetableRepository = new ExamTimetableRepository();

            $studentArray = array();

            $examTimetable = $examTimetableRepository->getExamMinMax($request, $allSessions);
            $studentData = $studentMappingRepository->fetchStudentUsingStandard($request['standardId'], $allSessions);

            foreach($studentData as $key => $student){
                $studentArray[$key] = $student;
                $studentName = $studentMappingRepository->studentName($student['name'], $student['middle_name'], $student['last_name']);
                $studentArray[$key]['name'] = $studentName;
                $studentArray[$key]['maxMark'] = $examTimetable->maxMark;
                $studentArray[$key]['minMark'] = $examTimetable->minMark;
                $studentArray[$key]['examId'] = $request['examId'];
            }
            // dd($studentArray);
            return $studentArray;
        }

        // Get result details
        public function getResultDetail($request, $allSessions){

            $resultRepository = new ResultRepository();
            $institutionSubjectRepository = new InstitutionSubjectRepository();
            $studentRepository = new StudentRepository();
            $subjectTypeRepository = new SubjectTypeRepository();
            $subjectRepository = new SubjectRepository();
            $studentMappingRepository = new StudentMappingRepository();

            $standardId = $request->standardId;
            $examId = $request->examId;
            $studentId = $request->studentId;

            $studentResultDetail = $resultRepository->fetchResultDetail($standardId, $examId, $studentId, $allSessions);
            // dd($studentResultDetail);
            $arrayData = array();

            foreach($studentResultDetail as $key => $resultDetail){

                $subjectData = $institutionSubjectRepository->find($resultDetail->id_subject);
                $studentData = $studentRepository->fetch($resultDetail['id_student']);
                $type = $subjectTypeRepository->fetch($subjectData->id_type);

                $studentName = $studentMappingRepository->studentName($studentData->name, $studentData->middle_name, $studentData->last_name);

                $subjectNameCount = $subjectRepository->fetchSubjectNameCount($subjectData->name);
                if(count($subjectNameCount) > 1){
                    $subjectType = ' ( '.$type->display_name.' )';
                }else{
                    $subjectType = '';
                }               
                                            
                $arrayData['result'][$key]['subject'] = $subjectData->display_name.$subjectType;
                $arrayData['result'][$key]['external_score'] = $resultDetail['external_score'];
                $arrayData['result'][$key]['internal_score'] = $resultDetail['internal_score'];
                $arrayData['result'][$key]['total_score'] = $resultDetail['total_score'];
                $arrayData['result'][$key]['grade'] = $resultDetail['grade'];
                $arrayData['student_name'] = $studentName;
                $arrayData['student_uid'] = $studentData->egenius_uid;
            }

            return $arrayData;
        }

        // Get exam based on standard
        public function getExamByStandard($standardId, $allSessions){

            $examMasterRepository = new ExamMasterRepository();
            $exams = $examMasterRepository->fetchExamByStandard($standardId, $allSessions);
            // dd($exams);
            $arrayData = array();

            foreach($exams as $key => $exam){
                $arrayData[$key]['label'] = $exam->name;
                $arrayData[$key]['value'] = $exam->id;
            }

            return $arrayData;
        }

        // Get subjects based on exam
        public function getSubjectByExam($standardId, $examId, $allSessions){

            $institutionSubjectRepository = new InstitutionSubjectRepository();
            $examTimetableRepository = new ExamTimetableRepository();
            $subjectTypeRepository = new SubjectTypeRepository();
            $subjectRepository = new SubjectRepository();

            $subjects = $examTimetableRepository->fetchSubjectsByExam($standardId, $examId, $allSessions);
            //dd($subjects);

            $arrayData = array();

            foreach($subjects as $key => $subject){

                $subjectData = $institutionSubjectRepository->find($subject->id_institution_subject);
                $subjectCount = $institutionSubjectRepository->findCount($subjectData->id_subject, $allSessions);

                $type = $subjectTypeRepository->fetch($subjectData->id_type);

                $subjectNameCount = $subjectRepository->fetchSubjectNameCount($subjectData->name);
                if(count($subjectNameCount) > 1){
                    $subjectType = ' ( '.$type->display_name.' )';
                }else{
                    $subjectType = '';
                }

                if(sizeof($subjectCount) == 2){
                    $displayName = $subjectData['display_name'].'-'.$subjectData['subject_type'];
                }else{
                    $displayName = $subjectData['display_name'];
                }

                $arrayData[$key]['value'] = $subject->id_institution_subject;
                $arrayData[$key]['label'] = $displayName.$subjectType;
            }

            return $arrayData;
        }

        // Get students based on standard and subject
        public function fetchStudent($request, $allSessions){

            $idInstitution = $sessionData['institutionId'];
            $idAcademics = $sessionData['academicYear'];

            $institutionSubjectRepository = new InstitutionSubjectRepository();
            $subjectTypeRepository = new SubjectTypeRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $examTimetableRepository = new ExamTimetableRepository();
            $resultRepository = new ResultRepository();

            $allStudent = array();

            $subjectId = $request->subject;
            $subjectData = $institutionSubjectRepository->find($subjectId);

            if($subjectData){

                $subjectType = $subjectTypeRepository->fetchSubjectDetails($subjectData->id_subject);
                $examTimetableData = $examTimetableRepository->fetch($request->exam, $subjectId, $request->standard);
                // dd($examTimetableData);

                $data = array(
                    'standardId' => $request->standard,
                    'subjectId' => $request->subject
                );

                if($subjectType->label !='common'){

                    $student = $studentMappingRepository->fetchStudentUsingSubject($data, $allSessions);

                }else{

                    $student = $studentMappingRepository->fetchStudentUsingStandard($data, $allSessions);
                }

                foreach($student as $data){

                    $external_score = $internal_max = $internal_score = $total_max = $total_score = $grade = '';

                    $studentName = $studentMappingRepository->studentName($data->name, $data->middle_name, $data->last_name);

                    $paramArray = array(
                        'id_institute'=>$idInstitution,
                        'id_academic_year'=>$idAcademics,
                        'id_exam'=>$request->exam,
                        'id_subject'=>$request->subject,
                        'id_standard'=>$request->standard,
                        'id_student'=>$data->id_student
                    );
                    //dd($paramArray);

                    $studentResultData= $resultRepository->fetch($paramArray);

                    if($studentResultData){
                        $external_score = $studentResultData->external_score;
                        $internal_max = $studentResultData->internal_max;
                        $internal_score = $studentResultData->internal_score;
                        $total_max = $studentResultData->total_max;
                        $total_score = $studentResultData->total_score;
                        $grade = $studentResultData->grade;
                    }else{
                        $total_max = $examTimetableData->max_marks;
                    }
                    //dd($studentResultData);

                    $studentDetails = array(
                        'id_student' => $data->id_student,
                        'name' => $studentName,
                        'uid' => $data->egenius_uid,
                        'maxMarks' => $examTimetableData->max_marks,
                        'externalScore' => $external_score,
                        'internal_max' => $internal_max,
                        'internal_score' => $internal_score,
                        'total_max' => $total_max,
                        'total_score' => $total_score,
                        'grade' => $grade
                    );

                    $allStudent[]= $studentDetails;
                }
            }
            // dd($allStudent);
            return $allStudent;
        }

        // Insert result
        public function add($resulData){

            $resultRepository = new ResultRepository();
            $count = 0;

            foreach($resulData['student_id'] as $key => $idStudent){

                $count++;

                $check = Result::where('id_institute', $resulData->id_institute)
                            ->where('id_academic_year', $resulData->id_academic)
                            ->where('id_exam', $resulData->exam_id)
                            ->where('id_subject', $resulData->subject_id)
                            ->where('id_standard', $resulData->standard_id)
                            ->where('id_student', $idStudent)->first();

                if(!$check){

                    if($resulData->total_score[$key] != ''){

                        $data = array(
                            'id_institute' => $resulData->id_institute,
                            'id_academic_year' => $resulData->id_academic,
                            'id_exam' => $resulData->exam_id,
                            'id_subject' => $resulData->subject_id,
                            'id_standard' => $resulData->standard_id,
                            'id_student' => $idStudent,
                            'external_score' => $resulData->external_score[$key],
                            'internal_max' => $resulData->internal_max[$key],
                            'internal_score' => $resulData->internal_score[$key],
                            'total_max' => $resulData->total_max[$key],
                            'total_score' => $resulData->total_score[$key],
                            'grade' =>$resulData->grade[$key],
                            'created_by' => Session::get('userId')
                        );

                        $storeData = $resultRepository->store($data);
                    }

                }else{

                    $check->id_institute = $resulData->id_institute;
                    $check->id_academic_year = $resulData->id_academic;
                    $check->id_exam = $resulData->exam_id;
                    $check->id_subject = $resulData->subject_id;
                    $check->id_standard = $resulData->standard_id;
                    $check->id_student = $idStudent;
                    $check->external_score = $resulData->external_score[$key];
                    $check->internal_max = $resulData->internal_max[$key];
                    $check->internal_score = $resulData->internal_score[$key];
                    $check->total_max = $resulData->total_max[$key];
                    $check->total_score = $resulData->total_score[$key];
                    $check->grade = $resulData->grade[$key];
                    $check->modified_by = Session::get('userId');
                    $check->updated_at = Carbon::now();

                    $storeData = $resultRepository->update($check);
                }
            }

            if($count > 0) {
                $signal = 'success';
                $msg = 'Data inserted successfully!';

            }else{
                $signal = 'failure';
                $msg = 'Error inserting data!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function fetchTableColumns(){

            // $columnArray = ['gender', 'blood_group', 'designation', 'department', 'role', 'staff_category', 'staff_subcategory', 'nationality', 'religion', 'caste_category'];
            $allColumns = DB::getSchemaBuilder()->getColumnListing('tbl_result');

            $unNeededColumns = ['id', 'id_academic_year', 'id_institute', 'id_exam', 'id_subject', 'id_standard', 'id_student', 'created_by', 'modified_by', 'deleted_at', 'created_at', 'updated_at'];
            $neededColumns = array_diff($allColumns, $unNeededColumns);
            // array_push($neededColumns, ...$columnArray);
            return $neededColumns;
        }

        // public function findTokenData($idStudent){

        //     $institutionRepository = new InstitutionRepository();
        //     $institution = $institutionRepository->fetch($idInstitution);

        //     return $institution;
        // }

        public function generateMarksCard($idInstitution, $idAcademics, $exam, $standardId, $allSessions){

            $examSubjectConfigurationService = new ExamSubjectConfigurationService();
            $institutionSubjectRepository = new InstitutionSubjectRepository();
            $institutionStandardService = new InstitutionStandardService();
            $studentMappingRepository = new StudentMappingRepository();
            $examTimetableRepository = new ExamTimetableRepository();
            $institutionRepository = new InstitutionRepository();
            $resultRepository = new ResultRepository();
            $gradeRepository = new GradeRepository();
            $htmlTemplate = '';
        
            $standardStudents = $studentMappingRepository->fetchStudentUsingStandard($standardId, $allSessions);
            $examTimetable = $examTimetableRepository->fetchSubjectsByExam($standardId, $exam, $allSessions);
            $standardName = $institutionStandardService->fetchStandardByUsingId($standardId);
            $institutionData = $institutionRepository->fetch($idInstitution);
            
            
            foreach($standardStudents as $index => $student){
                $grandTotalMax = $grandTotalScore = $grandTotalPercentage = 0;
                $finalGrand = '-';

                $examSubjectConfiguration = $examSubjectConfigurationService->getExamSubjectConfigDataWithMaxMark($idInstitution, $idAcademics, $exam, $standardId, $student->id_student, $allSessions);
                // dd($examSubjectConfiguration);

                $studentName = $studentMappingRepository->studentName($student['name'], $student['middle_name'], $student['last_name']);

                $htmlTemplate .= '<style>
                                    table{
                                        border : 1px solid;
                                    }
                                    .outerborder{
                                        border : 1px solid;                
                                        display: inline-block;
                                        margin: 0.5%;
                                    }            
                                    .text_center{
                                        text-align:center;
                                    }
                                    .logo{
                                        text-align:center;
                                    }
                                    .logo{
                                        height:90px;
                                        width:auto;
                                    }
                                    .school_name{
                                        font-size : 16px;
                                        margin-bottom : 15px;
                                    }
                                    .school_address{
                                        font-size : 14px;
                                    }
                                    .text-left{
                                        text-align : left;
                                    }
                                    .text-right{
                                        text-align : right;
                                    }
                                    .top_border{
                                        border-top:1px solid;
                                    }
                                    .bottom_border{
                                        border-bottom:1px solid;
                                    }
                                    .right_border{
                                        border-right:1px solid;
                                    }
                                    .margin_bottom{
                                        margin-top: 0px;
                                        margin-bottom: 1px;
                                    }
                                    .margin-t-60{
                                        margin-top : 60px;
                                    }
                                    .margin-r-5{
                                        margin-right : 5px;
                                    }
                                    .font_13{
                                        font-size : 13px;
                                    }
                                    .font_18{
                                        font-size : 18px;
                                    }
                                    .margin-t-0{
                                        margin-top : 0px;
                                    }
                                    .margin-b-0{
                                        margin-bottom : 0px;
                                    }
                                    .mr-3{
                                        margin-right : 15px;
                                    }
                                    .media {
                                        display: inline-flex;
                                    }
                                    .media-body {
                                        -webkit-box-flex: 1;
                                        -ms-flex: 1;
                                        flex: 1;
                                    }
                                    hr{
                                        margin: 30px 0;
                                        border: 1px dashed;
                                    }
                                </style>
                                <table width="100%" cellpadding="0" cellspacing="0"> 
                                    <thead>
                                        <tr> 
                                            <th colspan="8">
                                                <div class="media">
                                                    <img class="mr-3 logo" src="data:image/png;base64,'.base64_encode(file_get_contents($institutionData->institution_logo)).'" alt="logo">
                                                    <div class="media-body">
                                                        <h5 class="mt-0 school_name font_18">Institution Name</h5>
                                                        <p class="school_address font_13">Institution Address</p>  
                                                    </div>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="text-left right_border" colspan="8">Student : '.$studentName.'</th>
                                        </tr>
                                        <tr>
                                            <th class="text-left right_border" colspan="8">Standard : '.$standardName.'</th>
                                        </tr>                                
                                        <tr>
                                            <th class="top_border right_border" rowspan="2">SL.</th>
                                            <th class="top_border right_border" rowspan="2">SUBJECTS</th>
                                            <th class="top_border right_border" colspan="2">MAX MARKS</th>
                                            <th class="top_border right_border" colspan="2">OBTAINED MARKS</th>
                                            <th class="top_border right_border" rowspan="2">PERCENTAGE</th>
                                            <th class="top_border" rowspan="2">GRADE</th>
                                        </tr>
                                        <tr>
                                            <th class="top_border right_border">TH</th>
                                            <th class="top_border right_border">PR</th>
                                            <th class="top_border right_border">TH</th>
                                            <th class="top_border right_border">PR</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    // dd($examSubjectConfiguration);
                                        foreach($examSubjectConfiguration as $key => $examSubjectData){
                                            
                                            $maxTheory = ($examSubjectData['theory_max'] === '-')?0:$examSubjectData['theory_max'];
                                            $maxPractical = ($examSubjectData['practical_max'] === '-')?0:$examSubjectData['practical_max'];
                                            $maxTheoryScore = ($examSubjectData['theory_score'] === '-')?0:$examSubjectData['theory_score'];
                                            $maxPracticalScore = ($examSubjectData['practical_score'] === '-')?0:$examSubjectData['practical_score'];

                                            $grandTotalMax = $grandTotalMax + $maxTheory + $maxPractical;
                                            $grandTotalScore = $grandTotalScore + $maxTheoryScore + $maxPracticalScore;
                                            if($grandTotalScore > 0){
                                                $grandTotalPercentage = round(($grandTotalScore/$grandTotalMax) * 100, 2);
                                            }

                                            $grade = $gradeRepository->getGrade($idInstitution, $idAcademics, $exam, $standardId, $grandTotalPercentage);
                                            if($grade){
                                                $finalGrand = $grade->grade;
                                            }

                                            $htmlTemplate .= '<tr>
                                                                <td class="top_border right_border text_center">'.++$key.'</td>
                                                                <td class="top_border right_border">'.$examSubjectData['display_name'].'</td>
                                                                <td class="top_border text_center right_border">'.$examSubjectData['theory_max'].'</td>
                                                                <td class="top_border text_center right_border">'.$examSubjectData['practical_max'].'</td>
                                                                <td class="top_border text_center right_border">'.$examSubjectData['theory_score'].'</td>
                                                                <td class="top_border text_center right_border">'.$examSubjectData['practical_score'].'</td>
                                                                <td class="top_border text_center right_border">'.$examSubjectData['percentage'].'</td>
                                                                <td class="top_border text_center">'.$examSubjectData['grade'].'</td>
                                                            </tr>';
                                                
                                        }
                                           
                                        
                    $htmlTemplate .= '  <tr>
                                            <th colspan="2" class="top_border right_border">TOTAL</th>
                                            <th colspan="2" class="top_border right_border">'.$grandTotalMax.'</th>
                                            <th colspan="2" class="top_border right_border">'.$grandTotalScore.'</th>
                                            <th class="top_border">'.$grandTotalPercentage.'%</th>
                                            <th class="top_border">'.$finalGrand.'</th>
                                        </tr>';
                    $htmlTemplate .= '</tbody>
                                </table>
                                <hr/>';
            }
            // print_r($htmlTemplate);
            return $htmlTemplate;
        }
    }
?>
