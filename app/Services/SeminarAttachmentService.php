<?php
    namespace App\Services;

    use App\Models\SeminarAttachment;
    use App\Repositories\SeminarAttachmentRepository;
    use Carbon\Carbon;
    use ZipArchive;
    use Session;
    use DB;

    class SeminarAttachmentService {

        // Delete seminar attachment
        public function delete($id){

            $seminarAttachmentRepository = new SeminarAttachmentRepository();

            $output = array();
            $attachments = $seminarAttachmentRepository->delete($id);

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
