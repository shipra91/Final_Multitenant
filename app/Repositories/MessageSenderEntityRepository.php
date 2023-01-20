<?php
    namespace App\Repositories;
    use App\Models\MessageSenderEntity;
    use App\Interfaces\MessageSenderEntityRepositoryInterface;
    use DB;
    use Session;

    class MessageSenderEntityRepository implements MessageSenderEntityRepositoryInterface{
  
        public function all(){
            return MessageSenderEntity::orderBy('created_at', 'ASC')->get();
        }

        public function store($data){
            return $messageSenderEntity = MessageSenderEntity::create($data);
        }

        public function fetch($id){            
            $messageSenderEntity = MessageSenderEntity::find($id);
            return $messageSenderEntity;
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return MessageSenderEntity::find($id)->delete();
        }

        public function allDeleted(){
            return MessageSenderEntity::onlyTrashed()->get();
        }        

        public function restore($id){
            return MessageSenderEntity::withTrashed()->find($id)->restore();
        }

        public function restoreAll(){
            return MessageSenderEntity::onlyTrashed()->restore();
        }

        public function fetchDetails($senderId){            
            $messageSenderEntity = MessageSenderEntity::where('sender_id', $senderId)->first();
            return $messageSenderEntity;
        }


    }
