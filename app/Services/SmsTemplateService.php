<?php 
    namespace App\Services;
    use App\Models\SMSTemplate;
    use App\Repositories\SMSTemplateRepository;
    use App\Repositories\ModuleRepository;
    use Session;

    class SMSTemplateService {
        public function getAll(){
            $moduleRepository = new ModuleRepository(); 
            $SMSTemplateRepository = new SMSTemplateRepository(); 
            $smsTemplates = $SMSTemplateRepository->all();
            $arrayTemplates = array();
            foreach($smsTemplates as $index => $smsTemplate){

                $module = $moduleRepository->fetchByLabel($smsTemplate->id_module);

                $arrayTemplates[$index]['id'] = $smsTemplate->id;
                $arrayTemplates[$index]['id_institute'] = $smsTemplate->id_institute;
                $arrayTemplates[$index]['module'] = $module->display_name;
                $arrayTemplates[$index]['template_name'] = $smsTemplate->template_name;
                $arrayTemplates[$index]['template_id'] = $smsTemplate->template_id;
                $arrayTemplates[$index]['sender_id'] = $smsTemplate->sender_id;
                $arrayTemplates[$index]['template_detail'] = $smsTemplate->template_detail;

            }
            return $arrayTemplates;
        }

        public function getRoleID($userType = ''){
            $SMSTemplateRepository = new SMSTemplateRepository(); 
            $smsTemplate = $SMSTemplateRepository->getRoleID($userType);
            return $smsTemplate;
        }

        public function find($id){
            $SMSTemplateRepository = new SMSTemplateRepository(); 
            $smsTemplate = $SMSTemplateRepository->fetch($id);
            return $smsTemplate;
        }

        public function add($smsData){
            
            $SMSTemplateRepository = new SMSTemplateRepository(); 
            $check = SmsTemplate::where('id_institute', $smsData->id_institute)->where('id_module', $smsData->modules)->where('template_name', $smsData->template_name)->first();
            
            if(!$check){
                
                $data = array(
                    'id_institute' => $smsData->id_institute, 
                    'id_module' => $smsData->modules, 
                    'template_name' => $smsData->template_name, 
                    'template_id' => $smsData->template_id, 
                    'sender_id' => $smsData->sender_id, 
                    'template_detail' => $smsData->template_description, 
                    'created_by' => Session::get('userId')
                );
                $storeData = $SMSTemplateRepository->store($data); 
                
                if($storeData) {

                    $signal = 'success';
                    $msg = 'Data inserted successfully!';

                }else{

                    $signal = 'failure';
                    $msg = 'Error inserting data!';

                } 

            }else{
                $signal = 'exist';
                $msg = 'This data already exists!';
            } 
            
            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;

        }

        public function update($smsData, $id){
            
            $SMSTemplateRepository = new SMSTemplateRepository(); 
            
            $check = SmsTemplate::where('id_institute', $smsData->id_institute)->where('id_module', $smsData->modules)->where('template_name', $smsData->template_name)->where('id', '!=', $id)->first();
            if(!$check){

                $getData = $SMSTemplateRepository->fetch($id);

                $getData->id_module = $smsData->modules; 
                $getData->template_name = $smsData->template_name; 
                $getData->template_id = $smsData->template_id;  
                $getData->sender_id = $smsData->sender_id;
                $getData->template_detail = $smsData->template_description; 
                $getData->modified_by = Session::get('userId');

                $storeData = $SMSTemplateRepository->update($getData); 
                
                if($storeData) {

                    $signal = 'success';
                    $msg = 'Data updated successfully!';

                }else{

                    $signal = 'failure';
                    $msg = 'Error updating data!';

                } 

            }else{
                $signal = 'exist';
                $msg = 'This data already exists!';
            } 
            
            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function delete($id){

            $SMSTemplateRepository = new SMSTemplateRepository(); 
            $role = $SMSTemplateRepository->delete($id);

            if($role){
                $signal = 'success';
                $msg = 'Role deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }        

        public function getDeletedRecords(){
            $moduleRepository = new ModuleRepository(); 
            $SMSTemplateRepository = new SMSTemplateRepository(); 
            $data = array();
            $arrayTemplates = array();
            $allSmsTemplates = $SMSTemplateRepository->allDeleted();

            foreach($allSmsTemplates as $index => $smsTemplate){

                $module = $moduleRepository->fetchByLabel($smsTemplate->id_module);

                $arrayTemplates[$index]['id'] = $smsTemplate->id;
                $arrayTemplates[$index]['id_institute'] = $smsTemplate->id_institute;
                $arrayTemplates[$index]['module'] = $module->display_name;
                $arrayTemplates[$index]['template_name'] = $smsTemplate->template_name;
                $arrayTemplates[$index]['template_id'] = $smsTemplate->template_id;
                $arrayTemplates[$index]['sender_id'] = $smsTemplate->sender_id;
                $arrayTemplates[$index]['template_detail'] = $smsTemplate->template_detail;

            }
            
            return $arrayTemplates;
        }

        public function restore($id){
            $SMSTemplateRepository = new SMSTemplateRepository(); 
            $module = $SMSTemplateRepository->restore($id);

            if($module){
                $signal = 'success';
                $msg = 'Data restored successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function restoreAll(){
            $SMSTemplateRepository = new SMSTemplateRepository(); 
            $module = $SMSTemplateRepository->restoreAll();

            if($module){
                $signal = 'success';
                $msg = 'Data restored successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function getInstitutionSenderId() {
            $SMSTemplateRepository = new SMSTemplateRepository(); 
            $senderIdDetails = $SMSTemplateRepository->getInstitutionSenderId();
            return $senderIdDetails;
        }

        public function getSmsTemplatesUsingSenderId($request) {
            $SMSTemplateRepository = new SMSTemplateRepository(); 
            $senderId = $request['senderId'];
            $senderIdDetails = $SMSTemplateRepository->getSmsTemplatesUsingSenderId($senderId);
            return $senderIdDetails;
        }

        public function getTemplatesDetailsUsingTemplateId($request) {
            $SMSTemplateRepository = new SMSTemplateRepository(); 
            $smsTemplateId = $request['smsTemplateId'];
            $smsTemplateDetails = $SMSTemplateRepository->getTemplatesDetailsUsingTemplateId($smsTemplateId);
            return $smsTemplateDetails;
        }
    }

?>