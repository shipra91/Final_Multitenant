<?php
    namespace App\Services;

    use App\Models\HomeworkDetail;
    use App\Repositories\HomeworkDetailRepository;
    use Carbon\Carbon;
    use ZipArchive;
    use Session;
    use DB;

    class HomeworkAttachmentService {

        // Delete homework attachment
        public function delete($id){

            $homeworkDetailRepository = new HomeworkDetailRepository();
            $output = array();

            $attachments = $homeworkDetailRepository->delete($id);

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
