<?php 
    namespace App\Services;
    use App\Models\DynamicTokens;
    use App\Repositories\DynamicTokensRepository;
    use App\Repositories\ModuleDynamicTokensMappingRepository;

    class ModuleDynamicTokensMappingService {
        public function getAll(){
            $dynamicTokensRepository = new DynamicTokensRepository();
            return $dynamicTokensRepository->all();
        }

        public function find($id){
            $dynamicTokensRepository = new DynamicTokensRepository();
            return $dynamicTokensRepository->fetch($id);
        }
        
        public function getModuleTokens($module){
            $dynamicTokensRepository = new DynamicTokensRepository();
            $moduleDynamicTokensMappingRepository = new ModuleDynamicTokensMappingRepository();
            $output = array();

            $mappedModules = $moduleDynamicTokensMappingRepository->getAllMappedModules($module);
            if($mappedModules){
                $isMappedWith = explode(",", $mappedModules->is_mapped_with);
                // dd($mappedAllModules);
                foreach($isMappedWith as $key => $module){
                    $output[$key]['module'] = $module;
                    $output[$key]['tokens'] = $dynamicTokensRepository->getAllTokens($module);                
                }
            }
            
            return $output;
        }

        // public function add($moduleData){
            
        //     $check = Module::where('module_label', $moduleData->module_label)->where('display_name', $moduleData->display_name)->where('type', $moduleData->access_type)->first();
        //     if(!$check){

        //         if($moduleData->parent_id !=''){
        //             $parentId = $moduleData->parent_id;
        //         }else{
        //             $parentId = 0;
        //         }
                
        //         // s3 file upload function call
        //         // $filePath = $this->moduleRepository->upload($moduleData);
        //         $data = array(
        //             'module_label' => $moduleData->module_label, 
        //             'display_name' => $moduleData->display_name, 
        //             'id_parent' => $parentId, 
        //             'file_path' => $moduleData->file_path, 
        //             'icon' => $moduleData->icon, 
        //             'type' => $moduleData->access_type,
        //             'created_by' => 'admin'
        //         );
                
        //         $storeData = $this->moduleRepository->store($data); 
                
        //         if($storeData) {

        //             $signal = 'success';
        //             $msg = 'Data inserted successfully!';

        //         }else{

        //             $signal = 'failure';
        //             $msg = 'Error inserting data!';

        //         } 

        //     }else{
        //         $signal = 'exist';
        //         $msg = 'This data already exists!';
        //     } 
            
        //     $output = array(
        //         'signal'=>$signal,
        //         'message'=>$msg
        //     );

        //     return $output;

        // }

        // public function update($moduleData, $id){
            
        //     $check = Module::where('module_label', $moduleData->module_label)->where('display_name', $moduleData->display_name)->where('id', '!=', $id)->first();
        //     if(!$check){

        //         if($moduleData->parent_id !=''){
        //             $parentId = $moduleData->parent_id;
        //         }else{
        //             $parentId = 0;
        //         }

        //         $data = array(
        //             'module_label' => $moduleData->module_label, 
        //             'display_name' => $moduleData->display_name, 
        //             'id_parent' => $parentId, 
        //             'file_path' => $moduleData->file_path, 
        //             'icon' => $moduleData->icon, 
        //             'type' => $moduleData->access_type,
        //             'modified_by' => 'admin'
        //         );

        //         $storeData = $this->moduleRepository->update($data, $id); 
        //         if($storeData) {

        //             $signal = 'success';
        //             $msg = 'Data updated successfully!';

        //         }else{

        //             $signal = 'failure';
        //             $msg = 'Error updating data!';

        //         } 

        //     }else{
        //         $signal = 'exist';
        //         $msg = 'This data already exists!';
        //     } 
            
        //     $output = array(
        //         'signal'=>$signal,
        //         'message'=>$msg
        //     );

        //     return $output;
        // }

        // public function delete($id){
        //     $module = $this->moduleRepository->delete($id);

        //     if($module){
        //         $signal = 'success';
        //         $msg = 'Data deleted successfully!';
        //     }

        //     $output = array(
        //         'signal'=>$signal,
        //         'message'=>$msg
        //     );

        //     return $output;
        // }
    }

?>