<?php
    namespace App\Repositories;
    use App\Models\DocumentHeader;
    use App\Interfaces\DocumentHeaderRepositoryInterface;
    use DB;
    use Session;

    class DocumentHeaderRepository implements DocumentHeaderRepositoryInterface {

        public function all(){
            return DocumentHeader::all();
        }

        public function store($data){
            return DocumentHeader::create($data);
        }

        public function fetch($id){
            return DocumentHeader::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return DocumentHeader::find($id)->delete();
        }

        public function allDeleted(){
            return DocumentHeader::onlyTrashed()->get();
        }

        public function restore($id){
            return DocumentHeader::withTrashed()->find($id)->restore();
        }

        public function restoreAll(){
            return DocumentHeader::onlyTrashed()->restore();
        }
    }
