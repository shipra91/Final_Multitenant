<?php
    namespace App\Repositories;
    use App\Models\Gallery;
    use App\Interfaces\GalleryRepositoryInterface;
    use Carbon\Carbon;
    use Storage;
    use Session;
    use DB;

    class GalleryRepository implements GalleryRepositoryInterface{

        public function all($allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return Gallery::where('id_institution', $institutionId)->where('id_academic_year', $academicId)->get();
        }

        public function store($data){
            return $gallery = Gallery::create($data);
        }

        public function fetch($id){
            return $gallery = Gallery::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $gallery = Gallery::find($id)->delete();
        }

        public function allDeleted($allSessions){
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return Gallery::where('id_institution', $institutionId)->where('id_academic_year', $academicId)->onlyTrashed()->get();
        }

        public function restore($id){
            return Gallery::withTrashed()->find($id)->restore();
        }

        public function restoreAll($allSessions){
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            return Gallery::where('id_institution', $institutionId)->where('id_academic_year', $academicId)->onlyTrashed()->restore();
        }
    }
?>
