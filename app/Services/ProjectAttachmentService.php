<?php
    namespace App\Services;

    use App\Models\ProjectDetail;
    use App\Repositories\ProjectDetailRepository;
    use Carbon\Carbon;
    use ZipArchive;
    use Session;
    use DB;

    class ProjectAttachmentService {

        // Delete assignment attachment
        public function delete($id){

            $projectDetailRepository = new ProjectDetailRepository();
            $output = array();

            $attachments = $projectDetailRepository->delete($id);

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
