<?php
    namespace App\Services;

    use App\Models\StudentLeaveManagement;
    use App\Repositories\StudentLeaveManagementRepository;
    use App\Repositories\StudentLeaveAttachmentRepository;
    use App\Repositories\StudentRepository;
    use Carbon\Carbon;
    use ZipArchive;
    use Session;
    use DB;

    class StudentLeaveManagementService {

        // Get all student
        public function allStudent($allSessions){
            $studentRepository = new StudentRepository();
            return $studentRepository->all($allSessions);
        }

        // Get all leave application
        public function getAll($allSessions){

            $studentLeaveManagementRepository = new StudentLeaveManagementRepository();
            $studentRepository = new StudentRepository();

            $applicationData = $studentLeaveManagementRepository->all($allSessions);

            $applicationDetails = array();

            foreach($applicationData as $key => $application){

                $student = $studentRepository->fetch($application->id_student);

                if($application->leave_status == "PENDING"){

                    $status = 'Pending';

                }elseif($application->leave_status == "APPROVE"){

                    $status = 'Approve';

                }elseif($application->leave_status == "REJECT"){

                    $status = 'Reject';
                }

                $applicationArray = array(
                    'id' => $application->id,
                    'student'=>$student->name,
                    'leaveTitle'=>$application->title,
                    'fromDate'=>$application->from_date,
                    'toDate'=>$application->from_date,
                    'leaveStatus'=>$status,
                );

                $applicationDetails[$key]= $applicationArray;
            }

            return $applicationDetails;
        }

        // Get particular leave application
        public function getSelectedData($id_application){
            // dd($idDocument);
            $studentLeaveManagementRepository = new studentLeaveManagementRepository();
            $studentLeaveAttachmentRepository = new StudentLeaveAttachmentRepository();
            $studentRepository = new StudentRepository();

            $applicationData = array();

            $applicationDetails = $studentLeaveManagementRepository->fetch($id_application);
            $applicationAttachment = $studentLeaveAttachmentRepository->fetch($id_application);
            $studentDetails = $studentRepository->fetch($applicationDetails->id_student);
            //dd($applicationDetails);

            $applicationDetails['fromDate'] = Carbon::createFromFormat('Y-m-d', $applicationDetails->from_date)->format('d/m/Y');;
            $applicationDetails['toDate'] = Carbon::createFromFormat('Y-m-d', $applicationDetails->to_date)->format('d/m/Y');

            $output = array(
                'applicationData' => $applicationDetails,
                'students' => $studentDetails,
                'applicationAttachment' => $applicationAttachment
            );

            return $output;
        }

        // Insert leave application
        public function add($leaveData){

            $studentLeaveManagementRepository = new StudentLeaveManagementRepository();
            $studentLeaveAttachmentRepository = new StudentLeaveAttachmentRepository();
            $uploadService = new UploadService();

            $institutionId = $allSessions['id_institute'];
            $academicYear = $allSessions['id_academic'];

            $leaveTitle = $leaveData->leaveTitle;
            $student = $leaveData->student;
            $leaveFromDate = Carbon::createFromFormat('d/m/Y', $leaveData->leaveFromDate)->format('Y-m-d');
            $leaveToDate = Carbon::createFromFormat('d/m/Y', $leaveData->leaveToDate)->format('Y-m-d');
            $leaveDetail = $leaveData->leaveDetail;

            $check = StudentLeaveManagement::where('id_institute', $institutionId)
                                            ->where('id_academic', $academicYear)
                                            ->where('id_student', $student)
                                            ->where('title', $leaveTitle)
                                            ->where('from_date', $leaveFromDate)
                                            ->where('to_date', $leaveToDate)->first();

            if(!$check){

                $data = array(
                    'id_institute' => $institutionId,
                    'id_academic' => $academicYear,
                    'id_student' => $student,
                    'title' => $leaveTitle,
                    'from_date' => $leaveFromDate,
                    'to_date' => $leaveToDate,
                    'leave_detail' => $leaveDetail,
                    'leave_status' => 'PENDING',
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );

                $storeData = $studentLeaveManagementRepository->store($data);

                if($storeData){

                    $lastInsertedId = $storeData->id;

                    // Insert leave application attachment
                    if($leaveData->leaveAttachment){

                        foreach($leaveData->leaveAttachment as $attachment){

                            $path = 'LeaveApplication';
                            $attachmentleave = $uploadService->fileUpload($attachment, $path);

                            $data = array(
                                'id_leave_application' => $lastInsertedId,
                                'file_url' => $attachmentleave,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );

                            $studentLeaveAttachmentRepository->store($data);
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

        // Update leave application
        public function update($leaveData, $id){

            $studentLeaveManagementRepository = new StudentLeaveManagementRepository();
            $studentLeaveAttachmentRepository = new StudentLeaveAttachmentRepository();
            $uploadService = new UploadService();

            $studentId = $leaveData->student;
            $leaveTitle = $leaveData->leaveTitle;
            $leaveFromDate = Carbon::createFromFormat('d/m/Y', $leaveData->leaveFromDate)->format('Y-m-d');
            $leaveToDate = Carbon::createFromFormat('d/m/Y', $leaveData->leaveToDate)->format('Y-m-d');
            $leaveDetail = $leaveData->leaveDetail;

            $leaveDetails = $studentLeaveManagementRepository->fetch($id);

            $leaveDetails->id_student = $studentId;
            $leaveDetails->title = $leaveTitle;
            $leaveDetails->from_date = $leaveFromDate;
            $leaveDetails->to_date = $leaveToDate;
            $leaveDetails->leave_detail = $leaveDetail;
            $leaveDetails->leave_status = 'PENDING';
            $leaveDetails->modified_by = Session::get('userId');
            $leaveDetails->updated_at = Carbon::now();

            $updateData = $studentLeaveManagementRepository->update($leaveDetails);

            if($updateData){

                if($leaveData->leaveAttachment != ""){

                    $deleteAttachment = $studentLeaveAttachmentRepository->delete($id);

                    if($leaveData->hasfile('leaveAttachment')){

                        foreach($leaveData->leaveAttachment as $attachment){

                            $path = 'LeaveApplication';
                            $attachmentLeave = $uploadService->fileUpload($attachment, $path);

                            $data = array(
                                'id_leave_application' => $id,
                                'file_url' => $attachmentLeave,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );

                            $storeAttachment = $studentLeaveAttachmentRepository->store($data);
                            // dd($storeAttachment);
                        }
                    }
                }

                $signal = 'success';
                $msg = 'Data updated successfully!';

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

        // Delete leave application
        public function delete($id){

            $studentLeaveManagementRepository = new StudentLeaveManagementRepository();

            $leaveApplication = $studentLeaveManagementRepository->delete($id);

            if($leaveApplication){
                $signal = 'success';
                $msg = 'Leave Application deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Deleted leave application
        public function getDeletedRecords($allSessions){

            $studentLeaveManagementRepository = new StudentLeaveManagementRepository();
            $studentRepository = new StudentRepository();

            $applicationData = $studentLeaveManagementRepository->allDeleted($allSessions);
            $applicationDetails = array();

            foreach($applicationData as $key => $application){

                $student = $studentRepository->fetch($application->id_student);

                if($application->leave_status == "PENDING"){

                    $status = 'Pending';

                }elseif($application->leave_status == "APPROVE"){

                    $status = 'Approve';

                }elseif($application->leave_status == "REJECT"){

                    $status = 'Reject';
                }

                $applicationArray = array(
                    'id' => $application->id,
                    'student'=>$student->name,
                    'leaveTitle'=>$application->title,
                    'fromDate'=>$application->from_date,
                    'toDate'=>$application->from_date,
                    'leaveStatus'=>$status,
                );

                $applicationDetails[$key]= $applicationArray;
            }

            return $applicationDetails;
        }

        // Restore leave application records
        public function restore($id){

            $studentLeaveManagementRepository = new StudentLeaveManagementRepository();

            $leaveApplication = $studentLeaveManagementRepository->restore($id);

            if($leaveApplication){

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

        // Download leave application attachment zip
        public function downloadLeaveApplicationFiles($id){

            $studentLeaveAttachmentRepository = new StudentLeaveAttachmentRepository();

            $zip = new ZipArchive;
            $fileName = 'myNewFile_'.time().'.zip';
            $zip->open($fileName, \ZipArchive::CREATE);

            $leaveAttachment = $studentLeaveAttachmentRepository->fetch($id);

            foreach ($leaveAttachment as $file){
                $files = explode('LeaveApplication/', $file->file_url);
                $zip->addFromString($files[1], file_get_contents($file->file_url));
            }

            $zip->close();
            header('Content-disposition: attachment; filename='.time().'.zip');
            header('Content-type: application/zip');
            readfile($fileName);
        }

        // Update leave approval
        public function leaveApproval($leaveData, $id){

            $studentLeaveManagementRepository = new StudentLeaveManagementRepository();

            $applicationDetail = $studentLeaveManagementRepository->fetch($id);

            $applicationDetail->leave_status = $leaveData->application_approval;
            $applicationDetail->rejected_reason = $leaveData->rejection_reason;
            $applicationDetail->rejected_date = Carbon::now();
            $applicationDetail->rejected_by = Session::get('userId');

            $storeData = $studentLeaveManagementRepository->update($applicationDetail);

            if($storeData){
                $signal = 'success';
                $msg = 'Data inserted successfully!';

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
