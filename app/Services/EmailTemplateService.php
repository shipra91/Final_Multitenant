<?php 
    namespace App\Services;
    use App\Models\EmailTemplate;
    use App\Repositories\EmailTemplateRepository;
    use App\Repositories\ModuleRepository;
    use Session;

    class EmailTemplateService {

        public function getAll(){

            $emailTemplateRepository = new EmailTemplateRepository();
            $moduleRepository = new ModuleRepository();

            $emailTemplates = $emailTemplateRepository->all();
            $arrayTemplates = array();
            foreach($emailTemplates as $index => $emailTemplate){

                $module = $moduleRepository->fetchByLabel($emailTemplate->id_module);

                $arrayTemplates[$index]['id'] = $emailTemplate->id;
                $arrayTemplates[$index]['id_institute'] = $emailTemplate->id_institute;
                $arrayTemplates[$index]['module'] = $module->display_name;
                $arrayTemplates[$index]['template_name'] = $emailTemplate->template_name;
                $arrayTemplates[$index]['template_detail'] = $emailTemplate->template_detail;

            }
            return $arrayTemplates;
        }

        public function find($id){
            $emailTemplateRepository = new EmailTemplateRepository();

            $emailTemplate = $emailTemplateRepository->fetch($id);
            return $emailTemplate;
        }

        public function add($emailData){
            
            $emailTemplateRepository = new EmailTemplateRepository();

            $check = EmailTemplate::where('id_institute', $emailData->id_institute)->where('id_module', $emailData->modules)->where('template_name', $emailData->template_name)->first();
            
            if(!$check){
                
                $data = array(
                    'id_institute' => $emailData->id_institute, 
                    'id_module' => $emailData->modules, 
                    'template_name' => $emailData->template_name,
                    'template_detail' => $emailData->template_description, 
                    'created_by' => Session::get('userId'),
                );
                $storeData = $emailTemplateRepository->store($data); 
                
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

        public function update($emailData, $id){
            
            $emailTemplateRepository = new EmailTemplateRepository();

            $check = EmailTemplate::where('id_institute', $emailData->id_institute)->where('id_module', $emailData->modules)->where('template_name', $emailData->template_name)->where('id', '!=', $id)->first();
            if(!$check){

                $getData = $emailTemplateRepository->fetch($id);
                
                $getData->id_module = $emailData->modules; 
                $getData->template_name = $emailData->template_name; 
                $getData->template_detail = $emailData->template_description; 
                $getData->modified_by = Session::get('userId');

                $storeData = $emailTemplateRepository->update($getData); 
                
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

            $emailTemplateRepository = new EmailTemplateRepository();

            $role = $emailTemplateRepository->delete($id);

            if($role){
                $signal = 'success';
                $msg = 'Data deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }        

        public function getDeletedRecords(){
            $data = array();
            $arrayTemplates = array();
            $emailTemplateRepository = new EmailTemplateRepository();
            $moduleRepository = new ModuleRepository();

            
            $allEmailTemplates = $emailTemplateRepository->allDeleted();

            foreach($allEmailTemplates as $index => $emailTemplate){

                $module = $moduleRepository->fetchByLabel($emailTemplate->id_module);

                $arrayTemplates[$index]['id'] = $emailTemplate->id;
                $arrayTemplates[$index]['id_institute'] = $emailTemplate->id_institute;
                $arrayTemplates[$index]['module'] = $module->display_name;
                $arrayTemplates[$index]['template_name'] = $emailTemplate->template_name;
                $arrayTemplates[$index]['template_detail'] = $emailTemplate->template_detail;

            }
            
            return $arrayTemplates;
        }

        public function restore($id){
            $emailTemplateRepository = new EmailTemplateRepository();

            $module = $emailTemplateRepository->restore($id);

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
            $emailTemplateRepository = new EmailTemplateRepository();

            $module = $emailTemplateRepository->restoreAll();

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
    }

?>