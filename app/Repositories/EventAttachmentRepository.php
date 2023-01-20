<?php
    namespace App\Repositories;

    use App\Models\EventAttachment;
    use App\Interfaces\EventAttachmentRepositoryInterface;

    class EventAttachmentRepository implements EventAttachmentRepositoryInterface {

        public function all(){
            return EventAttachment::all();
        }

        public function store($data){
            return $data = EventAttachment::create($data);
        }

        public function fetch($id){
            return $data = EventAttachment::where('id_event', $id)->get();
        }

        public function update($data){
            return $data->save();
        }

        // public function delete($idEvent){
        //     return $data = EventAttachment::where('id_event', $idEvent)->delete();
        // }

        public function delete($id){
            return $data = EventAttachment::find($id)->delete();
        }
    }
