<?php
    namespace App\Services;
    use App\Models\Workdone;
    use App\Services\WorkdoneService;
    use App\Services\InstitutionStandardService;
    use App\Services\StandardSubjectService;
    use App\Repositories\WorkdoneAttachmentRepository;
    use App\Repositories\StandardSubjectStaffMappingRepository;
    use App\Repositories\StaffRepository;
    use App\Repositories\WorkdoneRepository;
    use Carbon\Carbon;
    use Session;
    use ZipArchive;

    class WorkdoneService {

        // View workdone
        public function getAll($allSessions){

            $workdoneRepository = new WorkdoneRepository();
            $workdoneAttachmentRepository = new WorkdoneAttachmentRepository();
            $institutionStandardService = new InstitutionStandardService();
            $institutionSubjectService = new InstitutionSubjectService();
            $staffService = new StaffService();
            $workdoneAttachments = array();

            $idStaff = $allSessions['userId'];
            $role = $allSessions['role'];

            if($role == 'admin'  || $role == 'superadmin'){
                $workdoneAttachment = $workdoneRepository->all();
            }else{
                $workdoneAttachment = $workdoneRepository->fetchWorkdoneUsingStaff($idStaff, $allSessions);
            }

            foreach($workdoneAttachment as  $details){

                $standardName = $institutionStandardService->fetchStandardByUsingId($details->id_standard);
                $subjectName =  $institutionSubjectService->getSubjectName($details->id_subject, $allSessions);
                $staffDetails = $staffService->find($details->id_staff, $allSessions);
                if($staffDetails){
                    $staffName = $staffDetails['name'];
                }else{
                    $staffName = "";
                }
                $workdoneDate = Carbon::createFromFormat('Y-m-d', $details->date)->format('d/m/Y');

                $workdoneImageDetail = $workdoneAttachmentRepository->fetch($details->id);

                if($workdoneImageDetail){
                    $status = 'file_found';
                }else{
                    $status = 'file_not_found';
                }

                $workdoneAttachments[] = array(
                    'id'=>$details->id,
                    'id_standard'=>$details->id_standard,
                    'class_name'=>$standardName,
                    'subject_name'=>$subjectName,
                    'staff_name'=>$staffName,
                    'workdone_name'=>$details->workdone_topic,
                    'description'=>$details->description,
                    'date'=>$workdoneDate,
                    'workdoneImageDetails'=>$workdoneImageDetail,
                    'status'=>$status
                );
            }
            //dd($workdoneAttachments);
            return $workdoneAttachments;
        }

        // Insert workdone
        public function add($workdoneData){

            $workdoneRepository = new WorkdoneRepository();
            $workdoneAttachmentRepository = new WorkdoneAttachmentRepository();
            $uploadService = new UploadService();

            $institutionId = $workdoneData->id_institute;
            $academicYear = $workdoneData->id_academic;

            $workdoneClass = $workdoneData->workdone_class;
            $workdoneSubject = $workdoneData->workdone_subject;
            $workdoneStaff = $workdoneData->workdone_staff;
            $workdoneStartTime = $workdoneData->workdone_start_time;
            $workdoneEndTime = $workdoneData->workdone_end_time;
            $chapterName = $workdoneData->chapter_name;
            $workdoneAttachments = $workdoneData->workdone_details;
            $workdoneDate = Carbon::createFromFormat('d/m/Y', $workdoneData->workdone_date)->format('Y-m-d');

            $check = Workdone::where('id_institute', $institutionId)
                                ->where('id_academic', $academicYear)
                                ->where('id_standard', $workdoneClass)
                                ->where('id_subject', $workdoneSubject)
                                ->where('id_staff', $workdoneStaff)
                                ->where('workdone_topic', $chapterName)
                                ->first();

            if(!$check){

                $data = array(
                    'id_institute' => $institutionId,
                    'id_academic' => $academicYear,
                    'id_standard' => $workdoneClass,
                    'id_subject' => $workdoneSubject,
                    'id_staff' => $workdoneStaff,
                    'date' => $workdoneDate,
                    'description' => $workdoneAttachments,
                    'workdone_topic' => $chapterName,
                    'start_time' => $workdoneStartTime,
                    'end_time' => $workdoneEndTime,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );

                $storeData = $workdoneRepository->store($data);

                if($storeData){

                    $lastInsertedId = $storeData->id;

                    if($workdoneData->attachmentWorkdone){

                        foreach($workdoneData->attachmentWorkdone as $attachment){

                            $path = 'Workdone';
                            $attachmentWorkdone = $uploadService->fileUpload($attachment, $path);

                            $data = array(
                                'id_workdone' => $lastInsertedId,
                                'file_url' => $attachmentWorkdone,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );

                            $workdoneAttachmentRepository->store($data);
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

        // Get particular workdone
        public function find($id){
            $workdoneRepository = new WorkdoneRepository();
            $workdone = $workdoneRepository->fetch($id);
            return $workdone;
        }

        // Get particular workdone detail
        public function getDetails($data, $allSessions){

            $institutionStandardService = new InstitutionStandardService();
            $standardSubjectService = new StandardSubjectService();
            $standardSubjectStaffMappingRepository = new StandardSubjectStaffMappingRepository();
            $staffRepository = new StaffRepository();

            $standardId = $data->id_standard;
            $subjectId = $data->id_subject;

            $staffs = array();

            $workdoneAttachments['standard'] = $institutionStandardService->fetchStandard($allSessions);
            $workdoneAttachments['subject'] = $standardSubjectService->fetchStandardSubjects($standardId, $allSessions);
            $staffSubjectDetails = $standardSubjectStaffMappingRepository->getStaffs($subjectId, $standardId, $allSessions);

            foreach($staffSubjectDetails as $index => $details){
                $staffs[$index] = $staffRepository->fetch($details->id_staff);
            }

            $workdoneAttachments['staff'] = $staffs;
            return $workdoneAttachments;
        }

        // Update workdone
        public function update($workdoneData, $id){

            $uploadService = new UploadService();
            $workdoneRepository = new WorkdoneRepository();
            $workdoneAttachmentRepository = new WorkdoneAttachmentRepository();

            $institutionId = $workdoneData->id_institute;
            $academicYear = $workdoneData->id_academic;

            $workdoneClass = $workdoneData->workdone_class;
            $workdoneSubject = $workdoneData->workdone_subject;
            $workdoneStaff = $workdoneData->workdone_staff;
            $workdoneStartTime = $workdoneData->workdone_start_time;
            $workdoneEndTime = $workdoneData->workdone_end_time;
            $chapterName = $workdoneData->chapter_name;
            $description = $workdoneData->workdone_details;

            $workdoneDate = Carbon::createFromFormat('d/m/Y',$workdoneData->workdone_date)->format('Y-m-d');

            $check = Workdone::where('id_institute', $institutionId)
                                ->where('id_academic', $academicYear)
                                ->where('id_standard', $workdoneClass)
                                ->where('id_subject', $workdoneSubject)
                                ->where('id_staff', $workdoneStaff)
                                ->where('workdone_topic', $chapterName)
                                ->where('id', '!=', $id)
                                ->first();

            if(!$check){

                $workdoneDetails = $workdoneRepository->fetch($id);
                $workdoneDetails->id_standard = $workdoneClass;
                $workdoneDetails->id_subject = $workdoneSubject;
                $workdoneDetails->id_staff = $workdoneStaff;
                $workdoneDetails->workdone_topic = $chapterName;
                $workdoneDetails->description = $description;
                $workdoneDetails->date = $workdoneDate;
                $workdoneDetails->start_time = $workdoneStartTime;
                $workdoneDetails->end_time = $workdoneEndTime;
                $workdoneDetails->modified_by = Session::get('userId');
                $workdoneDetails->updated_at = Carbon::now();

                $updateData = $workdoneRepository->update($workdoneDetails);

                if($updateData){

                    $lastInsertedId = $id;

                    if($workdoneData->attachmentWorkdone){

                        $workdoneAttachmentRepository->delete($lastInsertedId);

                        foreach($workdoneData->attachmentWorkdone as $attachment){

                            $path = 'Workdone';
                            $attachmentWorkdone = $uploadService->fileUpload($attachment, $path);

                            $data = array(
                                'id_workdone' => $lastInsertedId,
                                'file_url' => $attachmentWorkdone,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );

                            $workdoneAttachmentRepository->store($data);
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

        // Get workdone details
        public function fetchDetails($data, $allSessions){

            $workdoneAttachmentRepository = new WorkdoneAttachmentRepository();
            $institutionStandardService = new InstitutionStandardService();
            $institutionSubjectService = new InstitutionSubjectService();
            $staffService = new StaffService();
            $workdoneRepository = new WorkdoneRepository();
            $workdoneDetails = array();

            $id = $data->workdoneId;
            $loginType = $data->login_type;

            $data['id_student'] = $allSessions['userId'];
            $data['id_workdone'] = $id;

            $workdone = $workdoneRepository->fetch($id);
            $standardName = $institutionStandardService->fetchStandardByUsingId($workdone->id_standard);
            $subjectName =  $institutionSubjectService->getSubjectName($workdone->id_subject, $allSessions);
            $staffDetails = $staffService->find($workdone->id_staff, $allSessions);
            $date = Carbon::createFromFormat('Y-m-d', $workdone->date)->format('d/m/Y');

            $workdoneImageDetails = $workdoneAttachmentRepository->fetch($workdone->id);

            // $gradeValue = explode(',' , $workdone->grade);

            $workdoneDetails = array(
                'id'=>$workdone->id,
                'class_name'=>$standardName,
                'subject_name'=>$subjectName,
                'staff_name'=>$staffDetails->name,
                'workdone_name'=>$workdone->workdone_topic,
                'description'=>$workdone->description,
                'date'=>$date,
                'start_time'=>$workdone->start_time,
                'end_time'=>$workdone->end_time
            );

            return $workdoneDetails;
        }

        // Delete Workdone
        public function delete($id){

            $workdoneRepository = new WorkdoneRepository();

            $workdone = $workdoneRepository->delete($id);

            if($workdone){
                $signal = 'success';
                $msg = 'Workdone deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Download workdone attachment zip
        public function downloadWorkdoneFiles($id, $type, $allSessions){

            $workdoneAttachmentRepository = new WorkdoneAttachmentRepository();

            $idStudent = $allSessions['userId'];
            $data['id_student'] = $idStudent;
            $data['id_workdone'] = $id;

            $zip = new ZipArchive;
            $fileName = 'myNewFile_'.time().'.zip';
            $zip->open($fileName, \ZipArchive::CREATE);

            $workdoneFiles = $workdoneAttachmentRepository->fetch($id);

            foreach ($workdoneFiles as $file) {
                $files = explode('Workdone/', $file->file_url);
                $zip->addFromString($files[1], file_get_contents($file->file_url));
            }

            $zip->close();
            header('Content-disposition: attachment; filename='.time().'.zip');
            header('Content-type: application/zip');
            readfile($fileName);
        }

        // Deleted workdone records
        public function getDeletedRecords($allSessions){

            $institutionStandardService = new InstitutionStandardService();
            $institutionSubjectService = new InstitutionSubjectService();
            $staffService = new StaffService();
            $workdoneRepository = new WorkdoneRepository();
            $workdoneData = $workdoneRepository->allDeleted($allSessions);
            $workdoneDetails = array();

            foreach($workdoneData as $data){

                $standardName = $institutionStandardService->fetchStandardByUsingId($data->id_standard);
                $subjectName =  $institutionSubjectService->getSubjectName($data->id_subject, $allSessions);
                $staffDetails = $staffService->find($data->id_staff, $allSessions);
                $date = Carbon::createFromFormat('Y-m-d', $data->date)->format('d/m/Y');

                $workdoneDetails[] =  array(
                    'id'=>$data->id,
                    'standard'=>$standardName,
                    'subject'=>$subjectName,
                    'staff'=>$staffDetails->name,
                    'workdone_name'=>$data->workdone_topic,
                    'description'=>$data->description,
                    'date'=>$date,
                    'start_time'=>$data->start_time,
                    'end_time'=>$data->end_time
                );
            }

            return $workdoneDetails;
        }

        // Restore workdone records
        public function restore($id){

            $workdoneRepository = new WorkdoneRepository();

            $holiday = $workdoneRepository->restore($id);

            if($holiday){
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
