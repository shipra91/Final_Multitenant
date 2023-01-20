<?php 
    namespace App\Repositories;
    use App\Models\SMSTemplate;
    use App\Interfaces\SMSTemplateRepositoryInterface;
    use League\Flysystem\Filesystem;
    use Storage;

    class SMSTemplateRepository implements SMSTemplateRepositoryInterface{

        public function all($allSessions){
            return SMSTemplate::where('id_institute', $institutionId)->get();            
        }

        public function store($data){
            return SMSTemplate::create($data);
        }        

        public function fetch($id){
            return SMSTemplate::find($id);
        }        

        public function update($data){
            return $data->save();
        }        

        public function delete($id){
            return SMSTemplate::find($id)->delete();
        }

        public function allDeleted($allSessions){
            return SMSTemplate::where('id_institute', $institutionId)->onlyTrashed()->get();            
        }        

        public function restore($id){
            return SMSTemplate::withTrashed()->find($id)->restore();
        } 
        
        public function restoreAll(){
            return SMSTemplate::onlyTrashed()->restore();
        }

        public function getInstitutionSenderId($allSessions) {
            
            $institutionId = $allSessions['institutionId'];
            return SMSTemplate::where('id_institute', $institutionId)->groupBy('sender_id')->get();
        }

        public function getSmsTemplatesUsingSenderId($senderId, $allSessions) {
            
            $institutionId = $allSessions['institutionId'];
            return SMSTemplate::where('id_institute', $institutionId)->where('sender_id', $senderId)->get();
        }

        public function getSmsTemplatesUsingModule($module, $allSessions) {
            
            $institutionId = $allSessions['institutionId'];
            return SMSTemplate::where('id_institute', $institutionId)->where('id_module', $module)->first();
        }

        public function getTemplatesDetailsUsingTemplateId($smsTemplateId) {
            return SMSTemplate::where('id', $smsTemplateId)->first();
        }
    }
?>