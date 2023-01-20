<?php
    namespace App\Repositories;
    use App\Models\Gallery;
    use App\Interfaces\GalleryRepositoryInterface;
    use Carbon\Carbon;
    use Storage;
    use Session;
    use DB;

    class GalleryRepository implements GalleryRepositoryInterface{

        public function all(){
            return Gallery::all();
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

        public function allDeleted(){
            return Gallery::onlyTrashed()->get();
        }

        public function restore($id){
            return Gallery::withTrashed()->find($id)->restore();
        }

        public function restoreAll(){
            return Gallery::onlyTrashed()->restore();
        }
    }
?>
