<?php
    namespace App\Services;

    use App\Models\WorkdoneAttachment;
    use App\Repositories\WorkdoneAttachmentRepository;
    use Carbon\Carbon;
    use ZipArchive;
    use Session;
    use DB;

    class WorkdoneAttachmentService {

        // Delete workdone attachment
        public function delete($id){

            $workdoneAttachmentRepository = new WorkdoneAttachmentRepository();

            $output = array();
            $attachments = $workdoneAttachmentRepository->delete($id);

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
