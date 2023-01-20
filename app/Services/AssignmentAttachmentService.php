<?php
    namespace App\Services;

    use App\Models\AssignmentDetail;
    use App\Repositories\AssignmentDetailRepository;
    use Carbon\Carbon;
    use ZipArchive;
    use Session;
    use DB;

    class AssignmentAttachmentService {

        // Delete assignment attachment
        public function delete($id){

            $assignmentDetailRepository = new AssignmentDetailRepository();
            $output = array();

            $attachments = $assignmentDetailRepository->delete($id);

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
