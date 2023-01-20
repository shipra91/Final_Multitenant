<?php
    namespace App\Services;

    use App\Models\GalleryAttachment;
    use App\Repositories\GalleryAttachmentRepository;
    use Carbon\Carbon;
    use ZipArchive;
    use Session;
    use DB;

    class GalleryAttachmentService {

        // Delete gallery image
        public function delete($id){

            $galleryAttachmentRepository = new GalleryAttachmentRepository();

            $galleryImage = $galleryAttachmentRepository->delete($id);

            if($galleryImage){
                $signal = 'success';
                $msg = 'Image deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
