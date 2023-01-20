<?php
    namespace App\Repositories;
    use App\Models\MessageCreditDetails;
    use App\Interfaces\MessageCreditDetailsRepositoryInterface;
    use DB;
    use Session;

    class MessageCreditDetailsRepository implements MessageCreditDetailsRepositoryInterface{
  
        public function all($institutionId){

            return MessageCreditDetails::join('tbl_message_credit', 'tbl_message_credit_details.id_message_credit', '=', 'tbl_message_credit.id')->where('tbl_message_credit.id_institute', $institutionId)->get();
        }

        public function getData(){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            return MessageCreditDetails::where('id_institute', $institutionId)->where('id_academic', $academicId)->orderBy('number_of_days')->get();
        }

        public function fetchData($labelFineOption){
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            return MessageCreditDetails::where('id_institute', $institutionId)->where('id_academic', $academicId)->where('label_fine_options', $labelFineOption)->get();
        }

        public function store($data){
            return $messageCreditDetails = MessageCreditDetails::create($data);
        }

        public function fetch($id){            
            $messageCreditDetails = MessageCreditDetails::find($id);
            return $messageCreditDetails;
        }

        public function update($data){
            return $data->save();
        }

        public function delete($label){
            return $messageCreditDetails = MessageCreditDetails::where('label_fine_options', $label)->delete();
        }
    }
