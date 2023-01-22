<?php
    namespace App\Services;

    use App\Models\Homework;
    use App\Services\HomeworkService;
    use App\Services\InstitutionSubjectService;
    use App\Services\StaffService;
    use App\Services\UploadService;
    use App\Services\StandardSubjectService;
    use App\Services\HomeworkViewedDetailsService;
    use App\Repositories\HomeworkRepository;
    use App\Repositories\StaffSubjectMappingRepository;
    use App\Repositories\HomeworkDetailRepository;
    use App\Repositories\StandardSubjectRepository;
    use App\Repositories\StandardSubjectStaffMappingRepository;
    use App\Repositories\StaffRepository;
    use App\Repositories\HomeworkSubmissionPermissionRepository;
    use Carbon\Carbon;
    use Session;
    use ZipArchive;

    class HomeworkService {

        // Get all subjects
        public function allSubject($idStandard, $allSessions){

            $standardSubjectRepository = new StandardSubjectRepository();
            $standardSubjectStaffMappingRepository = new StandardSubjectStaffMappingRepository();
            
            $idStaff = $allSessions['userId'];
            $role = $allSessions['role'];

            if($role == 'admin' || $role == 'superadmin'){
                $allSubjects = $standardSubjectRepository->fetchStandardSubjects($idStandard, $allSessions);
            }else{
                $allSubjects = $standardSubjectStaffMappingRepository->fetchStandardStaffSubjects($idStandard, $idStaff, $allSessions);
            }

            return $allSubjects;
        }

        // Get all staff
        public function allStaff($subjectId){

            $staffSubjectMappingRepository = new StaffSubjectMappingRepository();

            $allStaffs = $staffSubjectMappingRepository->allStaffs($subjectId);
            return $allStaffs;
        }

        // Get all homework
        public function getAll($allSessions){

            $homeworkRepository = new HomeworkRepository();
            $homeworkDetailRepository = new HomeworkDetailRepository();
            $institutionStandardService = new InstitutionStandardService();
            $institutionSubjectService = new InstitutionSubjectService();
            $staffService = new StaffService();

            $homeworkDetails = array();

            $idStaff = $allSessions['userId'];
            $role = $allSessions['role'];

            if($role == 'admin' || $role == 'superadmin'){
                $homeworkDetail = $homeworkRepository->all($allSessions);
            }else{
                $homeworkDetail = $homeworkRepository->fetchHomeworkUsingStaff($idStaff, $allSessions);
            }

            foreach($homeworkDetail as  $details){

                $standardName = $institutionStandardService->fetchStandardByUsingId($details->id_standard);
                $subjectName =  $institutionSubjectService->getSubjectName($details->id_subject, $allSessions);
                $staffDetails = $staffService->find($details->id_staff, $allSessions);
                $fromDate = Carbon::createFromFormat('Y-m-d', $details->start_date)->format('d/m/Y');
                $toDate = Carbon::createFromFormat('Y-m-d', $details->end_date)->format('d/m/Y');
                $homeworkImageDetail = $homeworkDetailRepository->fetch($details->id);

                if($homeworkImageDetail){
                    $status = 'file_found';
                }else{
                    $status = 'file_not_found';
                }

                if($staffDetails){
                    $staffName = $staffDetails->name;
                }else{
                    $staffName = "";
                }

                $homeworkDetails[] = array(
                    'id'=>$details->id,
                    'id_standard'=>$details->id_standard,
                    'class_name'=>$standardName,
                    'subject_name'=>$subjectName,
                    'staff_name'=>$staffName,
                    'homework_name'=>$details->name,
                    'description'=>$details->description,
                    'from_date'=>$fromDate,
                    'to_date'=>$toDate,
                    'homeworkImageDetails'=>$homeworkImageDetail,
                    'status'=>$status
                );
            }
            //dd($homeworkDetails);
            return $homeworkDetails;
        }

        // Get particular homework
        // public function find($id){

        //     $homeworkRepository = new HomeworkRepository();

        //     $homework = $homeworkRepository->fetch($id);
        //     return $homework;
        // }

        public function getHomeworkSelectedData($idHomework){

            $homeworkRepository = new HomeworkRepository();
            $homeworkDetailRepository = new HomeworkDetailRepository();
            $institutionStandardService = new InstitutionStandardService();
            $institutionSubjectService = new InstitutionSubjectService();
            $homeworkSubmissionPermissionRepository = new HomeworkSubmissionPermissionRepository();
            $staffService = new StaffService();

            $homeworkAttachment = array();
            $homeworkData = $homeworkRepository->fetch($idHomework);
            $homeworkAttachments = $homeworkDetailRepository->fetch($idHomework);

            $standardName = $institutionStandardService->fetchStandardByUsingId($homeworkData->id_standard);
            $subjectName =  $institutionSubjectService->getSubjectName($homeworkData->id_subject);
            $staffDetails = $staffService->find($homeworkData->id_staff);

            foreach($homeworkAttachments as $key => $attachment){
                $ext = pathinfo($attachment['file_url'], PATHINFO_EXTENSION);
                $homeworkAttachment[$key] = $attachment;
                $homeworkAttachment[$key]['extension'] = $ext;
            }

            $output = array(
                'homeworkData' => $homeworkData,
                'homeworkAttachment' => $homeworkAttachment,
                'className'=>$standardName,
                'subjectName'=>$subjectName,
                'staffName'=>$staffDetails->name,
            );
            //dd($output);
            return $output;
        }

        // Get homework details
        public function fetchDetails($data, $allSessions){

            $homeworkDetailRepository = new HomeworkDetailRepository();
            $institutionStandardService = new InstitutionStandardService();
            $institutionSubjectService = new InstitutionSubjectService();
            $homeworkViewedDetailsService = new HomeworkViewedDetailsService();
            $staffService = new StaffService();
            $homeworkRepository = new HomeworkRepository();
            $homeworkSubmissionPermissionRepository = new HomeworkSubmissionPermissionRepository();

            $homeworkDetails = array();

            $id = $data->homeworkId;
            $loginType = $data->login_type;

            $allSessions = session()->all();
            $idStudent = $allSessions['userId'];
            $data['id_student'] = $idStudent;
            $data['id_homework'] = $id;
            $resubmissionRequired = 'NO';
            $resubmissionDate = '';
            $resubmissionTime = '';

            if($loginType == 'student'){
                $homeworkViewedDetailsService->updateViewStatus($data);
            }

            $permissionDetails = $homeworkSubmissionPermissionRepository->fetchActiveDetails($data);

            if($permissionDetails){

                $resubmissionRequired = $permissionDetails->resubmission_allowed;

                if($resubmissionRequired == 'YES'){
                    $resubmissionDate = Carbon::createFromFormat('Y-m-d', $permissionDetails->resubmission_date)->format('d-m-Y');
                    $resubmissionTime = $permissionDetails->resubmission_time;
                }
            }

            $homework = $homeworkRepository->fetch($id);
            $standardName = $institutionStandardService->fetchStandardByUsingId($homework->id_standard);
            $subjectName =  $institutionSubjectService->getSubjectName($homework->id_subject, $allSessions);
            $staffDetails = $staffService->find($homework->id_staff, $allSessions);
            $fromDate = Carbon::createFromFormat('Y-m-d', $homework->start_date)->format('d/m/Y');
            $toDate = Carbon::createFromFormat('Y-m-d', $homework->end_date)->format('d/m/Y');

            $homeworkImageDetails = $homeworkDetailRepository->fetch($homework->id);

            $gradeValue = explode(',' , $homework->grade);

            $homeworkDetails = array(
                'id'=>$homework->id,
                'class_name'=>$standardName,
                'subject_name'=>$subjectName,
                'staff_name'=>$staffDetails->name,
                'homework_name'=>$homework->name,
                'description'=>$homework->description,
                'from_date'=>$fromDate,
                'to_date'=>$toDate,
                'chapter_name'=>$homework->chapter_name,
                'start_time'=>$homework->start_time,
                'end_time'=>$homework->end_time,
                'submission_type'=>$homework->submission_type,
                'grading_required'=>$homework->grading_required,
                'grading_option'=>$homework->grading_option,
                'grade'=>$homework->grade,
                'marks'=>$homework->marks,
                'read_receipt'=>$homework->read_receipt,
                'sms_alert'=>$homework->sms_alert,
                'resubmission_required'=>$resubmissionRequired,
                'resubmission_date'=>$resubmissionDate,
                'resubmission_time'=>$resubmissionTime,
                'grade_values'=>$gradeValue
            );

            return $homeworkDetails;
        }

        // Insert homework
        public function add($homeworkData){

            $homeworkRepository = new HomeworkRepository();
            $homeworkDetailRepository = new HomeworkDetailRepository();
            $uploadService = new UploadService();
            
            $institutionId = $homeworkData->id_institute;
            $academicYear = $homeworkData->id_academic;

            $homeworkClass = $homeworkData->homework_class;
            $homeworkSubject = $homeworkData->homework_subject;
            $homeworkStaff = $homeworkData->homework_staff;
            $homeworkName = $homeworkData->homework_name;
            $homeworkDetails = $homeworkData->homework_details;
            $homeworkChapterName = $homeworkData->homework_chapter_name;
            $homeworkStartTime = $homeworkData->homework_start_time;
            $homeworkEndTime = $homeworkData->homework_end_time;
            $submissionType = $homeworkData->submission_type;
            $gradingRequired = $homeworkData->grading_required;
            $gradingOption = '';
            $homeworkGrade = '';
            $homeworkMark = '';

            if($gradingRequired == 'YES'){

                $gradingOption = $homeworkData->grading_option;

                if($gradingOption == 'GRADE'){
                    $homeworkGrade = $homeworkData->homework_grade;
                }else if($gradingOption == 'MARKS'){
                    $homeworkMark = $homeworkData->homework_mark;
                }
            }

            $readReceipt = $homeworkData->read_receipt;
            $smsAlert = $homeworkData->sms_alert;

            $homeworkStartDate = Carbon::createFromFormat('d/m/Y', $homeworkData->homework_start_date)->format('Y-m-d');
            $homeworkEndDate = Carbon::createFromFormat('d/m/Y', $homeworkData->homework_end_date)->format('Y-m-d');

            $check = Homework::where('id_institute', $institutionId)->where('id_academic', $academicYear)->where('id_standard', $homeworkClass)->where('id_subject', $homeworkSubject)->where('id_staff', $homeworkStaff)->where('name', $homeworkName)->first();

            if(!$check){

                $data = array(
                    'id_institute' => $institutionId,
                    'id_academic' => $academicYear,
                    'id_standard' => $homeworkClass,
                    'id_subject' => $homeworkSubject,
                    'id_staff' => $homeworkStaff,
                    'name' => $homeworkName,
                    'start_date' => $homeworkStartDate,
                    'end_date' => $homeworkEndDate,
                    'description' => $homeworkDetails,
                    'chapter_name' => $homeworkChapterName,
                    'start_time' => $homeworkStartTime,
                    'end_time' => $homeworkEndTime,
                    'submission_type' => $submissionType,
                    'grading_required' => $gradingRequired,
                    'grading_option' => $gradingOption,
                    'grade' => $homeworkGrade,
                    'marks' => $homeworkMark,
                    'read_receipt' => $readReceipt,
                    'sms_alert' => $smsAlert,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );
                $storeData = $homeworkRepository->store($data);

                if($storeData){

                    $lastInsertedId = $storeData->id;

                    if($homeworkData->attachmentHomework){

                        foreach($homeworkData->attachmentHomework as $attachment){

                            $path = 'Homework';
                            $attachmentHomework = $uploadService->fileUpload($attachment, $path);

                            $data = array(
                                'id_homework' => $lastInsertedId,
                                'file_url' => $attachmentHomework,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );
                            $homeworkDetailRepository->store($data);
                        }
                    };

                    $signal = 'success';
                    $msg = 'Data inserted successfully!';

                }else{
                    $signal = 'failure';
                    $msg = 'Error inserting data!';
                }

            }else{
                $signal = 'exist';
                $msg = 'This data already exists!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Update homework
        public function update($homeworkData, $id){

            $uploadService = new UploadService();
            $homeworkRepository = new HomeworkRepository();
            $homeworkDetailRepository = new HomeworkDetailRepository();

            $institutionId = $homeworkData->id_institute;
            $academicYear = $homeworkData->id_academic;

            $homeworkClass = $homeworkData->homework_class;
            $homeworkSubject = $homeworkData->homework_subject;
            $homeworkStaff = $homeworkData->homework_staff;
            $homeworkName = $homeworkData->homework_name;
            $homeworkDetail = $homeworkData->homework_details;
            $homeworkChapterName = $homeworkData->homework_chapter_name;
            $homeworkStartTime = $homeworkData->homework_start_time;
            $homeworkEndTime = $homeworkData->homework_end_time;
            $submissionType = $homeworkData->submission_type;
            $gradingRequired = $homeworkData->grading_required;
            $gradingOption = '';
            $homeworkGrade = '';
            $homeworkMark = '';

            if($gradingRequired == 'YES'){

                $gradingOption = $homeworkData->grading_option;

                if($gradingOption == 'GRADE'){
                    $homeworkGrade = $homeworkData->homework_grade;
                }else if($gradingOption == 'MARKS'){
                    $homeworkMark = $homeworkData->homework_mark;
                }
            }

            $readReceipt = $homeworkData->read_receipt;
            $smsAlert = $homeworkData->sms_alert;
            $homeworkStartDate = Carbon::createFromFormat('d/m/Y', $homeworkData->homework_start_date)->format('Y-m-d');
            $homeworkEndDate = Carbon::createFromFormat('d/m/Y', $homeworkData->homework_end_date)->format('Y-m-d');

            $check = Homework::where('id_institute', $institutionId)
                            ->where('id_academic', $academicYear)
                            ->where('id_standard', $homeworkClass)
                            ->where('id_subject', $homeworkSubject)
                            ->where('id_staff', $homeworkStaff)
                            ->where('name', $homeworkName)
                            ->where('id', '!=', $id)
                            ->first();

            if(!$check){

                $homeworkDetails = $homeworkRepository->fetch($id);

                $homeworkDetails->id_standard = $homeworkClass;
                $homeworkDetails->id_subject = $homeworkSubject;
                $homeworkDetails->id_staff = $homeworkStaff;
                $homeworkDetails->name = $homeworkName;
                $homeworkDetails->description = $homeworkDetail;
                $homeworkDetails->start_date = $homeworkStartDate;
                $homeworkDetails->end_date = $homeworkEndDate;
                $homeworkDetails->chapter_name = $homeworkChapterName;
                $homeworkDetails->start_time = $homeworkStartTime;
                $homeworkDetails->end_time = $homeworkEndTime;
                $homeworkDetails->submission_type = $submissionType;
                $homeworkDetails->grading_required = $gradingRequired;
                $homeworkDetails->grading_option = $gradingOption;
                $homeworkDetails->grade = $homeworkGrade;
                $homeworkDetails->marks = $homeworkMark;
                $homeworkDetails->read_receipt = $readReceipt;
                $homeworkDetails->sms_alert = $smsAlert;
                $homeworkDetails->modified_by = Session::get('userId');
                $homeworkDetails->updated_at = Carbon::now();

                $updateData = $homeworkRepository->update($homeworkDetails);

                if($updateData){

                    $lastInsertedId = $id;

                    if($homeworkData->attachmentHomework){

                        $homeworkDetailRepository->delete($lastInsertedId);

                        foreach($homeworkData->attachmentHomework as $attachment){

                            $path = 'Homework';
                            $attachmentHomework = $uploadService->fileUpload($attachment, $path);

                            $data = array(
                                'id_homework' => $lastInsertedId,
                                'file_url' => $attachmentHomework,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );
                            $homeworkDetailRepository->store($data);
                        }
                    };

                    $signal = 'success';
                    $msg = 'Data updated successfully!';

                }else{
                    $signal = 'failure';
                    $msg = 'Error updating data!';
                }

            }else{
                $signal = 'exist';
                $msg = 'This data already exists!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Delete homework
        public function delete($id){

            $homeworkRepository = new HomeworkRepository();

            $homework = $homeworkRepository->delete($id);

            if($homework){
                $signal = 'success';
                $msg = 'Homework deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function getDetails($data, $allSessions){

            $institutionStandardService = new InstitutionStandardService();
            $standardSubjectService = new StandardSubjectService();
            $standardSubjectStaffMappingRepository = new StandardSubjectStaffMappingRepository();
            $staffRepository = new StaffRepository();

            $standardId = $data->id_standard;
            $subjectId = $data->id_subject;
            $staffs = array();

            $homeworkDetails['standard'] = $institutionStandardService->fetchStandard($allSessions);
            $homeworkDetails['subject'] = $standardSubjectService->fetchStandardSubjects($standardId, $allSessions);
            $staffSubjectDetails = $standardSubjectStaffMappingRepository->getStaffs($subjectId, $standardId, $allSessions);

            if($staffSubjectDetails){
                foreach($staffSubjectDetails as $index => $details){
                    $staffs[$index] = $staffRepository->fetch($details->id_staff);
                }
            }

            $homeworkDetails['staff'] = $staffs;

            return $homeworkDetails;
        }

        // Download homework attachment zip
        public function downloadHomeworkFiles($id, $type, $allSessions) {

            $homeworkDetailRepository = new HomeworkDetailRepository();
            $homeworkViewedDetailsService = new HomeworkViewedDetailsService();

            $idStudent = $allSessions['userId'];
            $data['id_student'] = $idStudent;
            $data['id_homework'] = $id;

            if($type == 'student'){
                $homeworkViewedDetailsService->updateViewStatus($data);
            }

            $zip = new ZipArchive;
            $fileName = 'myNewFile_'.time().'.zip';
            $zip->open($fileName, \ZipArchive::CREATE);

            $homeworkFiles = $homeworkDetailRepository->fetch($id);

            foreach ($homeworkFiles as $file){
                $files = explode('Homework/', $file->file_url);
                $zip->addFromString($files[1], file_get_contents($file->file_url));
            }

            $zip->close();
            header('Content-disposition: attachment; filename='.time().'.zip');
            header('Content-type: application/zip');
            readfile($fileName);
        }

        // Deleted homework records
        public function getDeletedRecords($allSessions){

            $homeworkRepository = new HomeworkRepository();

            $homeworkDetail = array();
            $homeworkData = $homeworkRepository->allDeleted($allSessions);

            foreach($homeworkData as $key => $data){

                $homeworkDetail[$key] = $data;
                $homeworkDetail[$key]['start_date'] = Carbon::createFromFormat('Y-m-d', $data->start_date)->format('d-m-Y');
                $homeworkDetail[$key]['end_date'] = Carbon::createFromFormat('Y-m-d', $data->end_date)->format('d-m-Y');
            }

            return $homeworkDetail;
        }

        // Restore homework records
        public function restore($id){

            $homeworkRepository = new HomeworkRepository();

            $homework = $homeworkRepository->restore($id);

            if($homework){
                $signal = 'success';
                $msg = 'Data restored successfully!';

            }else{
                $signal = 'failure';
                $msg = 'Data deletion is failed!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
?>
