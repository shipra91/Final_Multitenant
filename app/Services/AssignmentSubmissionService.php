<?php
    namespace App\Services;

    use App\Models\AssignmentSubmission;
    use App\Models\AssignmentSubmissionPermission;
    use App\Services\InstitutionSubjectService;
    use App\Services\StaffService;
    use App\Services\UploadService;
    use App\Services\StandardSubjectService;
    use App\Repositories\AssignmentSubmissionRepository;
    use App\Repositories\StaffSubjectMappingRepository;
    use App\Repositories\StandardSubjectRepository;
    use App\Repositories\AssignmentRepository;
    use App\Repositories\AssignmentDetailRepository;
    use App\Repositories\StandardSubjectStaffMappingRepository;
    use App\Repositories\StudentMappingRepository;
    use App\Repositories\StaffRepository;
    use App\Repositories\StudentElectivesRepository;
    use App\Repositories\AssignmentViewedDetailsRepository;
    use App\Repositories\AssignmentSubmissionDetailRepository;
    use App\Repositories\AssignmentSubmissionPermissionRepository;
    use Carbon\Carbon;
    use Session;
    use ZipArchive;

    class AssignmentSubmissionService
    {
        // Get All AssignmentSubmission
        public function getAll($idStudent, $allSessions) {
             
            $assignmentSubmissionRepository = new AssignmentSubmissionRepository();
            $assignmentDetailRepository = new AssignmentDetailRepository();
            $assignmentRepository = new AssignmentRepository();
            $institutionStandardService = new InstitutionStandardService();
            $institutionSubjectService = new InstitutionSubjectService();
            $staffService = new StaffService();
            $studentMappingRepository = new StudentMappingRepository();
            $studentElectivesRepository = new StudentElectivesRepository();
            $assignmentSubmissionPermissionRepository = new AssignmentSubmissionPermissionRepository();
            $assignmentDetails = array();
            $subject = array();
            
            $studentDetails = $studentMappingRepository->fetchStudent($idStudent, $allSessions);
            // dd($studentDetails);
            if($studentDetails){
                $idStandard = $studentDetails->id_standard;

                if($studentDetails->id_first_language)
                {
                    $subject[] = $studentDetails->id_first_language;
                } 
                if($studentDetails->id_second_language)
                {
                    $subject[] = $studentDetails->id_second_language;
                }
                if($studentDetails->id_third_language)
                {
                    $subject[] = $studentDetails->id_third_language;
                }

                $electiveSubjects = $studentElectivesRepository->fetchStudentSubjects($idStudent, $allSessions);
                foreach ($electiveSubjects as $elective) {
                    if($elective->id_elective)
                    {
                        $subject[] = $elective->id_elective;
                    }
                }
          
                $assignments = $assignmentRepository->fetchAssignmentByStandard($idStandard, $allSessions);
                foreach ($assignments as $details) {
                    $submission = '';
                    $resubmissionDate = '';
                    $resubmissionTime = '';
                    $resubmissionRequired = 'NO';
                    $resubmissionDateTime = 0;

                    $standardName = $institutionStandardService->fetchStandardByUsingId($idStandard);
                    $subjectName =  $institutionSubjectService->getSubjectName($details->id_subject, $allSessions);
                    $staffDetails = $staffService->find($details->id_staff, $allSessions);
                    $staffName = $staffRepository->getFullName($staffDetails->name, $staffDetails->middle_name, $staffDetails->last_name);
                    
                    $fromDate = Carbon::createFromFormat('Y-m-d', $details->start_date)->format('d/m/Y');
                    $toDate = Carbon::createFromFormat('Y-m-d', $details->end_date)->format('d/m/Y');
                    $currentDate = date('Y-m-d');
                    $currentTime = date('h:i A');

                    $data['id_student'] = $idStudent;
                    $data['id_assignment'] = $details->id;

                    $permissionDetails = $assignmentSubmissionPermissionRepository->fetchActiveDetails($data);
                    if($permissionDetails){
                        $resubmissionRequired = $permissionDetails->resubmission_allowed;
                        if($resubmissionRequired == 'YES') {
                            $resubmissionDate = $permissionDetails->resubmission_date;
                            $resubmissionTime = $permissionDetails->resubmission_time;
                            $resubmissionDateTime = $resubmissionDate.' '.$resubmissionTime;
                            $resubmissionDateTime =  strtotime($resubmissionDateTime);
                        }
                    }

                    $currentDateTime = date("Y-m-d h:i A");
                    $assignmentDateTime = $details->end_date.' '.$details->end_time;
                    $assignmentDateTime =  strtotime($assignmentDateTime);
                    $currentDateTime =  strtotime($currentDateTime);

                    $assignmentSubmissionDetails = $assignmentSubmissionRepository->fetch($data);
                
                    if(count($assignmentSubmissionDetails)>0)
                    {
                        $submitted = 'YES';
                        if($resubmissionRequired == 'YES')
                        {
                            if($resubmissionDateTime >= $currentDateTime) {
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

                        if($assignmentDateTime >= $currentDateTime){
                            $submission = 'show';
                            $resubmission = 'hide';

                        }else{
                            //dd($resubmissionDateTime.' '.$currentDateTime);
                            if($resubmissionDateTime >= $currentDateTime){
                                $resubmission = 'show';
                            }else{
                                $resubmission = 'hide';
                            }

                            $submission = 'hide';
                        }                    
                    }
                    $assignmentSubmissionDetails = $assignmentSubmissionRepository->fetchActiveDetails($data);
                    if($assignmentSubmissionDetails) {
                        if($assignmentSubmissionDetails->obtained_marks != ''){
                            $resubmission = 'hide';
                            $submission = 'hide';
                        }
                    }
                    
                    $assignmentImageDetails = $assignmentDetailRepository->fetch($details->id);

                    $subjectType = $institutionSubjectService->getSubjectLabel($details->id_subject, $allSessions);

                    if($subjectType->label == 'common'){

                        $assignmentDetails[] = array(
                            'id'=>$details->id,
                            'class_name'=>$standardName,
                            'subject_name'=>$subjectName,
                            'staff_name'=>$staffName,
                            'assignment_name'=>$details->name,
                            'description'=>$details->description,
                            'from_date'=>$fromDate,
                            'to_date'=>$toDate,
                            'resubmission'=>$resubmission,
                            'submission'=>$submission,
                            'submitted'=>$submitted,
                            'submission_type'=>$details->submission_type,
                            'assignmentImageDetails'=>$assignmentImageDetails,
                            'id_student'=>$idStudent
                        );

                    }else{

                        if(\in_array($details->id_subject, $subject)){

                            $assignmentDetails[] = array(
                                'id'=>$details->id,
                                'class_name'=>$standardName,
                                'subject_name'=>$subjectName,
                                'staff_name'=>$staffName,
                                'assignment_name'=>$details->name,
                                'description'=>$details->description,
                                'from_date'=>$fromDate,
                                'to_date'=>$toDate,
                                'resubmission'=>$resubmission,
                                'submission'=>$submission,
                                'submitted'=>$submitted,
                                'submission_type'=>$details->submission_type,
                                'assignmentImageDetails'=>$assignmentImageDetails,
                                'id_student'=>$idStudent
                            );
                        }
                    }
                }
            }

            return $assignmentDetails;
        }

        // Insert assignment submisson
        public function add($assignmentSubmissionData){

            $assignmentSubmissionRepository = new AssignmentSubmissionRepository();
            $assignmentSubmissionDetailRepository = new AssignmentSubmissionDetailRepository();
            $uploadService = new UploadService();

            $idStudent = Session::get('userId');
            $idAssignment = $assignmentSubmissionData->id_assignment;

            $assignmentSubmittedDate  = date('Y-m-d');
            $assignmentSubmittedTime  = date('H:i:s A');

            $data['id_student'] = $idStudent;
            $data['id_assignment'] = $idAssignment;
            $assignmentSubmissionDetails = $assignmentSubmissionRepository->fetch($data);

            if(count($assignmentSubmissionDetails)>0){
                $assignmentSubmissionRepository->delete($data);
            }

            $data = array(
                'id_student' => $idStudent,
                'id_assignment' => $idAssignment,
                'submitted_date' => $assignmentSubmittedDate,
                'submitted_time' => $assignmentSubmittedTime,
                'created_by' => Session::get('userId'),
                'created_at' => Carbon::now()
            );
            $storeData = $assignmentSubmissionRepository->store($data);

            if($storeData){

                $lastInsertedId = $storeData->id;

                if($assignmentSubmissionData->attachmentAssignment){

                    foreach($assignmentSubmissionData->attachmentAssignment as $attachment){

                        $path = 'Assignment';
                        $attachmentAssignment = $uploadService->fileUpload($attachment, $path);

                        $imageData = array(
                            'id_assignment_submission' => $lastInsertedId,
                            'submitted_file' => $attachmentAssignment,
                            'created_by' => Session::get('userId'),
                            'created_at' => Carbon::now()
                        );
                        $storeImageData = $assignmentSubmissionDetailRepository->store($imageData);
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

        public function getStudentAssignment($idAssignment, $allSessions) {
            
            $assignmentSubmissionRepository = new AssignmentSubmissionRepository();
            $assignmentRepository = new AssignmentRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $institutionSubjectService = new InstitutionSubjectService();
            $assignmentViewedDetailsRepository = new AssignmentViewedDetailsRepository();
            $assignmentSubmissionDetailRepository = new AssignmentSubmissionDetailRepository();
            $studentAssignmentDetails = array();
            $assignmentDetails = $assignmentRepository->fetch($idAssignment);

            $assignmentData['standardId'] = $assignmentDetails->id_standard;
            $assignmentData['subjectId'] = $assignmentDetails->id_subject;
        
            $subjectType = $institutionSubjectService->getSubjectLabel($assignmentData['subjectId'], $allSessions);
         
            if($subjectType->label == 'common') {
    
                $studentDetails = $studentMappingRepository->fetchStudentUsingStandard($assignmentDetails->id_standard, $allSessions);
    
            }else {

                $studentDetails = $studentMappingRepository->fetchStudentUsingSubject($assignmentData, $allSessions);
            }

            $subjectName =  $institutionSubjectService->getSubjectName($assignmentDetails->id_subject, $allSessions);

            foreach ($studentDetails as $student) {
                $data['id_student'] = $student->id_student;
                $data['id_assignment'] = $idAssignment;
                $assignmentSubmissionDetails = $assignmentSubmissionRepository->fetchActiveDetails($data);
                if($assignmentSubmissionDetails)
                {
                    $submittedDate = Carbon::createFromFormat('Y-m-d', $assignmentSubmissionDetails->submitted_date)->format('d-m-Y');
                    $submittedTime = $assignmentSubmissionDetails->submitted_time;
                }
                else
                {
                    $submittedDate = '';
                    $submittedTime = '';
                }
                $currentDateTime = date("Y-m-d h:i A");
                $assignmentDateTime = $assignmentDetails->end_date.' '.$assignmentDetails->end_time;
                $currentDateTime =  strtotime($currentDateTime);
                $assignmentDateTime =  strtotime($assignmentDateTime);
               
                $assignmentSubmittedFiles = $assignmentSubmissionDetailRepository->fetch($data);
              
                if(count($assignmentSubmittedFiles)>0)
                {
                    $status = 'submitted';
                }
                else
                {
                    if($assignmentDateTime >= $currentDateTime) {
                        $status = 'not-submitted';
                    }else{
                        $status = 'due-date-crossed';
                    }
                }

                $assignmentViewDetails = $assignmentViewedDetailsRepository->fetch($data);

                if($assignmentViewDetails){
                    $viewCount = $assignmentViewDetails->view_count;
                }else{
                    $viewCount = 0;
                }

                $studentName = $studentMappingRepository->getFullName($student->name, $student->middle_name, $student->last_name);

                $studentAssignmentDetails[] = array(
                    'id'=>$student->id_student,
                    'id_assignment'=>$idAssignment,
                    'student_name'=>$studentName,
                    'submitted_date'=>$submittedDate,
                    'submitted_time'=>$submittedTime,
                    'status'=>$status,
                    'view_count'=>$viewCount,
                );
            }

            return $studentAssignmentDetails;
        }

        public function downloadAssignmentSubmittedFiles($idStudent, $idAssignment){

            $assignmentSubmissionDetailRepository = new AssignmentSubmissionDetailRepository();

            $data['id_student'] = $idStudent;
            $data['id_assignment'] = $idAssignment;

            $zip = new ZipArchive;
            $fileName = 'myNewFile_'.time().'.zip';
            $zip->open($fileName, \ZipArchive::CREATE);

            $assignmentSubmittedFiles = $assignmentSubmissionDetailRepository->fetch($data);

            foreach ($assignmentSubmittedFiles as $file){
                $files = explode('Assignment/', $file->submitted_file);
                $zip->addFromString($files[1], file_get_contents($file->submitted_file));
            }

            $zip->close();
            header('Content-disposition: attachment; filename='.time().'.zip');
            header('Content-type: application/zip');
            readfile($fileName);
        }   

        public function fetchAssignmentValuationDetails($details, $allSessions) {
        
            $data['id_student'] = $details->studentId;
            $data['id_assignment'] = $details->assignmentId;
            $assignmentSubmissionRepository = new AssignmentSubmissionRepository();
            $institutionSubjectService = new InstitutionSubjectService();
            $assignmentRepository = new AssignmentRepository();
            $assignmentSubmissionPermissionRepository = new AssignmentSubmissionPermissionRepository();
            $staffService = new StaffService();

            $assignmentDetails = array();
            $assignmentSubmissionId = '';
            $assignmentSubmissionObtainedMarks = '';
            $assignmentSubmissionComments = '';
            $resubmissionAllowed = 'NO';
            $resubmissionDate = date('d/m/Y');
            $resubmissionTime = '';

            $data['id_student'] = $details->studentId;
            $data['id_assignment'] = $details->assignmentId;

            $assignment = $assignmentRepository->fetch($data['id_assignment']);
            $assignmentSubmissionDetails = $assignmentSubmissionRepository->fetchActiveDetails($data);

            if($assignmentSubmissionDetails){
                $assignmentSubmissionId = $assignmentSubmissionDetails->id;
                $assignmentSubmissionObtainedMarks = $assignmentSubmissionDetails->obtained_marks;
                $assignmentSubmissionComments = $assignmentSubmissionDetails->comments;
            }

            $subjectName =  $institutionSubjectService->getSubjectName($assignment->id_subject, $allSessions);
            $staffDetails = $staffService->find($assignment->id_staff, $allSessions);
            $gradeValue = explode(',' , $assignment->grade);

            $permissionDetails = $assignmentSubmissionPermissionRepository->fetchActiveDetails($data);
            if($permissionDetails){
                $resubmissionAllowed = $permissionDetails->resubmission_allowed;
                if($resubmissionAllowed == 'YES') {
                    $resubmissionDate = Carbon::createFromFormat('Y-m-d', $permissionDetails->resubmission_date)->format('d/m/Y');  
                    $resubmissionTime = $permissionDetails->resubmission_time;
                }
            }  

            $assignmentDetails = array(
                'id'=>$assignment->id,
                'subject_name'=>$subjectName,
                'staff_name'=>$staffDetails->name,
                'assignment_name'=>$assignment->name,
                'submission_type'=>$assignment->submission_type,
                'grading_required'=>$assignment->grading_required,
                'grading_option'=>$assignment->grading_option,
                'grade'=>$assignment->grade,
                'marks'=>$assignment->marks,
                'grade_values'=>$gradeValue,
                'id_assignment_submission'=>$assignmentSubmissionId,
                'obtained_marks'=>$assignmentSubmissionObtainedMarks,
                'comments'=>$assignmentSubmissionComments,
                'resubmission_allowed'=>$resubmissionAllowed,
                'resubmission_date'=>$resubmissionDate,
                'resubmission_time'=>$resubmissionTime
            );
            return $assignmentDetails;
        }

        public function fetchAssignmentVerifiedDetails($details, $allSessions) {
          
            $data['id_student'] = $details->studentId;
            $data['id_assignment'] = $details->assignmentId;
            $assignmentSubmissionRepository = new AssignmentSubmissionRepository();
            $institutionSubjectService = new InstitutionSubjectService();
            $assignmentRepository = new AssignmentRepository();
            $staffService = new StaffService();
            $assignmentDetails = array();           
            $valuationDetails = array();
            
            $assignment = $assignmentRepository->fetch($data['id_assignment']);
            $assignmentSubmissionDetails = $assignmentSubmissionRepository->fetch($data);
            $subjectName =  $institutionSubjectService->getSubjectName($assignment->id_subject, $allSessions);
            $staffDetails = $staffService->find($assignment->id_staff, $allSessions);
            $gradeValue = explode(',' , $assignment->grade);

            foreach($assignmentSubmissionDetails as $assignments) {
                $valuationDetails[] = array(
                    'obtained_marks'=>$assignments->obtained_marks,
                    'comments'=>$assignments->comments
                );
            }

            $assignmentDetails = array(
                'id'=>$assignment->id,
                'subject_name'=>$subjectName,
                'staff_name'=>$staffDetails->name,
                'assignment_name'=>$assignment->name,
                'valuation_details'=>$valuationDetails
            );

            return $assignmentDetails;
        }

        public function update($valuationData, $id){

            $assignmentSubmissionRepository = new AssignmentSubmissionRepository();
            $assignmentSubmissionPermissionRepository = new AssignmentSubmissionPermissionRepository();
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
            }

            $assignmentValuationDetails = $assignmentSubmissionRepository->fetchData($id);
            $assignmentId = $assignmentValuationDetails->id_assignment;
            $studentId = $assignmentValuationDetails->id_student;

            $permissionDetails = AssignmentSubmissionPermission::where('id_assignment',$assignmentId)->where('id_student',$studentId)->first();

            if($permissionDetails){
                $permissionDelete = $assignmentSubmissionPermissionRepository->delete($permissionDetails->id);
            }

            $details = array(
                'id_assignment'=>$assignmentId,
                'id_student'=>$studentId,
                'resubmission_allowed'=>$resubmissionAllowed,
                'resubmission_date'=>$resubmissionDate,
                'resubmission_time'=>$resubmissionTime,
                'created_by' => Session::get('userId'),
                'created_at' => Carbon::now()
            );

            $insert = $assignmentSubmissionPermissionRepository->store($details);

            $assignmentValuationDetails->obtained_marks = $obtainedMark;
            $assignmentValuationDetails->comments = $comment;
            $assignmentValuationDetails->modified_by = Session::get('userId');
            $assignmentValuationDetails->updated_at = Carbon::now();

            $updateData = $assignmentSubmissionRepository->update($assignmentValuationDetails);

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
