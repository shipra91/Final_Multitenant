<?php
    namespace App\Services;

    use App\Models\CircularAttachment;
    use App\Repositories\CircularAttachmentRepository;
    use Carbon\Carbon;
    use ZipArchive;
    use Session;
    use DB;

    class CircularAttachmentService {

        // Delete circular attachment
        public function delete($id){

            $circularAttachmentRepository = new CircularAttachmentRepository();

            $output = array();
            $attachments = $circularAttachmentRepository->delete($id);

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
