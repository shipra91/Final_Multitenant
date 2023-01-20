<?php
    namespace App\Services;

    use App\Models\StudentLeaveAttachment;
    use App\Repositories\StudentLeaveAttachmentRepository;
    use Carbon\Carbon;
    use ZipArchive;
    use Session;
    use DB;

    class LeaveApplicationAttachmentService {

        // Delete leave application attachment
        public function delete($id){

            $studentLeaveAttachmentRepository = new StudentLeaveAttachmentRepository();

            $output = array();
            $attachments = $studentLeaveAttachmentRepository->delete($id);

            if($attachments){
                $signal = 'success';
                $msg = 'Data deleted successfully!';

            }else{
                $signal = 'failure';
                $msg = 'some error!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
