<?php
    namespace App\Repositories;
    use App\Models\InstitutionSmsTemplates;
    use App\Interfaces\InstitutionSMSTemplateRepositoryInterface;
    use DB;

    class InstitutionSMSTemplateRepository implements InstitutionSMSTemplateRepositoryInterface{

        public function all(){
            return InstitutionSmsTemplates::all();
        }

        public function store($data){
            return $institutionSmsTemplate = InstitutionSmsTemplates::create($data);
        }

        public function fetch($smsFor, $allSessions){   
            
            $institutionId = $allSessions['institutionId'];    
            $institutionSmsTemplate = InstitutionSmsTemplates::where('id_institute', $institutionId)->where('sms_for', $smsFor)->first();
            return $institutionSmsTemplate;
        }


        public function getData($smsFor, $institutionId){   
             
            $institutionSmsTemplate = InstitutionSmsTemplates::where('id_institute', $institutionId)->where('sms_for', $smsFor)->first();
            return $institutionSmsTemplate;
        }

        public function fetchData($id){            
            return InstitutionSmsTemplates::find($id);
        }

        public function fetchDetails($smsFor, $allSessions){  
            
            $institutionId = $allSessions['institutionId'];   
                
            $institutionSmsTemplate = InstitutionSmsTemplates::where('id_institute', $institutionId)->where('sms_for', $smsFor)->get();
            return $institutionSmsTemplate;
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return $institutionSmsTemplate = InstitutionSmsTemplates::find($id)->delete();
        }
    }
