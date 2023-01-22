<?php
    namespace App\Services;

    use App\Models\HomeworkSubmission;
    use App\Models\HomeworkSubmissionPermission;
    use App\Services\InstitutionSubjectService;
    use App\Services\StaffService;
    use App\Services\UploadService;
    use App\Services\SubjectService;
    use App\Services\StandardSubjectService;
    use App\Repositories\HomeworkSubmissionRepository;
    use App\Repositories\StaffSubjectMappingRepository;
    use App\Repositories\StandardSubjectRepository;
    use App\Repositories\HomeworkRepository;
    use App\Repositories\HomeworkDetailRepository;
    use App\Repositories\StandardSubjectStaffMappingRepository;
    use App\Repositories\StudentMappingRepository;
    use App\Repositories\StaffRepository;
    use App\Repositories\StudentElectivesRepository;
    use App\Repositories\HomeworkViewedDetailsRepository;
    use App\Repositories\HomeworkSubmissionDetailRepository;
    use App\Repositories\InstitutionSubjectRepository;
    use App\Repositories\SubjectTypeRepository;
    use App\Repositories\HomeworkSubmissionPermissionRepository;
    use Carbon\Carbon;
    use Session;
    use ZipArchive;

    class HomeworkSubmissionService {

        // Get all homework submission
        public function getAll($allSessions){

            $homeworkSubmissionRepository = new HomeworkSubmissionRepository();
            $homeworkDetailRepository = new HomeworkDetailRepository();
            $homeworkRepository = new HomeworkRepository();
            $institutionStandardService = new InstitutionStandardService();
            $institutionSubjectService = new InstitutionSubjectService();
            $studentMappingRepository = new StudentMappingRepository();
            $studentElectivesRepository = new StudentElectivesRepository();
            $institutionSubjectRepository = new InstitutionSubjectRepository();
            $homeworkSubmissionPermissionRepository = new HomeworkSubmissionPermissionRepository();
            $subjectService = new SubjectService();
            $subjectTypeRepository = new SubjectTypeRepository();
            $staffService = new StaffService();

            $homeworkDetails = array();
            $idStudent = $allSessions['userId'];

            $studentDetails = $studentMappingRepository->fetchStudent($idStudent, $allSessions);

            if($studentDetails){

                $idStandard = $studentDetails->id_standard;

                if($studentDetails->id_first_language){
                    $subject[] = $studentDetails->id_first_language;
                }if($studentDetails->id_second_language){
                    $subject[] = $studentDetails->id_second_language;
                }if($studentDetails->id_third_language){
                    $subject[] = $studentDetails->id_third_language;
                }

                $electiveSubjects = $studentElectivesRepository->fetchStudentSubjects($idStudent, $allSessions);

                foreach ($electiveSubjects as $elective){

                    if($elective->id_elective){
                        $subject[] = $elective->id_elective;
                    }
                }

                $homeworks = $homeworkRepository->fetchHomeworkByStandard($idStandard, $allSessions);

                foreach ($homeworks as $details){
                    $resubmission = '';
                    $submission = '';
                    $resubmissionDate = '';
                    $resubmissionTime = '';
                    $resubmissionRequired = '';
                    $resubmissionDateTime = 0;
                    $standardName = $institutionStandardService->fetchStandardByUsingId($idStandard);
                    $subjectName =  $institutionSubjectService->getSubjectName($details->id_subject, $allSessions);
                    $staffDetails = $staffService->find($details->id_staff, $allSessions);
                    $fromDate = Carbon::createFromFormat('Y-m-d', $details->start_date)->format('d/m/Y');
                    $toDate = Carbon::createFromFormat('Y-m-d', $details->end_date)->format('d/m/Y');

                    $data['id_student'] = $idStudent;
                    $data['id_homework'] = $details->id;
                    $permissionDetails = $homeworkSubmissionPermissionRepository->fetchActiveDetails($data);

                    if($permissionDetails){

                        $resubmissionRequired = $permissionDetails->resubmission_allowed;

                        if($resubmissionRequired == 'YES'){
                            $resubmissionDate = $permissionDetails->resubmission_date;
                            $resubmissionTime = $permissionDetails->resubmission_time;
                            $resubmissionDateTime = $resubmissionDate.' '.$resubmissionTime;
                            $resubmissionDateTime =  strtotime($resubmissionDateTime);
                        }
                    }

                    $currentDateTime = date("Y-m-d h:i A");
                    $homeworkDateTime = $details->end_date.' '.$details->end_time;
                    $homeworkDateTime =  strtotime($homeworkDateTime);
                    $currentDateTime =  strtotime($currentDateTime);

                    $homeworkSubmissionDetails = $homeworkSubmissionRepository->fetch($data);

                    if(count($homeworkSubmissionDetails)>0){

                        $submitted = 'YES';

                        if($resubmissionRequired == 'YES'){

                            if($resubmissionDateTime >= $currentDateTime){
                                $resubmission = 'show';
                            }else{
                                $resubmission = 'hide';
                            }
                            $submission = 'hide';

                        }else{
                            $resubmission = 'hide';
                            $submission = 'show';
                        }

                    }else{

                        $submitted = 'NO';

                        if($homeworkDateTime >= $currentDateTime){
                            $submission = 'show';
                            $resubmission = 'hide';

                        }else{
                            // dd($resubmissionDateTime.' '.$currentDateTime);
                            if($resubmissionDateTime >= $currentDateTime){
                                $resubmission = 'show';
                            }else{
                                $resubmission = 'hide';
                            }
                            $submission = 'hide';
                        }
                    }

                    $homeworkSubmissionDetails = $homeworkSubmissionRepository->fetchActiveDetails($data);

                    if($homeworkSubmissionDetails){
                        if($homeworkSubmissionDetails->obtained_marks != ''){
                            $resubmission = 'hide';
                            $submission = 'hide';
                        }
                    }

                    $homeworkImageDetails = $homeworkDetailRepository->fetch($details->id);
                    $subjectType = $institutionSubjectService->getSubjectLabel($details->id_subject, $allSessions);

                    if($subjectType->label == 'common'){

                        $homeworkDetails[] = array(
                            'id'=>$details->id,
                            'class_name'=>$standardName,
                            'subject_name'=>$subjectName,
                            'staff_name'=>$staffDetails->name,
                            'homework_name'=>$details->name,
                            'description'=>$details->description,
                            'from_date'=>$fromDate,
                            'to_date'=>$toDate,
                            'resubmission'=>$resubmission,
                            'submission'=>$submission,
                            'submitted'=>$submitted,
                            'submission_type'=>$details->submission_type,
                            'homeworkImageDetails'=>$homeworkImageDetails,
                            'id_student'=>$idStudent
                        );

                    }else{

                        if(\in_array($details->id_subject, $subject)){

                            $homeworkDetails[] = array(
                                'id'=>$details->id,
                                'class_name'=>$standardName,
                                'subject_name'=>$subjectName,
                                'staff_name'=>$staffDetails->name,
                                'homework_name'=>$details->name,
                                'description'=>$details->description,
                                'from_date'=>$fromDate,
                                'to_date'=>$toDate,
                                'resubmission'=>$resubmission,
                                'submission'=>$submission,
                                'submitted'=>$submitted,
                                'submission_type'=>$details->submission_type,
                                'homeworkImageDetails'=>$homeworkImageDetails,
                                'id_student'=>$idStudent
                            );
                        }
                    }
                }
            }

            return $homeworkDetails;
        }

        // Insert homework submisson
        public function add($homeworkSubmissionData){

            $homeworkSubmissionRepository = new HomeworkSubmissionRepository();
            $homeworkSubmissionDetailRepository = new HomeworkSubmissionDetailRepository();
            $uploadService = new UploadService();

            $idStudent = $homeworkSubmissionData->userId;

            $idHomework = $homeworkSubmissionData->id_homework;
            $homeworkSubmittedDate  = date('Y-m-d');
            $homeworkSubmittedTime  = date('H:i:s A');

            $data['id_student'] = $idStudent;
            $data['id_homework'] = $idHomework;
            $homeworkSubmissionDetails = $homeworkSubmissionRepository->fetch($data);

            if(count($homeworkSubmissionDetails)>0){
                $homeworkSubmissionRepository->delete($data);
            }

            $data = array(
                'id_student' => $idStudent,
                'id_homework' => $idHomework,
                'submitted_date' => $homeworkSubmittedDate,
                'submitted_time' => $homeworkSubmittedTime,
                'created_by' => Session::get('userId'),
                'created_at' => Carbon::now()
            );

            $storeData = $homeworkSubmissionRepository->store($data);

            if($storeData){

                $lastInsertedId = $storeData->id;

                if($homeworkSubmissionData->attachmentHomework){

                    foreach($homeworkSubmissionData->attachmentHomework as $attachment){

                        $path = 'Homework';
                        $attachmentHomework = $uploadService->fileUpload($attachment, $path);

                        $imageData = array(
                            'id_homework_submission' => $lastInsertedId,
                            'submitted_file' => $attachmentHomework,
                            'created_by' => Session::get('userId'),
                            'created_at' => Carbon::now()
                        );

                        $storeImageData = $homeworkSubmissionDetailRepository->store($imageData);
                    }
                }
            }

            if($storeData){
                $signal = 'success';
                $msg = 'Data Submitted successfully!';

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

        public function getStudentHomework($idHomework, $allSessions){

            $homeworkSubmissionRepository = new HomeworkSubmissionRepository();
            $homeworkRepository = new HomeworkRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $institutionSubjectService = new InstitutionSubjectService();
            $homeworkViewedDetailsRepository = new HomeworkViewedDetailsRepository();
            $homeworkSubmissionDetailRepository = new HomeworkSubmissionDetailRepository();
            $institutionSubjectRepository = new InstitutionSubjectRepository();
            $subjectService = new SubjectService();
            $subjectTypeRepository = new SubjectTypeRepository();

            $studentHomeworkDetails = array();
            $homeworkDetails = $homeworkRepository->fetch($idHomework);

            $homeworkData['standardId'] = $homeworkDetails->id_standard;
            $homeworkData['subjectId'] = $homeworkDetails->id_subject;
            $readReceipt = $homeworkDetails->read_receipt;

            $subjectType = $institutionSubjectService->getSubjectLabel($homeworkData['subjectId'], $allSessions);

            if($subjectType->label == 'common'){

                $studentDetails = $studentMappingRepository->fetchStudentUsingStandard($homeworkDetails->id_standard, $allSessions);

            }else{

                $studentDetails = $studentMappingRepository->fetchStudentUsingSubject($homeworkData, $allSessions);
            }

            $subjectName =  $institutionSubjectService->getSubjectName($homeworkDetails->id_subject, $allSessions);

            foreach ($studentDetails as $student){

                $data['id_student'] = $student->id_student;
                $data['id_homework'] = $idHomework;

                $homeworkSubmissionDetails = $homeworkSubmissionRepository->fetchActiveDetails($data);

                if($homeworkSubmissionDetails){
                    $submittedDate = Carbon::createFromFormat('Y-m-d', $homeworkSubmissionDetails->submitted_date)->format('d-m-Y');
                    $submittedTime = $homeworkSubmissionDetails->submitted_time;
                }else{
                    $submittedDate = '';
                    $submittedTime = '';
                }

                $currentDateTime = date("Y-m-d h:i A");
                $homeworkDateTime = $homeworkDetails->end_date.' '.$homeworkDetails->end_time;
                $currentDateTime =  strtotime($currentDateTime);
                $homeworkDateTime =  strtotime($homeworkDateTime);

                $homeworkSubmittedFiles = $homeworkSubmissionDetailRepository->fetch($data);

                if(count($homeworkSubmittedFiles)>0){
                    $status = 'submitted';
                }else{
                    if($homeworkDateTime >= $currentDateTime){
                        $status = 'not-submitted';
                    }else{
                        $status = 'due-date-crossed';
                    }
                }

                if($readReceipt == 'YES'){

                    $homeworkViewDetails = $homeworkViewedDetailsRepository->fetch($data);

                    if($homeworkViewDetails){
                        $viewCount = $homeworkViewDetails->view_count;
                    }else{
                        $viewCount = 0;
                    }

                }else{
                    $viewCount ='Not Applicable';
                }

                $studentName = $studentMappingRepository->getFullName($student->name, $student->middle_name, $student->last_name);

                $studentHomeworkDetails[] = array(
                    'id'=>$student->id_student,
                    'id_homework'=>$idHomework,
                    //'student_name'=>$student->name,
                    'student_name'=>$studentName,
                    'submitted_date'=>$submittedDate,
                    'submitted_time'=>$submittedTime,
                    'status'=>$status,
                    'view_count'=>$viewCount,
                );
            }

            return $studentHomeworkDetails;
        }

        public function downloadHomeworkSubmittedFiles($idStudent, $idHomework){

            $homeworkSubmissionDetailRepository = new HomeworkSubmissionDetailRepository();
            $data['id_student'] = $idStudent;
            $data['id_homework'] = $idHomework;

            $zip = new ZipArchive;
            $fileName = 'myNewFile_'.time().'.zip';
            $zip->open($fileName, \ZipArchive::CREATE);

            $homeworkSubmittedFiles = $homeworkSubmissionDetailRepository->fetch($data);

            foreach ($homeworkSubmittedFiles as $file){
                $files = explode('Homework/', $file->submitted_file);
                $zip->addFromString($files[1], file_get_contents($file->submitted_file));
            }

            $zip->close();
            header('Content-disposition: attachment; filename='.time().'.zip');
            header('Content-type: application/zip');
            readfile($fileName);
        }

        public function fetchHomeworkValuationDetails($details, $allSessions){

            $homeworkSubmissionRepository = new HomeworkSubmissionRepository();
            $institutionSubjectService = new InstitutionSubjectService();
            $homeworkSubmissionPermissionRepository = new HomeworkSubmissionPermissionRepository();
            $homeworkRepository = new HomeworkRepository();
            $staffService = new StaffService();

            $data['id_student'] = $details->studentId;
            $data['id_homework'] = $details->homeworkId;

            $homeworkDetails = array();
            $resubmissionAllowed = 'NO';
            $resubmissionDate = date('d/m/Y');
            $resubmissionTime = '';
            $homeworkSubmissionId = '';
            $homeworkObtainedMarks = '';
            $homeworkComments = '';

            $homework = $homeworkRepository->fetch($data['id_homework']);
            $homeworkSubmissionDetails = $homeworkSubmissionRepository->fetchActiveDetails($data);

            if($homeworkSubmissionDetails){
                $homeworkSubmissionId = $homeworkSubmissionDetails->id;
                $homeworkObtainedMarks = $homeworkSubmissionDetails->obtained_marks;
                $homeworkComments = $homeworkSubmissionDetails->comments;
            }

            $subjectName =  $institutionSubjectService->getSubjectName($homework->id_subject, $allSessions);
            $staffDetails = $staffService->find($homework->id_staff, $allSessions);
            $gradeValue = explode(',' , $homework->grade);

            $permissionDetails = $homeworkSubmissionPermissionRepository->fetchActiveDetails($data);

            if($permissionDetails){

                $resubmissionAllowed = $permissionDetails->resubmission_allowed;

                if($resubmissionAllowed == 'YES'){
                    $resubmissionDate = Carbon::createFromFormat('Y-m-d', $permissionDetails->resubmission_date)->format('d/m/Y');
                    $resubmissionTime = $permissionDetails->resubmission_time;
                }
            }

            $homeworkDetails = array(
                'id'=>$homework->id,
                'subject_name'=>$subjectName,
                'staff_name'=>$staffDetails->name,
                'homework_name'=>$homework->name,
                'submission_type'=>$homework->submission_type,
                'grading_required'=>$homework->grading_required,
                'grading_option'=>$homework->grading_option,
                'grade'=>$homework->grade,
                'marks'=>$homework->marks,
                'grade_values'=>$gradeValue,
                'id_homework_submission'=>$homeworkSubmissionId,
                'obtained_marks'=>$homeworkObtainedMarks,
                'comments'=>$homeworkComments,
                'resubmission_allowed'=>$resubmissionAllowed,
                'resubmission_date'=>$resubmissionDate,
                'resubmission_time'=>$resubmissionTime
            );

            return $homeworkDetails;
        }

        public function fetchHomeworkVerifiedDetails($details, $allSessions){

            $homeworkSubmissionRepository = new HomeworkSubmissionRepository();
            $institutionSubjectService = new InstitutionSubjectService();
            $homeworkRepository = new HomeworkRepository();
            $staffService = new StaffService();

            $data['id_student'] = $details->studentId;
            $data['id_homework'] = $details->homeworkId;

            $homeworkDetails = array();
            $valuationDetails = array();

            $homework = $homeworkRepository->fetch($data['id_homework']);
            $homeworkSubmissionDetails = $homeworkSubmissionRepository->fetch($data);
            $subjectName =  $institutionSubjectService->getSubjectName($homework->id_subject, $allSessions);
            $staffDetails = $staffService->find($homework->id_staff, $allSessions);
            $gradeValue = explode(',' , $homework->grade);

            foreach($homeworkSubmissionDetails as $homeworks){

                $valuationDetails[] = array(
                    'obtained_marks'=>$homeworks->obtained_marks,
                    'comments'=>$homeworks->comments
                );
            }

            $homeworkDetails = array(
                'id'=>$homework->id,
                'subject_name'=>$subjectName,
                'staff_name'=>$staffDetails->name,
                'homework_name'=>$homework->name,
                'valuation_details'=>$valuationDetails
            );

            return $homeworkDetails;
        }

        public function update($valuationData, $id){

            $homeworkSubmissionRepository = new HomeworkSubmissionRepository();
            $homeworkSubmissionPermissionRepository = new HomeworkSubmissionPermissionRepository();
            $resubmissionAllowed = 'NO';
            $resubmissionDate = '';
            $resubmissionTime = '';
            $obtainedMark = '';
            $comment = '';

            if($valuationData->resubmissionAllowed){
                $resubmissionAllowed = $valuationData->resubmissionAllowed;
            }

            if($resubmissionAllowed == 'YES'){

                $resubmissionDate = Carbon::createFromFormat('d/m/Y', $valuationData->resubmissionDate)->format('Y-m-d');
                $resubmissionTime = $valuationData->resubmissionTime;

            }else{

                if($valuationData->obtained_mark){
                    $obtainedMark = $valuationData->obtained_mark;
                }

                if($valuationData->grade_obtained){
                    $obtainedMark = $valuationData->grade_obtained;
                }
            }

            if($valuationData->comment){
                $comment = $valuationData->comment;
            }else{
                $comment = '';
            }

            $homeworkValuationDetails = $homeworkSubmissionRepository->fetchData($id);
            $homeworkValuationDetails = $homeworkSubmissionRepository->fetchData($id);
            $homeworkId = $homeworkValuationDetails->id_homework;
            $studentId = $homeworkValuationDetails->id_student;

            $permissionDetails = HomeworkSubmissionPermission::where('id_homework',$homeworkId)->where('id_student',$studentId)->first();

            if($permissionDetails){
                $permissionDelete = $homeworkSubmissionPermissionRepository->delete($permissionDetails->id);
            }

            $details = array(
                'id_homework'=>$homeworkId,
                'id_student'=>$studentId,
                'resubmission_allowed'=>$resubmissionAllowed,
                'resubmission_date'=>$resubmissionDate,
                'resubmission_time'=>$resubmissionTime,
                'created_by' => Session::get('userId'),
                'created_at' => Carbon::now()
            );

            $insert = $homeworkSubmissionPermissionRepository->store($details);
            $homeworkValuationDetails->obtained_marks = $obtainedMark;
            $homeworkValuationDetails->comments	 = $comment;
            $homeworkValuationDetails->modified_by = Session::get('userId');
            $homeworkValuationDetails->updated_at = Carbon::now();

            $updateData = $homeworkSubmissionRepository->update($homeworkValuationDetails);

            if($updateData){
                $signal = 'success';
                $msg = 'Data Inserted successfully!';

            }else{
                $signal = 'failure';
                $msg = 'Error updating data!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
?>
