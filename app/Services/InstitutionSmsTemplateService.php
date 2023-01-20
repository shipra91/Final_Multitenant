<?php 
    namespace App\Services;
    use App\Repositories\InstitutionSMSTemplateRepository;
    use App\Repositories\InstitutionRepository;
    use App\Repositories\SMSTemplateRepository;
    use App\Models\InstitutionSmsTemplates;
    use Session;
    use Carbon\Carbon;

    class InstitutionSMSTemplateService {

        public function getSmsModuleDetails() {
            $institutionSMSTemplateRepository = new InstitutionSMSTemplateRepository();
            $SMSTemplateRepository = new SMSTemplateRepository(); 
            $institutionRepository = new InstitutionRepository();
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];

            $smsFor = array();
            $smsModuleDetails = array();
            $smsModuleDetails['mc_template_id'] = array();
            $smsModuleDetails['mc_sms_template_details'] = array();
            $smsModuleDetails['mc_template_details'] = array();
           
            $institutionDetails = $institutionRepository->fetch($institutionId);
            $institutionSenderId = $institutionDetails->sender_id;
            $institutionEntityId = $institutionDetails->entity_id;
            $smsModuleDetails['institution_sender_id'] = $institutionSenderId;
            $smsModuleDetails['institution_entity_id'] = $institutionEntityId;
            $smsModuleDetails['smsModules'] = ['OTP', 'ATTENDANCE', 'RESULT', 'FEE', 'MESSAGE_CENTER'];      

            foreach($smsModuleDetails['smsModules'] as $module) {
                if($module == 'OTP') {
                    $smsFor = ['OTP']; 
                }
                if($module == 'ATTENDANCE') {
                    $smsFor = ['DAYWISE', 'SESSIONWISE', 'PERIODWISE']; 
                }
                if($module == 'RESULT') {
                    $smsFor = ['RESULT']; 
                    
                }
                if($module == 'FEE') {
                    $smsFor = ['PAID', 'BALANCE']; 
                }

                if($module == 'MESSAGE_CENTER') {
                    $smsFor = ['MESSAGE_CENTER']; 
                }

                $smsModuleDetails[$module] = $smsFor;

                foreach($smsFor as $data) {
                    $smsModuleDetails[$data.'_sms_template_details'] =  array();
                    if($data != 'MESSAGE_CENTER') {
                        $details = $institutionSMSTemplateRepository->fetch($data);
                        if($details){
                            $templateId = $details->sms_template_id;
                            $senderId = $details->sender_id;
                            $smsTemplateDetails = $SMSTemplateRepository->getSmsTemplatesUsingSenderId($senderId);
                            $templateDetails = $SMSTemplateRepository->getTemplatesDetailsUsingTemplateId($templateId);
                            $smsModuleDetails[$data.'_id'] = $details->id;
                            $smsModuleDetails[$data.'_sender_id'] = $senderId;
                            $smsModuleDetails[$data.'_template_id'] = $templateId;
                            $smsModuleDetails[$data.'_sms_template_details'] = $smsTemplateDetails;
                            $smsModuleDetails[$data.'_template_details'] = $templateDetails->template_detail;
                            if($details->status == 1){
                                $checked ='checked';
                                $title = 'Deactivate!';
                            }
                            else {
                                $checked ='';
                                $title = 'Activate';
                            }
                            $smsModuleDetails[$data.'status'] = $details->status;
                            $smsModuleDetails[$data.'checked'] = $checked;
                            $smsModuleDetails[$data.'title'] = $title;

                        }
                        else{
                            $smsModuleDetails[$data.'_id'] = '';
                            $smsModuleDetails[$data.'_sender_id'] = '';
                            $smsModuleDetails[$data.'_template_id'] = '';
                            $smsModuleDetails[$data.'_template_details'] = '';
                            $smsModuleDetails[$data.'status'] = '';
                            $smsModuleDetails[$data.'checked'] = '';
                            $smsModuleDetails[$data.'title'] = '';
                        }
                    }else {
                        if(!empty($institutionSenderId)) {
                            $smsTemplateDetails = $SMSTemplateRepository->getSmsTemplatesUsingSenderId($institutionSenderId);
                            $smsModuleDetails['mc_sms_template_details'][] = $smsTemplateDetails;
                        }
                        $messageDetails = $institutionSMSTemplateRepository->fetchDetails($data);
                        if(count($messageDetails) > 0){
                            foreach($messageDetails as $details) {
                                $templateId = $details->sms_template_id;
                                $senderId = $details->sender_id;
                                
                                $templateDetails = $SMSTemplateRepository->getTemplatesDetailsUsingTemplateId($templateId);
                                if($templateDetails){
                                    $smsModuleDetails['mc_template_id'][] = $templateId;
                                    $smsModuleDetails['mc_template_details'][] = $templateDetails->template_detail;
                                }                                
                              
                                if(!empty($institutionSenderId)) {
                                    $smsTemplateDetails = $SMSTemplateRepository->getSmsTemplatesUsingSenderId($institutionSenderId);
                                    $smsModuleDetails['mc_sms_template_details'][] = $smsTemplateDetails;
                                }
                            }
                        }
                    }
                }
            }
            // dd($smsModuleDetails);
            return $smsModuleDetails;
        }

        public function add($smsTemplateData){
            $institutionSMSTemplateRepository = new InstitutionSMSTemplateRepository();
            $smsTemplateDetails = '';
            $institutionRepository = new InstitutionRepository();
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $smsModuleDetails = $this->getSmsModuleDetails();

            $senderId = $smsTemplateData->mc_sender_id;
            $entityId = $smsTemplateData->entity_id;
            $institutionDetails = $institutionRepository->fetch($institutionId);
            $institutionDetails->sender_id = $senderId;
            $institutionDetails->entity_id = $entityId;
            $update = $institutionRepository->update($institutionDetails);

            $storeCount = 0;
            $status = 1;
            foreach($smsModuleDetails['smsModules'] as $module) {
                if($module != 'MESSAGE_CENTER') {
                    foreach($smsModuleDetails[$module] as $smsFor) {
                      
                        $senderIdLabel = $smsFor.'_sender_id';
                        $smsTemplateLabel = $smsFor.'_sms_template';
                        if(!empty($smsTemplateData->$senderIdLabel)) {
                            $check = InstitutionSmsTemplates::where('id_institute', $institutionId)->where('sms_for', $smsFor)->first();
           
                            if(!$check){
                                $smsTemplateDetails = array(
                                'id_institute' => $institutionId, 
                                "module_name"=>$module,
                                "sms_for"=>$smsFor,
                                "sender_id"=>$smsTemplateData->$senderIdLabel,
                                "sms_template_id"=>$smsTemplateData->$smsTemplateLabel,
                                "status"=>$status,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                                );

                                $store = $institutionSMSTemplateRepository->store($smsTemplateDetails);
                            }
                            else{
                                $check->sender_id = $smsTemplateData->$senderIdLabel;
                                $check->sms_template_id = $smsTemplateData->$smsTemplateLabel;
                                $store = $institutionSMSTemplateRepository->update($check);
                            }
                            if($store) {
                                ++$storeCount;
                            }
                        }
                    }
                }else
                {
                    foreach($smsTemplateData->mc_sms_template as $smsTemplateId){
                        if(!empty($smsTemplateId)) {
                            $check = InstitutionSmsTemplates::where('id_institute', $institutionId)->where('sms_for', $module)->where('sender_id', $senderId)->where('sms_template_id', $smsTemplateId)->first();
                            if(!$check){
                                $smsTemplateDetails = array(
                                    'id_institute' => $institutionId, 
                                    "module_name"=>$module,
                                    "sms_for"=>$module,
                                    "sender_id"=>$senderId,
                                    "sms_template_id"=>$smsTemplateId,
                                    "status"=>$status,
                                    'created_by' => Session::get('userId'),
                                    'created_at' => Carbon::now()
                                    );
                                $store = $institutionSMSTemplateRepository->store($smsTemplateDetails);
                            }
                            else{
                                $check->sender_id = $senderId;
                                $check->sms_template_id = $smsTemplateId;
                                $store = $institutionSMSTemplateRepository->update($check);
                            }
                            if($store) {
                                ++$storeCount;
                            }
                        }
                    }
                }
            }
            if($storeCount > 0){
                $signal = 'success';
                $msg = 'Data updated successfully!';

            }else{
                $signal = 'failure';
                $msg = 'Error updating data!';
            }
            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function update($data, $id) {
            $institutionSMSTemplateRepository = new InstitutionSMSTemplateRepository();
            $details = $institutionSMSTemplateRepository->fetchData($id);
            if($details->status == 1){
                $status = 0;
            }
            else {
                $status = 1 ;
            }
            $details->status = $status;
            $update = $institutionSMSTemplateRepository->update($details);

            if($update){
                $signal = 'success';
                $msg = 'Updated successfully!';

            }else{
                $signal = 'failure';
                $msg = 'Error in updating!';
            }
            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function getSenderIdForModule($module) {
            
            $institutionSmsTemplateRepository = new InstitutionSmsTemplateRepository();
            return $institutionSmsTemplateRepository->fetch($module);     
        }
    } 

?>