<?php 
    namespace App\Services;
    use App\Models\PreadmissionApplicationSetting;
    use App\Services\ApplicationSettingService;
    use App\Repositories\ApplicationSettingRepository;
    use App\Services\InstitutionStandardService;
    use Carbon\Carbon;
    use Session;

    class ApplicationSettingService 
    {
        
        public function getAll($allSessions){

            $applicationSettingRepository = new ApplicationSettingRepository();
            $institutionStandardService = new InstitutionStandardService();

            $applicationSetting = $applicationSettingRepository->all($allSessions);
            $applicationSettingData = array();

            foreach($applicationSetting as $index => $setting){
                $standards = explode(",", $setting['standards']);
                $standardData = array();

                $applicationSettingData[$index] = $setting;

                foreach($standards as $standardId){
                    $standard = $institutionStandardService->fetchStandardByUsingId($standardId);
                    
                    array_push($standardData, $standard);
                }
                $standardData = implode(", ", $standardData);
                $applicationSettingData[$index]['standardName'] = $standardData;
            }
            
            return $applicationSettingData;
        }

        public function find($id){
            $applicationSettingRepository = new ApplicationSettingRepository();

            return $applicationSettingRepository->fetch($id);
        }

        public function add($applicationSettingData)
        {
            $applicationSettingRepository = new ApplicationSettingRepository();

            $check = PreadmissionApplicationSetting::where('id_academic', $applicationSettingData->id_academic)->where('id_institution', $applicationSettingData->id_institute)->where('name', $applicationSettingData->application_name)->first();

            if(!$check){
              
                $data = array(
                    'id_academic' => $applicationSettingData->id_academic, 
                    'id_institution' => $applicationSettingData->id_institute, 
                    'name' => $applicationSettingData->application_name,  
                    'prefix' => $applicationSettingData->application_prefix,  
                    'starting_number' => $applicationSettingData->application_starting_number,  
                    'standards' => implode(",", $applicationSettingData->standards), 
                    'created_by' => Session::get('userId'),
                    'modified_by' => ''
                );
                $storeData = $applicationSettingRepository->store($data); 
                
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

        public function update($applicationSettingData, $id){

            $applicationSettingRepository = new ApplicationSettingRepository();

            $check = PreadmissionApplicationSetting::where('id_academic', $applicationSettingData->id_academic)->where('id_institution', $applicationSettingData->id_institute)->where('name', $applicationSettingData->application_name)->where('id', '!=', $id)->first();

            if(!$check){

                $data = array(
                    'id_academic' => $applicationSettingData->id_academic, 
                    'id_institution' => $applicationSettingData->id_institute, 
                    'name' => $applicationSettingData->application_name,  
                    'prefix' => $applicationSettingData->application_prefix,  
                    'starting_number' => $applicationSettingData->application_starting_number,  
                    'standards' => implode(",", $applicationSettingData->standards), 
                    'created_by' => '',
                    'modified_by' => Session::get('userId')
                );

                $storeData = $applicationSettingRepository->update($data, $id); 
              
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
            
            $bloodGroup = $applicationSettingRepository->delete($id);

            if($bloodGroup){
                $signal = 'success';
                $msg = 'Data deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function getDeletedRecords($allSessions){

            $applicationSettingRepository = new ApplicationSettingRepository();
            $institutionStandardService = new InstitutionStandardService();

            $data = array();
            $arraySettings = array();
            $settings = $applicationSettingRepository->allDeleted($allSessions);
            $applicationSettingData = array();

            foreach($settings as $index => $setting){
                $standards = explode(",", $setting['standards']);
                $standardData = array();

                $applicationSettingData[$index] = $setting;

                foreach($standards as $standardId){
                    $standard = $institutionStandardService->fetchStandardByUsingId($standardId);
                    
                    array_push($standardData, $standard);
                }
                $standardData = implode(", ", $standardData);
                $applicationSettingData[$index]['standardName'] = $standardData;
            }
            
            return $applicationSettingData;
        }

        public function restore($id){
            $applicationSettingRepository = new ApplicationSettingRepository();

            $module = $applicationSettingRepository->restore($id);

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
            $applicationSettingRepository = new ApplicationSettingRepository();

            $module = $applicationSettingRepository->restoreAll();

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
