<?php 
    namespace App\Services;
    use App\Models\ProjectSubmission;
    use App\Models\ProjectSubmissionPermission;
    use App\Services\InstitutionSubjectService;
    use App\Services\StaffService;
    use App\Services\UploadService;
    use App\Services\StandardSubjectService;
    use App\Repositories\ProjectSubmissionRepository;
    use App\Repositories\StaffSubjectMappingRepository;
    use App\Repositories\StandardSubjectRepository;
    use App\Repositories\ProjectRepository;
    use App\Repositories\ProjectDetailRepository;
    use App\Repositories\StandardSubjectStaffMappingRepository;
    use App\Repositories\StudentMappingRepository;
    use App\Repositories\StaffRepository;
    use App\Repositories\StudentElectivesRepository;
    use App\Repositories\ProjectSubmissionDetailRepository;
    use App\Repositories\ProjectAssignedStudentsRepository;
    use App\Repositories\ProjectSubmissionPermissionRepository;
    use Carbon\Carbon;
    use Session;
    use ZipArchive;

    class ProjectSubmissionService
    {
        // Get All ProjectSubmission
        public function getAll($allSessions) {
             
            $projectSubmissionRepository = new ProjectSubmissionRepository();
            $projectDetailRepository = new ProjectDetailRepository();
            $projectSubmissionPermissionRepository = new ProjectSubmissionPermissionRepository();
            $projectRepository = new ProjectRepository();
            $institutionStandardService = new InstitutionStandardService();
            $institutionSubjectService = new InstitutionSubjectService();
            $staffService = new StaffService();
            $studentMappingRepository = new StudentMappingRepository();
            $studentElectivesRepository = new StudentElectivesRepository();
            $projectDetails = array();
            $idStudent = $allSessions['userId'];

            $studentDetails = $studentMappingRepository->fetchStudent($idStudent, $allSessions);
            if($studentDetails) {
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
            
                $projects = $projectRepository->fetchProjectByStudent($idStudent, $allSessions);
                if(count($projects) > 0){
                    foreach ($projects as $details) {
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
                        $data['id_project'] = $details->id;
                        
                        $permissionDetails = $projectSubmissionPermissionRepository->fetchActiveDetails($data);
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
                        $projectDateTime = $details->end_date.' '.$details->end_time;
                        $projectDateTime =  strtotime($projectDateTime);
                        $currentDateTime =  strtotime($currentDateTime);

                        $projectSubmissionDetails = $projectSubmissionRepository->fetch($data);
                        if(count($projectSubmissionDetails)>0)
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
                            }
                            else
                            {
                                $resubmission = 'hide';
                                $submission = 'show';
                            }
                        }
                        else
                        {
                            $submitted = 'NO';
                            if($projectDateTime >= $currentDateTime) {
                                $submission = 'show';
                                $resubmission = 'hide';
                            
                            }else{
                            //    dd($resubmissionDateTime.' '.$currentDateTime);
                            
                                if($resubmissionDateTime >= $currentDateTime) {
                                    $resubmission = 'show';
                                }else{
                                    $resubmission = 'hide';
                                }

                                $submission = 'hide';
                            }
                        }

                        $projectSubmissionDetails = $projectSubmissionRepository->fetchActiveDetails($data);
                        if($projectSubmissionDetails) {
                            if($projectSubmissionDetails->obtained_marks != '') {
                                $resubmission = 'hide';
                                $submission = 'hide';
                            }
                        }

                        $projectImageDetails = $projectDetailRepository->fetch($details->id);
                        $projectDetails[] = array(
                                'id'=>$details->id,
                                'class_name'=>$standardName,
                                'subject_name'=>$subjectName,
                                'staff_name'=>$staffDetails->name,
                                'project_name'=>$details->name,
                                'description'=>$details->description,
                                'from_date'=>$fromDate,
                                'to_date'=>$toDate,
                                'resubmission'=>$resubmission,
                                'submission'=>$submission,
                                'submitted'=>$submitted,
                                'projectImageDetails'=>$projectImageDetails,
                                'id_student'=>$idStudent
                            );
                    }
                }
            }
            return $projectDetails;
        }

        // Add Project submisson details
        public function add($projectSubmissionData)
        { 
            $projectSubmissionRepository = new ProjectSubmissionRepository();
            $projectSubmissionDetailRepository = new ProjectSubmissionDetailRepository();
            
            $uploadService = new UploadService();

            $idStudent = Session::get('userId');
            $idProject = $projectSubmissionData->id_project;
            
            $projectSubmittedDate  = date('Y-m-d');
            $projectSubmittedTime  = date('H:i:s A');
            
            $data['id_student'] = $idStudent;
            $data['id_project'] = $idProject;
            $projectSubmissionDetails = $projectSubmissionRepository->fetch($data);
            if(count($projectSubmissionDetails)>0)
            {
                $projectSubmissionRepository->delete($data);
            }

            $data = array(
                'id_student' => $idStudent, 
                'id_project' => $idProject, 
                'submitted_date' => $projectSubmittedDate, 
                'submitted_time' => $projectSubmittedTime, 
                'created_by' => Session::get('userId'),
                'created_at' => Carbon::now()
            );
            $storeData = $projectSubmissionRepository->store($data); 

            if($storeData) {
                $lastInsertedId = $storeData->id;
                if($projectSubmissionData->attachmentProject)
                {
                    foreach($projectSubmissionData->attachmentProject as $attachment)
                    {   
                        $path = 'Project';
                        $attachmentProject = $uploadService->fileUpload($attachment, $path);

                        $imageData = array( 
                            'id_project_submission' => $lastInsertedId, 
                            'submitted_file' => $attachmentProject, 
                            'created_by' => Session::get('userId'),
                            'created_at' => Carbon::now()
                        );
                        $storeImageData = $projectSubmissionDetailRepository->store($imageData);  
                    }
                }
            }
            if($storeData) 
            {    
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

        public function getStudentProject($idProject, $allSessions) {
            
            $projectSubmissionRepository = new ProjectSubmissionRepository();
            $projectRepository = new ProjectRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $institutionSubjectService = new InstitutionSubjectService();
            $projectSubmissionDetailRepository = new ProjectSubmissionDetailRepository();
            $projectAssignedStudentsRepository = new ProjectAssignedStudentsRepository();
            $studentProjectDetails = array();
            $viewCount = 0; 
            $projectDetails = $projectRepository->fetch($idProject);

            $projectData['standardId'] = $projectDetails->id_standard;
            $projectData['subjectId'] = $projectDetails->id_subject;
            $readReceipt = $projectDetails->read_receipt;

            $projectAssignedStudentDetails = $projectAssignedStudentsRepository->fetch($idProject);
            $subjectName =  $institutionSubjectService->getSubjectName($projectDetails->id_subject, $allSessions);

            foreach ($projectAssignedStudentDetails as $studentDetails) {

                $student = $studentMappingRepository->fetchStudent($studentDetails->id_student, $allSessions);
                
                if($student) {
                    $data['id_student'] = $student->id_student;
                    $data['id_project'] = $idProject;
                    $projectSubmissionDetails = $projectSubmissionRepository->fetchActiveDetails($data);
                    if($projectSubmissionDetails) {
                        $submittedDate = Carbon::createFromFormat('Y-m-d', $projectSubmissionDetails->submitted_date)->format('d-m-Y');
                        $submittedTime = $projectSubmissionDetails->submitted_time;
                    } else {
                        $submittedDate = '';
                        $submittedTime = '';
                    }
                    $currentDateTime = date("Y-m-d h:i A");
                    $projectDateTime = $projectDetails->end_date.' '.$projectDetails->end_time;
                    $currentDateTime =  strtotime($currentDateTime);
                    $projectDateTime =  strtotime($projectDateTime);
                
                    $projectSubmittedFiles = $projectSubmissionDetailRepository->fetch($data);

                    if(count($projectSubmittedFiles)>0) {
                        $status = 'submitted';
                    } else {
                        if($projectDateTime >= $currentDateTime) {
                            $status = 'not-submitted';
                        } else {
                            $status = 'due-date-crossed';
                        }
                    }
                
                    if($readReceipt == 'YES') {
                        $viewCount = $studentDetails->view_count;
                    } else {
                        $viewCount ='Not Applicable';
                    }

                    $studentProjectDetails[] = array(
                        'id'=>$student->id_student,
                        'id_project'=>$idProject,
                        'student_name'=>$student->name,
                        'submitted_date'=>$submittedDate,
                        'submitted_time'=>$submittedTime,
                        'status'=>$status,
                        'view_count'=>$viewCount,
                    );
                }
            }
           
            return $studentProjectDetails;
        }

        public function downloadProjectSubmittedFiles($idStudent, $idProject) {
         
            $projectSubmissionDetailRepository = new ProjectSubmissionDetailRepository();
            $data['id_student'] = $idStudent;
            $data['id_project'] = $idProject;

            $zip = new ZipArchive;
            $fileName = 'myNewFile_'.time().'.zip';
            $zip->open($fileName, \ZipArchive::CREATE);

            $projectSubmittedFiles = $projectSubmissionDetailRepository->fetch($data);
            foreach ($projectSubmittedFiles as $file) {
                $files = explode('Project/', $file->submitted_file);
                $zip->addFromString($files[1], file_get_contents($file->submitted_file));
            }
            
            $zip->close();
            header('Content-disposition: attachment; filename='.time().'.zip');
            header('Content-type: application/zip');
            readfile($fileName);
        }   

        public function fetchProjectValuationDetails($details, $allSessions) {
          
            $data['id_student'] = $details->studentId;
            $data['id_project'] = $details->projectId;
            $projectSubmissionRepository = new ProjectSubmissionRepository();
            $institutionSubjectService = new InstitutionSubjectService();
            $projectRepository = new ProjectRepository();
            $projectSubmissionPermissionRepository = new ProjectSubmissionPermissionRepository();
            $staffService = new StaffService();
            $projectDetails = array();
            $resubmissionAllowed = 'NO';
            $resubmissionDate = date('d/m/Y');
            $resubmissionTime = '';
            $projectSubmissionId = '';
            $projectObtainedMarks = '';
            $projectComments = '';
            $project = $projectRepository->fetch($data['id_project']);
            $projectSubmissionDetails = $projectSubmissionRepository->fetchActiveDetails($data);
            if($projectSubmissionDetails) {
                $projectSubmissionId = $projectSubmissionDetails->id;
                $projectObtainedMarks = $projectSubmissionDetails->obtained_marks;
                $projectComments = $projectSubmissionDetails->comments;
            }
            
            $project = $projectRepository->fetch($data['id_project']);
            $projectSubmissionDetails = $projectSubmissionRepository->fetchActiveDetails($data);
            $subjectName =  $institutionSubjectService->getSubjectName($project->id_subject, $allSessions);
            $staffDetails = $staffService->find($project->id_staff, $allSessions);
            $gradeValue = explode(',' , $project->grade);

            $permissionDetails = $projectSubmissionPermissionRepository->fetchActiveDetails($data);
            if($permissionDetails){
                $resubmissionAllowed = $permissionDetails->resubmission_allowed;
                if($resubmissionAllowed == 'YES') {
                    $resubmissionDate = Carbon::createFromFormat('Y-m-d', $permissionDetails->resubmission_date)->format('d/m/Y');  
                    $resubmissionTime = $permissionDetails->resubmission_time;
                }
            }  

            $projectDetails = array(
                'id'=>$project->id,
                'subject_name'=>$subjectName,
                'staff_name'=>$staffDetails->name,
                'project_name'=>$project->name,
                'submission_type'=>$project->submission_type,
                'grading_required'=>$project->grading_required,
                'grading_option'=>$project->grading_option,
                'grade'=>$project->grade,
                'marks'=>$project->marks,
                'grade_values'=>$gradeValue,
                'id_project_submission'=>$projectSubmissionId,
                'obtained_marks'=>$projectObtainedMarks,
                'comments'=>$projectComments,
                'resubmission_allowed'=>$resubmissionAllowed,
                'resubmission_date'=>$resubmissionDate,
                'resubmission_time'=>$resubmissionTime
            );
            return $projectDetails;
        }

        public function fetchProjectVerifiedDetails($details, $allSessions) {
          
            $data['id_student'] = $details->studentId;
            $data['id_project'] = $details->projectId;
            $projectSubmissionRepository = new ProjectSubmissionRepository();
            $institutionSubjectService = new InstitutionSubjectService();
            $projectRepository = new ProjectRepository();
            $staffService = new StaffService();
            $projectDetails = array();           
            $valuationDetails = array();
            
            $project = $projectRepository->fetch($data['id_project']);
            $projectSubmissionDetails = $projectSubmissionRepository->fetch($data);
            $subjectName =  $institutionSubjectService->getSubjectName($project->id_subject, $allSessions);
            $staffDetails = $staffService->find($project->id_staff, $allSessions);
            $gradeValue = explode(',' , $project->grade);

            foreach($projectSubmissionDetails as $projects) {
                $valuationDetails[] = array(
                    'obtained_marks'=>$projects->obtained_marks,
                    'comments'=>$projects->comments
                );
            }

            $projectDetails = array(
                'id'=>$project->id,
                'subject_name'=>$subjectName,
                'staff_name'=>$staffDetails->name,
                'project_name'=>$project->name,
                'valuation_details'=>$valuationDetails
            );
            return $projectDetails;
        }


        public function update($valuationData, $id) { 
            $projectSubmissionRepository = new ProjectSubmissionRepository();
            $projectSubmissionPermissionRepository = new ProjectSubmissionPermissionRepository();
            $resubmissionAllowed = 'NO';
            $resubmissionDate = '';
            $resubmissionTime = '';
            $obtainedMark = ''; 
            $comment = '';
            if($valuationData->resubmissionAllowed) {
                $resubmissionAllowed = $valuationData->resubmissionAllowed;
            }

            if($resubmissionAllowed == 'YES') {

                $resubmissionDate = Carbon::createFromFormat('d/m/Y', $valuationData->resubmissionDate)->format('Y-m-d');  
                $resubmissionTime = $valuationData->resubmissionTime;

            } else {

                if($valuationData->obtained_mark) {
                    $obtainedMark = $valuationData->obtained_mark;
                }
                if($valuationData->grade_obtained) {
                    $obtainedMark = $valuationData->grade_obtained;
                }    
            }
          
            if($valuationData->comment) {
                $comment = $valuationData->comment;
            }
            else{
                $comment = '';
            }
           
            $projectValuationDetails = $projectSubmissionRepository->fetchData($id);
            $projectValuationDetails = $projectSubmissionRepository->fetchData($id);
            $projectId = $projectValuationDetails->id_project;
            $studentId = $projectValuationDetails->id_student;

            $permissionDetails = ProjectSubmissionPermission::where('id_project',$projectId)->where('id_student',$studentId)->first();

            if($permissionDetails) {
                $permissionDelete = $projectSubmissionPermissionRepository->delete($permissionDetails->id);
            }

            $details = array(
                'id_project'=>$projectId,
                'id_student'=>$studentId,
                'resubmission_allowed'=>$resubmissionAllowed,
                'resubmission_date'=>$resubmissionDate,
                'resubmission_time'=>$resubmissionTime, 
                'created_by' => Session::get('userId'),
                'created_at' => Carbon::now()
            );

            $insert = $projectSubmissionPermissionRepository->store($details);
            $projectValuationDetails->obtained_marks = $obtainedMark;
            $projectValuationDetails->comments	 = $comment;
            $projectValuationDetails->modified_by = Session::get('userId');
            $projectValuationDetails->updated_at = Carbon::now(); 
                      
            $updateData = $projectSubmissionRepository->update($projectValuationDetails);

            if($updateData) {
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