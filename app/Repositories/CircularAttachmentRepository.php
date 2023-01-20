<?php
    namespace App\Repositories;

    use App\Models\CircularAttachment;
    use App\Interfaces\CircularAttachmentRepositoryInterface;

    class CircularAttachmentRepository implements CircularAttachmentRepositoryInterface{

        public function all(){
            return CircularAttachment::all();
        }

        public function store($data){
            return $data = CircularAttachment::create($data);
        }

        public function fetch($idCircular){
            return $data = CircularAttachment::where('id_circular', $idCircular)->get();
        }

        public function update($data){
            return $data->save();
        }

        // public function delete($idCircular){
        //     return $data = CircularAttachment::where('id_circular', $idCircular)->delete();
        // }

        public function delete($id){
            return $data = CircularAttachment::find($id)->delete();
        }
    }
