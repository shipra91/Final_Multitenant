<?php
    namespace App\Services;

    use App\Models\HolidayAttachment;
    use App\Repositories\HolidayAttachmentRepository;
    use Carbon\Carbon;
    use ZipArchive;
    use Session;
    use DB;

    class HolidayAttachmentService {

        // Delete assignment attachment
        public function delete($id){

            $holidayAttachmentRepository = new HolidayAttachmentRepository();
            $output = array();

            $attachments = $holidayAttachmentRepository->delete($id);

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
