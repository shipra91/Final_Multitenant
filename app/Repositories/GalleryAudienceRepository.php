<?php
    namespace App\Repositories;
    use App\Models\GalleryAudience;
    use App\Interfaces\GalleryAudienceRepositoryInterface;
    use Carbon\Carbon;
    use Storage;
    use Session;
    use DB;

    class GalleryAudienceRepository implements GalleryAudienceRepositoryInterface{

        public function all(){
            return GalleryAudience::all();
        }

        public function store($data){
            return $galleryAudience = GalleryAudience::create($data);
        }

        public function fetch($id){
            return $galleryAudience = GalleryAudience::find($id);
        }

        public function update($data){
            return $data->save();
        }

        // public function delete($id){
        //     return $galleryAttachment = GalleryAudience::find($id)->delete();
        // }

        public function delete($idGallery){
            return $galleryAudience = GalleryAudience::where('id_gallery', $idGallery)->delete();
        }

        public function galleryAudienceType($idGallery){
            return GalleryAudience::where('id_gallery', $idGallery)
                                    ->groupBy('audience_type')->get();
        }

        public function allGalleryCategory($idGallery, $audienceType){
            return GalleryAudience::where('id_gallery', $idGallery)
                                    ->where('audience_type', $audienceType)
                                    ->select('id_staff_category')
                                    ->groupBy('id_staff_category')->get();
        }

        public function allGallerySubCategory($idGallery, $audienceType){
            return GalleryAudience::where('id_gallery', $idGallery)
                                    ->where('audience_type', $audienceType)
                                    ->select('id_staff_subcategory')
                                    ->groupBy('id_staff_subcategory')->get();
        }

        public function allGalleryStandards($idGallery, $audienceType){
            return GalleryAudience::where('id_gallery', $idGallery)
                                    ->where('audience_type', $audienceType)
                                    ->select('id_standard')
                                    ->groupBy('id_standard')->get();
        }
    }
?>
