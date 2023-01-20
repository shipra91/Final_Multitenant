<?php 
    namespace App\Repositories;
    use App\Models\MessageReport;
    use App\Interfaces\MessageReportRepositoryInterface;

    class MessageReportRepository implements MessageReportRepositoryInterface{

        public function all(){
            return MessageReport::all();            
        }

        public function store($data){
            return MessageReport::create($data);
        }        

        public function find($id){

            $messageSenderEntity = MessageReport::find($id);
            return $messageSenderEntity;
        } 

        public function fetch($idMessageCenter){
            return MessageReport::where('id_message_center', $idMessageCenter)->get();
        } 

        public function fetchSentMessages(){ //only sent messages not delivered messages
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            return MessageReport::where('completed', 'NO')->where('id_institute', $institutionId)
            ->where('id_academic', $academicId)->get();
        } 
        
        public function getTotalConsumedCredit(){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            return MessageReport::select(\DB::raw('SUM(sms_charge) as consumedCredit'))->where('id_institute', $institutionId)->first();
        }

        public function update($data){
            return $data->save();
        }        

        public function delete($id){
            return MessageReport::find($id)->delete();
        }
    }
?>