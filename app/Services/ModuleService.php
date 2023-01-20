<?php 
    namespace App\Services;
    use App\Models\Module;
    use App\Repositories\ModuleRepository;
    use DB;
    use Session;

    class ModuleService {
       
        public function getAll(){
            $moduleRepository = new ModuleRepository();
            $modules = $moduleRepository->allModules();
            $moduleArray = array();

            foreach($modules as $index => $module){
                $moduleArray[$index] = $module;

                $parentData = $moduleRepository->fetch($module['id_parent']);
                if($parentData){
                    $moduleArray[$index]['parent_display_name'] = $parentData->display_name;
                    $moduleArray[$index]['parent_label'] = $parentData->module_label;
                }else{
                    $moduleArray[$index]['parent_display_name'] = '-';
                    $moduleArray[$index]['parent_label'] = '-';
                }
                
            }
            return $moduleArray;
        }

        public function getAllParents(){
            $moduleRepository = new ModuleRepository();
            DB::enableQueryLog();
            $modules = $moduleRepository->allParents();
            // dd(DB::getQueryLog());
            return $modules;
        }

        public function find($id){
            $moduleRepository = new ModuleRepository();
            $module = $moduleRepository->fetch($id);
            return $module;
        }

        public function fetchRequiredModules($option){
            $moduleRepository = new ModuleRepository();
            $module = $moduleRepository->fetchModule($option);
            return $module;
        }

        public function getSmsModules(){
            $moduleRepository = new ModuleRepository();
            $modules = $moduleRepository->getSmsModule();
            return $modules;
        }

        public function add($moduleData){
            $moduleRepository = new ModuleRepository();
            
            $checkUnique = $check = Module::where('display_name', $moduleData->display_name)->first();
            if(!$checkUnique){
                $check = Module::where('module_label', $moduleData->module_label)->where('display_name', $moduleData->display_name)->where('type', $moduleData->access_type)->first();
                if(!$check){

                    if($moduleData->parent_id !=''){
                        $parentId = $moduleData->parent_id;
                    }else{
                        $parentId = 0;
                    }
                    
                    // s3 file upload function call
                    // $filePath = $moduleRepository->upload($moduleData);
                    $data = array(
                        'module_label' => $moduleData->module_label, 
                        'display_name' => $moduleData->display_name, 
                        'id_parent' => $parentId, 
                        'file_path' => $moduleData->file_path, 
                        'icon' => $moduleData->icon, 
                        'page' => $moduleData->page_name,
                        'type' => $moduleData->access_type,
                        'is_custom_field_required' => $moduleData->is_custom_field_required,
                        'is_sms_mapped' => $moduleData->sms_mapped,
                        'is_email_mapped' => $moduleData->email_mapped,
                        'created_by' => Session::get('userId')
                    );
                    
                    $storeData = $moduleRepository->store($data); 
                    
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

        public function update($moduleData, $id){
            
            $moduleRepository = new ModuleRepository();
            $check = Module::where('module_label', $moduleData->module_label)->where('display_name', $moduleData->display_name)->where('id', '!=', $id)->first();
            if(!$check){

                $getModuleData = $moduleRepository->fetch($id);

                if($moduleData->parent_id !=''){
                    $parentId = $moduleData->parent_id;
                }else{
                    $parentId = 0;
                }

                $getModuleData->module_label = $moduleData->module_label; 
                $getModuleData->display_name = $moduleData->display_name; 
                $getModuleData->id_parent = $parentId; 
                $getModuleData->file_path = $moduleData->file_path; 
                $getModuleData->icon = $moduleData->icon; 
                $getModuleData->page = $moduleData->page_name; 
                $getModuleData->is_custom_field_required = $moduleData->is_custom_field_required; 
                $getModuleData->is_sms_mapped = $moduleData->sms_mapped; 
                $getModuleData->is_email_mapped = $moduleData->email_mapped; 
                $getModuleData->type = $moduleData->access_type;
                $getModuleData->modified_by = Session::get('userId');

                $storeData = $moduleRepository->update($getModuleData); 
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
            $moduleRepository = new ModuleRepository();
            $module = $moduleRepository->delete($id);

            if($module){
                $signal = 'success';
                $msg = 'Data deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }

?>