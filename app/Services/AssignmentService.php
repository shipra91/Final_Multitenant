<?php
    namespace App\Services;

    use App\Models\Assignment;
    use App\Repositories\AssignmentRepository;
    use App\Repositories\AssignmentDetailRepository;
    use App\Repositories\AssignmentSubmissionPermissionRepository;
    use App\Repositories\StaffSubjectMappingRepository;
    use App\Repositories\StandardSubjectRepository;
    use App\Repositories\StandardSubjectStaffMappingRepository;
    use App\Repositories\StaffRepository;
    use App\Repositories\SubjectTypeRepository;
    use App\Repositories\SubjectRepository;
    use App\Repositories\InstitutionSubjectRepository;
    use App\Services\InstitutionStandardService;
    use App\Services\InstitutionSubjectService;
    use App\Services\StaffService;
    use App\Services\UploadService;
    use App\Services\StandardSubjectService;
    use App\Services\SubjectService;
    use App\Services\AssignmentViewedDetailsService;
    use Carbon\Carbon;
    use Session;
    use ZipArchive;

    class AssignmentService {

        // Get all subjects
        public function allSubject($idStandard){

            $standardSubjectRepository = new StandardSubjectRepository();
            $standardSubjectStaffMappingRepository = new StandardSubjectStaffMappingRepository();
            $subjectService = new SubjectService();
            $subjectTypeRepository = new SubjectTypeRepository();
            $subjectRepository = new SubjectRepository();
            $subjectDetails=[];

            $allSessions = session()->all();
            $role = $allSessions['role'];
            $idStaff = $allSessions['userId'];

            if($role == 'admin' || $role == 'superadmin'){
                $allSubjects = $standardSubjectRepository->fetchStandardSubjects($idStandard);
            }else{
                $allSubjects = $standardSubjectStaffMappingRepository->fetchStandardStaffSubjects($idStandard, $idStaff);
            }

            foreach($allSubjects as $key => $subject){

                $subjectData = $subjectService->find($subject->id_subject);
                $type = $subjectTypeRepository->fetch($subjectData->id_type);
                $subjectNameCount = $subjectRepository->fetchSubjectNameCount($subjectData->name);

                if(count($subjectNameCount) > 1){
                    $subjectType = ' ( '.$type->display_name.' )';
                }else{
                    $subjectType = '';
                }

                $subjectDetails[$key] = array(
                    'id' => $subject->id_institution_subject,
                    'id_institution_subject' => $subject->id_institution_subject,
                    'id_subject' => $subject->id_subject,
                    'display_name' => $subject['display_name'].$subjectType,
                    'subject_type' => $subject->subject_type
                );
            }
            // dd($allSubjects);
            return $subjectDetails;
        }

        // Get all staff
        public function allStaff($subjectId){

            $staffSubjectMappingRepository = new StaffSubjectMappingRepository();

            $allStaffs = $staffSubjectMappingRepository->allStaffs($subjectId);
            return $allStaffs;
        }

        // Get all assignment
        public function getAll(){

            $assignmentRepository = new AssignmentRepository();
            $assignmentDetailRepository = new AssignmentDetailRepository();
            $institutionStandardService = new InstitutionStandardService();
            $institutionSubjectService = new InstitutionSubjectService();
            $staffService = new StaffService();

            $assignmentDetails = array();

            $allSessions = session()->all();
            $role = $allSessions['role'];
            $idStaff = $allSessions['userId'];

            if($role == 'admin' || $role == 'superadmin'){
                $assignmentDetail = $assignmentRepository->all();
            }else{
                $assignmentDetail = $assignmentRepository->fetchAssignmentUsingStaff($idStaff);
            }

            foreach($assignmentDetail as  $details){

                $standardName = $institutionStandardService->fetchStandardByUsingId($details->id_standard);
                $subjectName =  $institutionSubjectService->getSubjectName($details->id_subject);
                $staffDetails = $staffService->find($details->id_staff);
                $fromDate = Carbon::createFromFormat('Y-m-d', $details->start_date)->format('d/m/Y');
                $toDate = Carbon::createFromFormat('Y-m-d', $details->end_date)->format('d/m/Y');
                $assignmentImageDetail = $assignmentDetailRepository->fetch($details->id);

                if(count($assignmentImageDetail) > 0){
                    $status = 'file_found';
                }else{
                    $status = 'file_not_found';
                }

                if($staffDetails){
                    $staffName = $staffDetails->name;
                }else{
                    $staffName = '';
                }

                $assignmentDetails[] = array(
                    'id'=>$details->id,
                    'id_standard'=>$details->id_standard,
                    'class_name'=>$standardName,
                    'subject_name'=>$subjectName,
                    'staff_name'=>$staffName,
                    'assignment_name'=>$details->name,
                    'description'=>$details->description,
                    'from_date'=>$fromDate,
                    'to_date'=>$toDate,
                    'assignmentImageDetails'=>$assignmentImageDetail,
                    'status'=>$status
                );
            }
            // dd($assignmentDetails);
            return $assignmentDetails;
        }

        // Get particular assignment
        public function getAssignmentSelectedData($idAssignment){

            $assignmentRepository = new AssignmentRepository();
            $assignmentDetailRepository = new AssignmentDetailRepository();
            $staffRepository = new StaffRepository();
            $institutionStandardService = new InstitutionStandardService();
            $institutionSubjectService = new InstitutionSubjectService();
            $staffService = new StaffService();

            $assignmentAttachment = array();
            $assignmentData = $assignmentRepository->fetch($idAssignment);
            $assignmentAttachments = $assignmentDetailRepository->fetch($idAssignment);
            $standardName = $institutionStandardService->fetchStandardByUsingId($assignmentData->id_standard);
            $subjectName = $institutionSubjectService->getSubjectName($assignmentData->id_subject);
            $staffDetails = $staffService->find($assignmentData->id_staff);
            $staffName = $staffRepository->getFullName($staffDetails->name, $staffDetails->middle_name, $staffDetails->last_name);

            foreach($assignmentAttachments as $key => $attachment){
                $ext = pathinfo($attachment['file_url'], PATHINFO_EXTENSION);
                $assignmentAttachment[$key] = $attachment;
                $assignmentAttachment[$key]['extension'] = $ext;
            }

            $output = array(
                'assignmentData' => $assignmentData,
                'assignmentAttachment' => $assignmentAttachment,
                'className'=> $standardName,
                'subjectName'=> $subjectName,
                // 'staffName'=> $staffDetails->name,
                'staffName'=> $staffName,
            );
            //dd($output);
            return $output;
        }

        // Get assignment details
        public function fetchDetails($data){

            $assignmentDetailRepository = new AssignmentDetailRepository();
            $institutionStandardService = new InstitutionStandardService();
            $institutionSubjectService = new InstitutionSubjectService();
            $assignmentViewedDetailsService = new AssignmentViewedDetailsService();
            $staffService = new StaffService();
            $assignmentRepository = new AssignmentRepository();
            $assignmentSubmissionPermissionRepository = new AssignmentSubmissionPermissionRepository();

            $assignmentDetails = array();

            $id = $data->assignmentId;
            $loginType = $data->login_type;

            $allSessions = session()->all();
            $idStudent = $allSessions['userId'];

            $data['id_student'] = $idStudent;
            $data['id_assignment'] = $id;
            $resubmissionRequired = 'NO';
            $resubmissionDate = '';
            $resubmissionTime = '';

            if($loginType == 'student'){
                $assignmentViewedDetailsService->updateViewStatus($data);
            }

            $permissionDetails = $assignmentSubmissionPermissionRepository->fetchActiveDetails($data);

            if($permissionDetails){

                $resubmissionRequired = $permissionDetails->resubmission_allowed;

                if($resubmissionRequired == 'YES'){

                    $resubmissionDate = Carbon::createFromFormat('Y-m-d', $permissionDetails->resubmission_date)->format('d-m-Y');
                    $resubmissionTime = $permissionDetails->resubmission_time;
                }
            }

            $assignment = $assignmentRepository->fetch($id);

            $standardName = $institutionStandardService->fetchStandardByUsingId($assignment->id_standard);
            $subjectName =  $institutionSubjectService->getSubjectName($assignment->id_subject);
            $staffDetails = $staffService->find($assignment->id_staff);
            $fromDate = Carbon::createFromFormat('Y-m-d', $assignment->start_date)->format('d/m/Y');
            $toDate = Carbon::createFromFormat('Y-m-d', $assignment->end_date)->format('d/m/Y');

            $assignmentImageDetails = $assignmentDetailRepository->fetch($assignment->id);

            $gradeValue = explode(',' , $assignment->grade);

            $assignmentDetails = array(
                'id'=>$assignment->id,
                'class_name'=>$standardName,
                'subject_name'=>$subjectName,
                'staff_name'=>$staffDetails->name,
                'assignment_name'=>$assignment->name,
                'description'=>$assignment->description,
                'from_date'=>$fromDate,
                'to_date'=>$toDate,
                'chapter_name'=>$assignment->chapter_name,
                'start_time'=>$assignment->start_time,
                'end_time'=>$assignment->end_time,
                'submission_type'=>$assignment->submission_type,
                'grading_required'=>$assignment->grading_required,
                'grading_option'=>$assignment->grading_option,
                'grade'=>$assignment->grade,
                'marks'=>$assignment->marks,
                'read_receipt'=>$assignment->read_receipt,
                'sms_alert'=>$assignment->sms_alert,
                'grade_values'=>$gradeValue,
                'resubmission_required'=>$resubmissionRequired,
                'resubmission_date'=>$resubmissionDate,
                'resubmission_time'=>$resubmissionTime
            );

            return $assignmentDetails;
        }

        // Insert assignment
        public function add($assignmentData){

            $assignmentRepository = new AssignmentRepository();
            $assignmentDetailRepository = new AssignmentDetailRepository();
            $uploadService = new UploadService();

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $assignmentClass = $assignmentData->assignment_class;
            $assignmentSubject = $assignmentData->assignment_subject;
            $assignmentStaff = $assignmentData->assignment_staff;
            $assignmentName = $assignmentData->assignment_name;
            $assignmentDetails = $assignmentData->assignment_details;
            $assignmentChapterName = $assignmentData->assignment_chapter_name;
            $assignmentStartTime = $assignmentData->assignment_start_time;
            $assignmentEndTime = $assignmentData->assignment_end_time;
            $submissionType = $assignmentData->submission_type;
            $gradingRequired = $assignmentData->grading_required;
            $gradingOption = '';
            $assignmentGrade = '';
            $assignmentMark = '';

            if($gradingRequired == 'YES'){

                $gradingOption = $assignmentData->grading_option;

                if($gradingOption == 'GRADE'){
                    $assignmentGrade = $assignmentData->assignment_grade;
                }else if($gradingOption == 'MARKS'){
                    $assignmentMark = $assignmentData->assignment_mark;
                }
            }

            $readReceipt = $assignmentData->read_receipt;
            $smsAlert = $assignmentData->sms_alert;

            $assignmentStartDate = Carbon::createFromFormat('d/m/Y', $assignmentData->assignment_start_date)->format('Y-m-d');
            $assignmentEndDate = Carbon::createFromFormat('d/m/Y', $assignmentData->assignment_end_date)->format('Y-m-d');

            $check = Assignment::where('id_institute', $institutionId)->where('id_academic', $academicYear)->where('id_standard', $assignmentClass)->where('id_subject', $assignmentSubject)->where('id_staff', $assignmentStaff)->where('name', $assignmentName)->first();

            if(!$check){

                $data = array(
                    'id_institute' => $institutionId,
                    'id_academic' => $academicYear,
                    'id_standard' => $assignmentClass,
                    'id_subject' => $assignmentSubject,
                    'id_staff' => $assignmentStaff,
                    'name' => $assignmentName,
                    'start_date' => $assignmentStartDate,
                    'end_date' => $assignmentEndDate,
                    'description' => $assignmentDetails,
                    'chapter_name' => $assignmentChapterName,
                    'start_time' => $assignmentStartTime,
                    'end_time' => $assignmentEndTime,
                    'submission_type' => $submissionType,
                    'grading_required' => $gradingRequired,
                    'grading_option' => $gradingOption,
                    'grade' => $assignmentGrade,
                    'marks' => $assignmentMark,
                    'read_receipt' => $readReceipt,
                    'sms_alert' => $smsAlert,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );

                $storeData = $assignmentRepository->store($data);

                if($storeData){

                    $lastInsertedId = $storeData->id;

                    if($assignmentData->attachmentAssignment){

                        foreach($assignmentData->attachmentAssignment as $attachment){

                            $path = 'Assignment';
                            $attachmentAssignment = $uploadService->fileUpload($attachment, $path);

                            $data = array(
                                'id_assignment' => $lastInsertedId,
                                'file_url' => $attachmentAssignment,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );

                            $assignmentDetailRepository->store($data);
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

        // Update assignment
        public function update($assignmentData, $id){

            $uploadService = new UploadService();
            $assignmentRepository = new AssignmentRepository();
            $assignmentDetailRepository = new AssignmentDetailRepository();

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $assignmentClass = $assignmentData->assignment_class;
            $assignmentSubject = $assignmentData->assignment_subject;
            $assignmentStaff = $assignmentData->assignment_staff;
            $assignmentName = $assignmentData->assignment_name;
            $assignmentDetail = $assignmentData->assignment_details;
            $assignmentChapterName = $assignmentData->assignment_chapter_name;
            $assignmentStartTime = $assignmentData->assignment_start_time;
            $assignmentEndTime = $assignmentData->assignment_end_time;
            $submissionType = $assignmentData->submission_type;
            $gradingRequired = $assignmentData->grading_required;
            $gradingOption = '';
            $assignmentGrade = '';
            $assignmentMark = '';

            if($gradingRequired == 'YES'){

                $gradingOption = $assignmentData->grading_option;

                if($gradingOption == 'GRADE'){
                    $assignmentGrade = $assignmentData->assignment_grade;
                }else if($gradingOption == 'MARKS'){
                    $assignmentMark = $assignmentData->assignment_mark;
                }
            }

            $readReceipt = $assignmentData->read_receipt;
            $smsAlert = $assignmentData->sms_alert;

            $assignmentStartDate = Carbon::createFromFormat('d/m/Y', $assignmentData->assignment_start_date)->format('Y-m-d');
            $assignmentEndDate = Carbon::createFromFormat('d/m/Y', $assignmentData->assignment_end_date)->format('Y-m-d');

            $check = Assignment::where('id_institute', $institutionId)
                                ->where('id_academic', $academicYear)
                                ->where('id_standard', $assignmentClass)
                                ->where('id_subject', $assignmentSubject)
                                ->where('id_staff', $assignmentStaff)
                                ->where('name', $assignmentName)
                                ->where('id', '!=', $id)->first();

            if(!$check){

                $assignmentDetails = $assignmentRepository->fetch($id);
                $assignmentDetails->id_standard = $assignmentClass;
                $assignmentDetails->id_subject = $assignmentSubject;
                $assignmentDetails->id_staff = $assignmentStaff;
                $assignmentDetails->name = $assignmentName;
                $assignmentDetails->description = $assignmentDetail;
                $assignmentDetails->start_date = $assignmentStartDate;
                $assignmentDetails->end_date = $assignmentEndDate;
                $assignmentDetails->chapter_name = $assignmentChapterName;
                $assignmentDetails->start_time = $assignmentStartTime;
                $assignmentDetails->end_time = $assignmentEndTime;
                $assignmentDetails->submission_type = $submissionType;
                $assignmentDetails->grading_required = $gradingRequired;
                $assignmentDetails->grading_option = $gradingOption;
                $assignmentDetails->grade = $assignmentGrade;
                $assignmentDetails->marks = $assignmentMark;
                $assignmentDetails->read_receipt = $readReceipt;
                $assignmentDetails->sms_alert = $smsAlert;
                $assignmentDetails->modified_by = Session::get('userId');
                $assignmentDetails->updated_at = Carbon::now();

                $updateData = $assignmentRepository->update($assignmentDetails);

                if($updateData){

                    $lastInsertedId = $id;

                    if($assignmentData->attachmentAssignment){
                        //$assignmentDetailRepository->delete($lastInsertedId);
                        foreach($assignmentData->attachmentAssignment as $attachment){

                            $path = 'Assignment';
                            $attachmentAssignment = $uploadService->fileUpload($attachment, $path);

                            $data = array(
                                'id_assignment' => $lastInsertedId,
                                'file_url' => $attachmentAssignment,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );

                            $assignmentDetailRepository->store($data);
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

        // Delete assignment
        public function delete($id){

            $assignmentRepository = new AssignmentRepository();

            $assignment = $assignmentRepository->delete($id);

            if($assignment){
                $signal = 'success';
                $msg = 'Assignment deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function getDetails($data){

            $institutionStandardService = new InstitutionStandardService();
            $standardSubjectService = new StandardSubjectService();
            $standardSubjectStaffMappingRepository = new StandardSubjectStaffMappingRepository();
            $staffRepository = new StaffRepository();

            $standardId = $data->id_standard;
            $subjectId = $data->id_subject;

            $assignmentDetails['standard'] = $institutionStandardService->fetchStandard();
            $assignmentDetails['subject'] = $standardSubjectService->fetchStandardSubjects($standardId);
            $staffSubjectDetails = $standardSubjectStaffMappingRepository->getStaffs($subjectId, $standardId);

            foreach($staffSubjectDetails as $index => $details){
                $staffData = $staffRepository->fetch($details->id_staff);
                $staffs[$index] = $staffData;
                $staffs[$index]['name'] = $staffRepository->getFullName($staffData->name, $staffData->middle_name, $staffData->last_name);
            }

            $assignmentDetails['staff'] = $staffs;

            return $assignmentDetails;
        }

        // Download assignment attachment zip
        public function downloadAssignmentFiles($id, $type){

            $assignmentDetailRepository = new AssignmentDetailRepository();
            $assignmentViewedDetailsService = new AssignmentViewedDetailsService();

            $allSessions = session()->all();
            $idStudent = $allSessions['userId'];
            $data['id_student'] = $idStudent;
            $data['id_assignment'] = $id;

            if($type == 'student'){
                $assignmentViewedDetailsService->updateViewStatus($data);
            }

            $zip = new ZipArchive;
            $fileName = 'assignment_'.time().'.zip';
            $zip->open($fileName, \ZipArchive::CREATE);

            $assignmentFiles = $assignmentDetailRepository->fetch($id);

            foreach ($assignmentFiles as $file) {
                $files = explode('Assignment/', $file->file_url);
                $zip->addFromString($files[1], file_get_contents($file->file_url));
            }

            $zip->close();
            header('Content-disposition: attachment; filename='.time().'.zip');
            header('Content-type: application/zip');
            readfile($fileName);
        }

        // Deleted assignment records
        public function getDeletedRecords(){

            $assignmentRepository = new AssignmentRepository();

            $assignmentDetail = array();
            $assignmentData = $assignmentRepository->allDeleted();

            foreach($assignmentData as $key => $data){
                $assignmentDetail[$key] = $data;
                $assignmentDetail[$key]['start_date'] = Carbon::createFromFormat('Y-m-d', $data->start_date)->format('d-m-Y');
                $assignmentDetail[$key]['end_date'] = Carbon::createFromFormat('Y-m-d', $data->end_date)->format('d-m-Y');
            }

            return $assignmentDetail;
        }

        // Restore assignment records
        public function restore($id){

            $assignmentRepository = new AssignmentRepository();

            $assignment = $assignmentRepository->restore($id);

            if($assignment){
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

