<?php
    namespace App\Services;

    use App\Models\Project;
    use App\Repositories\ProjectRepository;
    use App\Repositories\ProjectDetailRepository;
    use App\Repositories\StaffSubjectMappingRepository;
    use App\Repositories\StandardSubjectRepository;
    use App\Repositories\StandardSubjectStaffMappingRepository;
    use App\Repositories\StudentMappingRepository;
    use App\Repositories\ProjectAssignedStudentsRepository;
    use App\Repositories\InstitutionSubjectRepository;
    use App\Repositories\StaffRepository;
    use App\Repositories\SubjectRepository;
    use App\Repositories\SubjectTypeRepository;
    use App\Repositories\ProjectSubmissionPermissionRepository;
    use App\Services\InstitutionSubjectService;
    use App\Services\InstitutionStandardService;
    use App\Services\StaffService;
    use App\Services\UploadService;
    use App\Services\SubjectService;
    use App\Services\StandardSubjectService;
    use App\Services\ProjectAssignedStudentService;
    use Carbon\Carbon;
    use Session;
    use ZipArchive;

    class ProjectService {

        // Get all subjects
        public function allSubject($idStandard, $allSessions){

            $role = $allSessions['role'];
            $idStaff = $allSessions['userId'];

            $standardSubjectRepository = new StandardSubjectRepository();
            $standardSubjectStaffMappingRepository = new StandardSubjectStaffMappingRepository();

            if($role == 'admin' || $role == 'superadmin'){
                $allSubjects = $standardSubjectRepository->fetchStandardSubjects($idStandard, $allSessions);
            }else{
                $allSubjects = $standardSubjectStaffMappingRepository->fetchStandardStaffSubjects($idStandard, $idStaff, $allSessions);
            }

            return $allSubjects;
        }

        // Get all staff
        public function allStaff($subjectId, $allSessions){

            $staffSubjectMappingRepository = new StaffSubjectMappingRepository();

            $allStaffs = $staffSubjectMappingRepository->allStaffs($subjectId, $allSessions);
            return $allStaffs;
        }

        // Get all project
        public function getAll($allSessions){

            $projectRepository = new ProjectRepository();
            $projectDetailRepository = new ProjectDetailRepository();
            $institutionStandardService = new InstitutionStandardService();
            $institutionSubjectService = new InstitutionSubjectService();
            $institutionSubjectRepository = new InstitutionSubjectRepository();
            $staffService = new StaffService();
            $subjectTypeRepository = new SubjectTypeRepository();
            $subjectRepository = new SubjectRepository();

            $projectDetails = array();
            $role = $allSessions['role'];
            $idStaff = $allSessions['userId'];

            if($role == 'admin' || $role == 'superadmin'){
                $projectDetail = $projectRepository->all($allSessions);
            }else{
                $projectDetail = $projectRepository->fetchProjectUsingStaff($idStaff, $allSessions);
            }

            foreach($projectDetail as  $details){

                $standardName = $institutionStandardService->fetchStandardByUsingId($details->id_standard);
                $subjectName =  $institutionSubjectService->getSubjectName($details->id_subject, $allSessions);
                $subjectData = $institutionSubjectRepository->find($details->id_subject);
                $staffDetails = $staffService->find($details->id_staff, $allSessions);
                $fromDate = Carbon::createFromFormat('Y-m-d', $details->start_date)->format('d/m/Y');
                $toDate = Carbon::createFromFormat('Y-m-d', $details->end_date)->format('d/m/Y');
                $projectImageDetail = $projectDetailRepository->fetch($details->id);

                $type = $subjectTypeRepository->fetch($subjectData->id_type);

                $subjectNameCount = $subjectRepository->fetchSubjectNameCount($subjectData->name);
                if(count($subjectNameCount) > 1){
                    $subjectType = ' ( '.$type->display_name.' )';
                }else{
                    $subjectType = '';
                }

                if($projectImageDetail){
                    $status = 'file_found';
                }else{
                    $status = 'file_not_found';
                }

                $projectDetails[] = array(
                    'id'=>$details->id,
                    'id_standard'=>$details->id_standard,
                    'class_name'=>$standardName,
                    'subject_name'=>$subjectName.$subjectType,
                    'staff_name'=>$staffDetails->name,
                    'project_name'=>$details->name,
                    'description'=>$details->description,
                    'from_date'=>$fromDate,
                    'to_date'=>$toDate,
                    'projectImageDetails'=>$projectImageDetail,
                    'status'=>$status
                );
            }
            //dd($projectDetails);
            return $projectDetails;
        }

        // Get particular project
        public function getProjectSelectedData($idProject){

            $projectRepository = new ProjectRepository();
            $projectDetailRepository = new ProjectDetailRepository();
            $institutionStandardService = new InstitutionStandardService();
            $institutionSubjectService = new InstitutionSubjectService();
            $staffService = new StaffService();

            $projectAttachment = array();
            $projectData = $projectRepository->fetch($idProject);
            $projectAttachments = $projectDetailRepository->fetch($idProject);

            $standardName = $institutionStandardService->fetchStandardByUsingId($projectData->id_standard);
            $subjectName =  $institutionSubjectService->getSubjectName($projectData->id_subject);
            $staffDetails = $staffService->find($projectData->id_staff);

            foreach($projectAttachments as $key => $attachment){
                $ext = pathinfo($attachment['file_url'], PATHINFO_EXTENSION);
                $projectAttachment[$key] = $attachment;
                $projectAttachment[$key]['extension'] = $ext;
            }

            $output = array(
                'projectData' => $projectData,
                'projectAttachment' => $projectAttachment,
                'className'=>$standardName,
                'subjectName'=>$subjectName,
                'staffName'=>$staffDetails->name,
            );
            //dd($output);
            return $output;
        }

        // Get project details
        public function find($id){

            $projectRepository = new ProjectRepository();

            $project = $projectRepository->fetch($id);
            return $project;
        }

        // Get project details
        public function fetchDetails($data, $allSessions){

            $projectDetailRepository = new ProjectDetailRepository();
            $institutionStandardService = new InstitutionStandardService();
            $institutionSubjectService = new InstitutionSubjectService();
            $projectAssignedStudentService = new ProjectAssignedStudentService();
            $projectSubmissionPermissionRepository = new ProjectSubmissionPermissionRepository();
            $staffService = new StaffService();
            $projectRepository = new ProjectRepository();

            $projectDetails = array();

            $id = $data->projectId;
            $loginType = $data->login_type;

            $idStudent = $allSessions['userId'];
            $data['id_student'] = $idStudent;
            $data['id_project'] = $id;
            $resubmissionRequired = 'NO';
            $resubmissionDate = '';
            $resubmissionTime = '';

            if($loginType == 'student'){
                $projectAssignedStudentService->updateViewStatus($data);
            }

            $permissionDetails = $projectSubmissionPermissionRepository->fetchActiveDetails($data);

            if($permissionDetails){

                $resubmissionRequired = $permissionDetails->resubmission_allowed;

                if($resubmissionRequired == 'YES'){
                    $resubmissionDate = Carbon::createFromFormat('Y-m-d', $permissionDetails->resubmission_date)->format('d-m-Y');
                    $resubmissionTime = $permissionDetails->resubmission_time;
                }
            }

            $project = $projectRepository->fetch($id);
            $standardName = $institutionStandardService->fetchStandardByUsingId($project->id_standard);
            $subjectName =  $institutionSubjectService->getSubjectName($project->id_subject, $allSessions);
            $staffDetails = $staffService->find($project->id_staff, $allSessions);
            $fromDate = Carbon::createFromFormat('Y-m-d', $project->start_date)->format('d/m/Y');
            $toDate = Carbon::createFromFormat('Y-m-d', $project->end_date)->format('d/m/Y');

            $projectImageDetails = $projectDetailRepository->fetch($project->id);

            $gradeValue = explode(',' , $project->grade);

            $projectDetails = array(
                'id'=>$project->id,
                'class_name'=>$standardName,
                'subject_name'=>$subjectName,
                'staff_name'=>$staffDetails->name,
                'project_name'=>$project->name,
                'description'=>$project->description,
                'from_date'=>$fromDate,
                'to_date'=>$toDate,
                'chapter_name'=>$project->chapter_name,
                'start_time'=>$project->start_time,
                'end_time'=>$project->end_time,
                'submission_type'=>$project->submission_type,
                'grading_required'=>$project->grading_required,
                'grading_option'=>$project->grading_option,
                'grade'=>$project->grade,
                'marks'=>$project->marks,
                'read_receipt'=>$project->read_receipt,
                'sms_alert'=>$project->sms_alert,
                'resubmission_required'=>$resubmissionRequired,
                'resubmission_date'=>$resubmissionDate,
                'resubmission_time'=>$resubmissionTime,
                'grade_values'=>$gradeValue
            );

            return $projectDetails;
        }

        // Insert project
        public function add($projectData){

            $projectRepository = new ProjectRepository();
            $projectDetailRepository = new ProjectDetailRepository();
            $projectAssignedStudentsRepository = new ProjectAssignedStudentsRepository();
            $uploadService = new UploadService();

            $institutionId = $projectData->id_institute;
            $academicYear = $projectData->id_academic;

            $projectClass = $projectData->project_class;
            $projectSubject = $projectData->project_subject;
            $projectStaff = $projectData->project_staff;
            $projectName = $projectData->project_name;
            $projectDetails = $projectData->project_details;
            $projectChapterName = $projectData->project_chapter_name;
            $projectStartTime = $projectData->project_start_time;
            $projectEndTime = $projectData->project_end_time;
            $submissionType = $projectData->submission_type;
            $gradingRequired = $projectData->grading_required;
            $gradingOption = '';
            $projectGrade = '';
            $projectMark = '';

            if($gradingRequired == 'YES'){

                $gradingOption = $projectData->grading_option;

                if($gradingOption == 'GRADE'){
                    $projectGrade = $projectData->project_grade;
                }else if($gradingOption == 'MARKS'){
                    $projectMark = $projectData->project_mark;
                }
            }

            $readReceipt = $projectData->read_receipt;
            $smsAlert = $projectData->sms_alert;
            $count = 0;

            $projectStartDate = Carbon::createFromFormat('d/m/Y', $projectData->project_start_date)->format('Y-m-d');
            $projectEndDate = Carbon::createFromFormat('d/m/Y', $projectData->project_end_date)->format('Y-m-d');

            $check = Project::where('id_institute', $institutionId)
                            ->where('id_academic', $academicYear)
                            ->where('id_standard', $projectClass)
                            ->where('id_subject', $projectSubject)
                            ->where('id_staff', $projectStaff)
                            ->where('name', $projectName)
                            ->first();

            if(!$check){

                $data = array(
                    'id_institute' => $institutionId,
                    'id_academic' => $academicYear,
                    'id_standard' => $projectClass,
                    'id_subject' => $projectSubject,
                    'id_staff' => $projectStaff,
                    'name' => $projectName,
                    'start_date' => $projectStartDate,
                    'end_date' => $projectEndDate,
                    'description' => $projectDetails,
                    'chapter_name' => $projectChapterName,
                    'start_time' => $projectStartTime,
                    'end_time' => $projectEndTime,
                    'submission_type' => $submissionType,
                    'grading_required' => $gradingRequired,
                    'grading_option' => $gradingOption,
                    'grade' => $projectGrade,
                    'marks' => $projectMark,
                    'read_receipt' => $readReceipt,
                    'sms_alert' => $smsAlert,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );
                $storeData = $projectRepository->store($data);

                if($storeData){

                    $lastInsertedId = $storeData->id;

                    if($projectData->attachmentProject){

                        foreach($projectData->attachmentProject as $attachment){

                            $path = 'Project';
                            $attachmentProject = $uploadService->fileUpload($attachment, $path);

                            $data = array(
                                'id_project' => $lastInsertedId,
                                'file_url' => $attachmentProject,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );
                            $projectDetailRepository->store($data);
                        }
                    };

                    if($projectData->student){

                        foreach($projectData->student as $student){

                            $data = array(
                                'id_project' => $lastInsertedId,
                                'id_student' => $student,
                                'view_count' => $count,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );
                            $projectAssignedStudentsRepository->store($data);
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

        // Update project
        public function update($projectData, $id){

            $uploadService = new UploadService();
            $projectRepository = new ProjectRepository();
            $projectDetailRepository = new ProjectDetailRepository();
            $projectAssignedStudentsRepository = new ProjectAssignedStudentsRepository();

            $institutionId = $projectData->id_institute;
            $academicYear = $projectData->id_academic;

            $projectClass = $projectData->project_class;
            $projectSubject = $projectData->project_subject;
            $projectStaff = $projectData->project_staff;
            $projectName = $projectData->project_name;
            $projectDetail = $projectData->project_details;
            $projectChapterName = $projectData->project_chapter_name;
            $projectStartTime = $projectData->project_start_time;
            $projectEndTime = $projectData->project_end_time;
            $submissionType = $projectData->submission_type;
            $gradingRequired = $projectData->grading_required;
            $gradingOption = '';
            $projectGrade = '';
            $projectMark = '';

            if($gradingRequired == 'YES'){

                $gradingOption = $projectData->grading_option;

                if($gradingOption == 'GRADE'){
                    $projectGrade = $projectData->project_grade;
                }else if($gradingOption == 'MARKS'){
                    $projectMark = $projectData->project_mark;
                }
            }

            $readReceipt = $projectData->read_receipt;
            $smsAlert = $projectData->sms_alert;

            $projectStartDate = Carbon::createFromFormat('d/m/Y', $projectData->project_start_date)->format('Y-m-d');
            $projectEndDate = Carbon::createFromFormat('d/m/Y', $projectData->project_end_date)->format('Y-m-d');


            $check = Project::where('id_institute', $institutionId)
                            ->where('id_academic', $academicYear)
                            ->where('id_standard', $projectClass)
                            ->where('id_subject', $projectSubject)
                            ->where('id_staff', $projectStaff)
                            ->where('name', $projectName)
                            ->where('id', '!=', $id)
                            ->first();

            if(!$check){

                $projectDetails = $projectRepository->fetch($id);
                $projectDetails->id_standard = $projectClass;
                $projectDetails->id_subject = $projectSubject;
                $projectDetails->id_staff = $projectStaff;
                $projectDetails->name = $projectName;
                $projectDetails->description = $projectDetail;
                $projectDetails->start_date = $projectStartDate;
                $projectDetails->end_date = $projectEndDate;
                $projectDetails->chapter_name = $projectChapterName;
                $projectDetails->start_time = $projectStartTime;
                $projectDetails->end_time = $projectEndTime;
                $projectDetails->submission_type = $submissionType;
                $projectDetails->grading_required = $gradingRequired;
                $projectDetails->grading_option = $gradingOption;
                $projectDetails->grade = $projectGrade;
                $projectDetails->marks = $projectMark;
                $projectDetails->read_receipt = $readReceipt;
                $projectDetails->sms_alert = $smsAlert;
                $projectDetails->modified_by = Session::get('userId');
                $projectDetails->updated_at = Carbon::now();

                $updateData = $projectRepository->update($projectDetails);
                $count = 0;

                if($updateData){

                    $lastInsertedId = $id;

                    if($projectData->attachmentProject){
                        // $projectDetailRepository->delete($lastInsertedId);
                        foreach($projectData->attachmentProject as $attachment){

                            $path = 'Project';
                            $attachmentProject = $uploadService->fileUpload($attachment, $path);

                            $data = array(
                                'id_project' => $lastInsertedId,
                                'file_url' => $attachmentProject,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );
                            $projectDetailRepository->store($data);
                        }
                    };

                    if($projectData->student){

                        $projectAssignedStudentsRepository->delete($lastInsertedId);

                        foreach($projectData->student as $student){

                            $data = array(
                                'id_project' => $lastInsertedId,
                                'id_student' => $student,
                                'view_count' => $count,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );
                            $projectAssignedStudentsRepository->store($data);
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

        // Delete project
        public function delete($id){

            $projectRepository = new ProjectRepository();

            $project = $projectRepository->delete($id);

            if($project){
                $signal = 'success';
                $msg = 'Project deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function getDetails($data, $allSessions){

            $staffs = array();
            $standardId = $data->id_standard;
            $subjectId = $data->id_subject;
            $projectId = $data->id;

            $request['subjectId'] = $subjectId;
            $request['standardId'] = $standardId;

            $institutionStandardService = new InstitutionStandardService();
            $standardSubjectService = new StandardSubjectService();
            $standardSubjectStaffMappingRepository = new StandardSubjectStaffMappingRepository();
            $staffRepository = new StaffRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $institutionSubjectRepository = new InstitutionSubjectRepository();
            $subjectService = new SubjectService();
            $subjectTypeRepository = new SubjectTypeRepository();
            $projectAssignedStudentsRepository = new ProjectAssignedStudentsRepository();
            $assignedStudents = array();
            $projectDetails['standard'] = $institutionStandardService->fetchStandard($allSessions);
            $projectDetails['subject'] = $standardSubjectService->fetchStandardSubjects($standardId, $allSessions);
            $staffSubjectDetails = $standardSubjectStaffMappingRepository->getStaffs($subjectId, $standardId, $allSessions);

            foreach($staffSubjectDetails as $index => $details){
                $staffs[$index] = $staffRepository->fetch($details->id_staff);
            }

            $projectDetails['staff'] = $staffs;
            $subjectData = $institutionSubjectRepository->find($subjectId);
            $subjectDetails = $subjectService->find($subjectData->id_subject);

            $type = $subjectTypeRepository->fetch($subjectDetails->id_type);

            if($type->label == 'common'){
                $students = $studentMappingRepository->fetchStudentUsingStandard($data->id_standard, $allSessions);
            }else{
                $students = $studentMappingRepository->fetchStudentUsingSubject($request, $allSessions);
            }
            foreach($students as $key => $student){
                
                $allStudents[$key] = $student;
                $allStudents[$key]['name'] = $studentMappingRepository->getFullName($student['name'], $student['middle_name'], $student['last_name']);
            }

            $projectDetails['student'] = $allStudents;            

            $projectAssignedStudents = $projectAssignedStudentsRepository->fetch($projectId);

            foreach ($projectAssignedStudents as $index => $details){
                $assignedStudents[$index] = $details->id_student;
            }
            $projectDetails['project_asigned_students'] = $assignedStudents;

            return $projectDetails;
        }

        // Download project attachment zip
        public function downloadProjectFiles($id, $type, $allSessions){

            $projectDetailRepository = new ProjectDetailRepository();
            $projectAssignedStudentService = new ProjectAssignedStudentService();
            
            $idStudent = $allSessions['userId'];
            $data['id_student'] = $idStudent;
            $data['id_project'] = $id;

            if($type == 'student'){
                $projectAssignedStudentService->updateViewStatus($data);
            }

            $zip = new ZipArchive;
            $fileName = 'myNewFile_'.time().'.zip';
            $zip->open($fileName, \ZipArchive::CREATE);

            $projectFiles = $projectDetailRepository->fetch($id);

            foreach ($projectFiles as $file){
                $files = explode('Project/', $file->file_url);
                $zip->addFromString($files[1], file_get_contents($file->file_url));
            }

            $zip->close();
            header('Content-disposition: attachment; filename='.time().'.zip');
            header('Content-type: application/zip');
            readfile($fileName);
        }

        // Deleted project records
        public function getDeletedRecords($allSessions){

            $ProjectRepository = new ProjectRepository();
            $ProjectDetail = array();
            $ProjectData = $ProjectRepository->allDeleted($allSessions);

            foreach($ProjectData as $key => $data){
                $ProjectDetail[$key] = $data;
                $ProjectDetail[$key]['start_date'] = Carbon::createFromFormat('Y-m-d', $data->start_date)->format('d-m-Y');
                $ProjectDetail[$key]['end_date'] = Carbon::createFromFormat('Y-m-d', $data->end_date)->format('d-m-Y');
            }

            return $ProjectDetail;
        }

        // Restore project records
        public function restore($id){

            $ProjectRepository = new ProjectRepository();

            $Project = $ProjectRepository->restore($id);

            if($Project){
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
