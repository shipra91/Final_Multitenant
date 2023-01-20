<?php
    namespace App\Repositories;
    use App\Models\MessageCredit;
    use App\Interfaces\MessageCreditRepositoryInterface;
    use DB;
    use Session;

    class MessageCreditRepository implements MessageCreditRepositoryInterface{
  
        public function all(){
            return MessageCredit::all();
        }

        public function store($data){
            return $messageCredit = MessageCredit::create($data);
        }

        public function fetch($id){            
            $messageCredit = MessageCredit::find($id);
            return $messageCredit;
        }

        public function fetchInstitutionCredit($institutionId){            
            $messageCredit = MessageCredit::where('id_institute', $institutionId)->first();
            return $messageCredit;
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $institutionType = MessageCredit::find($id)->delete();
        }

    }
