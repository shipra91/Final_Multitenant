<?php
    namespace App\Services;
<<<<<<< HEAD

=======
>>>>>>> main
    use App\Repositories\StudentMappingRepository;
    use App\Repositories\ExamTimetableRepository;
    use App\Repositories\InstitutionSubjectRepository;
    use App\Repositories\SubjectRepository;
    use App\Repositories\InstitutionRepository;
    use App\Repositories\ExamMasterRepository;
<<<<<<< HEAD
    use DB;
    use Session;
    use Carbon\Carbon;

    class HallticketService {

        public function getHallticketDetails($request){

            $studentMappingRepository = new StudentMappingRepository();
            $examTimetableRepository = new ExamTimetableRepository();
            $institutionSubjectRepository = new InstitutionSubjectRepository();
            $subjectRepository = new SubjectRepository();
            $institutionRepository = new InstitutionRepository();
            $examMasterRepository = new ExamMasterRepository();
            $institutionStandardService = new InstitutionStandardService();

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $subjectDetails = array();
            $hallTicketDetails = array();
            $data['examId'] = $request->get('exam');
            $institutionStandard = $request->get('institutionStandard');
            $examDetails = $examMasterRepository->fetch($data['examId']);

            $institute = $institutionRepository->fetch($institutionId);
            $hallTicketDetails['institute'] = $institute;
            $hallTicketDetails['exam'] = $examDetails;
            $count = 0;

            foreach($institutionStandard as $stdIndex => $standardId){

                $data['standardId'] = $standardId;
                $examSubjectDetails =  $examTimetableRepository->fetchExamSubjects($data);

                foreach($examSubjectDetails as $index => $examSubject){

                    $institutionSubjectData = $institutionSubjectRepository->find($examSubject->id_institution_subject);
                    $subjectTypeDetails = $subjectRepository->fetchSubjectTypeDetails($institutionSubjectData->id_subject);

                    if($institutionSubjectData->subject_type != 'THEORY'){
                        $subjectLabel = $institutionSubjectData->display_name.' - '.$institutionSubjectData->subject_type;
                    }else{
                        $subjectLabel = $institutionSubjectData->display_name;
                    }

                    $examDate = explode('-', $examSubject->exam_date);
                    $examDay = date("l", mktime(0, 0, 0, $examDate[1], $examDate[2], $examDate[0]));

                    $subjectDetails[$index] = $examSubject;
                    $subjectDetails[$index]['name'] = $subjectLabel;
                    $subjectDetails[$index]['type'] = $subjectTypeDetails->label;
                    $subjectDetails[$index]['exam_date'] = Carbon::createFromFormat('Y-m-d', $examSubject->exam_date)->format('d-m-Y');
                    $subjectDetails[$index]['exam_day'] = strtoupper($examDay);
                }

                $studentDetails = $studentMappingRepository->fetchInstitutionStandardStudents($data['standardId']);

                foreach($studentDetails as $key => $student){

                    $studentName = $studentMappingRepository->getFullName($student->name, $student->middle_name, $student->last_name);

                    $examSubjectData = array();
                    $data['studentId'] = $student->id_student;
                    $student['standard'] = $institutionStandardService->fetchStandardByUsingId($student->id_standard);

                    foreach($subjectDetails as $index => $subject){

                        if($subject->type != 'common'){

                            $data['subjectId'] = $subject->id_institution_subject;
                            $check = $studentMappingRepository->checkSubjectMappedToStudent($data);

                            if($check){
                                $subjectDisplay = "show";
                            }else{
                                $subjectDisplay = "hide";
                            }

                        }else{
                            $subjectDisplay = "show";
                        }

                        if($subjectDisplay == 'show'){
                            $examSubjectData[$index] = $subject;
                        }
                    }
                    // dd($examSubjectData);
                    $hallTicketDetails['student_subject'][$count]['student'] = $student;
                    $hallTicketDetails['student_subject'][$count]['exam_subject_data'] = $examSubjectData;
                    $hallTicketDetails['student_subject'][$count]['studentName'] = $studentName;
                    $count++;
                }
                // dd($hallTicketDetails);
            }

            return $hallTicketDetails;
        }
    }
=======
    use DB; 
    use Session;
    use Carbon\Carbon;

class HallticketService {

    public function getHallticketDetails($request, $allSessions) {

        $studentMappingRepository = new StudentMappingRepository();
        $examTimetableRepository = new ExamTimetableRepository();
        $institutionSubjectRepository = new InstitutionSubjectRepository();
        $subjectRepository = new SubjectRepository();
        $institutionRepository = new InstitutionRepository();
        $examMasterRepository = new ExamMasterRepository();
        $institutionStandardService = new InstitutionStandardService();

        $institutionId = $allSessions['institutionId'];
        $academicId = $allSessions['academicYear'];

        $subjectDetails = array();
        $hallTicketDetails = array();
        $data['examId'] = $request->get('exam');
        $institutionStandard = $request->get('institutionStandard');
        $examDetails = $examMasterRepository->fetch($data['examId']);
       
        $institute = $institutionRepository->fetch($institutionId);
        $hallTicketDetails['institute'] = $institute;
        $hallTicketDetails['exam'] = $examDetails;
        $count = 0;
        foreach($institutionStandard as $stdIndex => $standardId) {
            $data['standardId'] = $standardId;
       
            $examSubjectDetails =  $examTimetableRepository->fetchExamSubjects($data, $allSessions);
            foreach($examSubjectDetails as $index => $examSubject) {
                $institutionSubjectData = $institutionSubjectRepository->find($examSubject->id_institution_subject);
            
                $subjectTypeDetails = $subjectRepository->fetchSubjectTypeDetails($institutionSubjectData->id_subject, $allSessions);

                if($institutionSubjectData->subject_type != 'THEORY'){
                    $subjectLabel = $institutionSubjectData->display_name.' - '.$institutionSubjectData->subject_type;
                }else{
                    $subjectLabel = $institutionSubjectData->display_name;
                }
             
                $examDate = explode('-', $examSubject->exam_date);
                $examDay = date("l", mktime(0, 0, 0, $examDate[1], $examDate[2], $examDate[0]));

                $subjectDetails[$index] = $examSubject;
                $subjectDetails[$index]['name'] = $subjectLabel;
                $subjectDetails[$index]['type'] = $subjectTypeDetails->label;
                $subjectDetails[$index]['exam_date'] = Carbon::createFromFormat('Y-m-d', $examSubject->exam_date)->format('d-m-Y');
                $subjectDetails[$index]['exam_day'] = strtoupper($examDay);
            }

            $studentDetails = $studentMappingRepository->fetchInstitutionStandardStudents($data['standardId'], $allSessions);
            foreach($studentDetails as $key => $student) {
                
                $examSubjectData = array();
                $data['studentId'] = $student->id_student;
                $student['standard'] = $institutionStandardService->fetchStandardByUsingId($student->id_standard);

                foreach($subjectDetails as $index => $subject) {

                    if($subject->type != 'common') {

                        $data['subjectId'] = $subject->id_institution_subject;
                        $check = $studentMappingRepository->checkSubjectMappedToStudent($data, $allSessions);
                        if($check){
                            $subjectDisplay = "show";
                        }else{
                            $subjectDisplay = "hide";
                        }

                    }else {
                        $subjectDisplay = "show";
                    }

                    if($subjectDisplay == 'show') {
                        $examSubjectData[$index] = $subject;
                    }
                }
                // dd($examSubjectData);
                $hallTicketDetails['student_subject'][$count]['student'] = $student;
                $hallTicketDetails['student_subject'][$count]['exam_subject_data'] = $examSubjectData;
                $count++;
            }
            // dd($hallTicketDetails);
        }
        return $hallTicketDetails;
    }
}
?>
>>>>>>> main
