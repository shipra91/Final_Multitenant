<?php
    namespace App\Services;

    use App\Models\EventAttachment;
    use App\Repositories\EventAttachmentRepository;
    use Carbon\Carbon;
    use ZipArchive;
    use Session;
    use DB;

    class EventAttachmentService {

        // Delete event attachment
        public function delete($id){

            $eventAttachmentRepository = new EventAttachmentRepository();
            $output = array();

            $attachments = $eventAttachmentRepository->delete($id);

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
