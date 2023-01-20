<?php
    namespace App\Repositories;
    use App\Models\GalleryAttachment;
    use App\Interfaces\GalleryAttachmentRepositoryInterface;
    use Carbon\Carbon;
    use Storage;
    use Session;
    use DB;

    class GalleryAttachmentRepository implements GalleryAttachmentRepositoryInterface{

        public function all(){
            return GalleryAttachment::all();
        }

        public function store($data){
            return $galleryAttachment = GalleryAttachment::create($data);
        }

        public function fetch($id){
            return $galleryAttachment = GalleryAttachment::where('id_gallery', $id)->get();
        }

        public function update($data){
            return $data->save();
        }

        // public function delete($id){
        //     return $galleryAttachment = GalleryAttachment::find($id)->delete();
        // }/

        public function delete($id){
            return $galleryAttachment = GalleryAttachment::find($id)->delete();
        }
    }
?>
