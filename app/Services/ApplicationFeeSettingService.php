<?php 
    namespace App\Services;
    use App\Models\ApplicationFeeSetting;
    use App\Services\ApplicationFeeSettingService;
    use App\Interfaces\ApplicationFeeSettingRepositoryInterface;
    use App\Interfaces\ApplicationSettingRepositoryInterface;
    use App\Services\InstitutionStandardService;
    use Carbon\Carbon;
    use Session;

    class ApplicationFeeSettingService 
    {
        private ApplicationFeeSettingRepositoryInterface $applicationFeeSettingRepository;
        private ApplicationSettingRepositoryInterface $applicationSettingRepository;
        private InstitutionStandardService $institutionStandardService;

        public function __construct(ApplicationFeeSettingRepositoryInterface $applicationFeeSettingRepository, InstitutionStandardService $institutionStandardService, ApplicationSettingRepositoryInterface $applicationSettingRepository)
        {
            $this->applicationFeeSettingRepository = $applicationFeeSettingRepository;
            $this->applicationSettingRepository = $applicationSettingRepository;
            $this->institutionStandardService = $institutionStandardService;
        }
        
        public function getAll(){

            $applicationFeeSetting = $this->applicationFeeSettingRepository->all();
            $applicationFeeSettingData = array();

            foreach($applicationFeeSetting as $index => $feeSetting){

                $standard = $this->institutionStandardService->fetchStandardByUsingId($feeSetting->id_standard);

                $application = $this->applicationSettingRepository->fetch($feeSetting->id_application_setting);

                $applicationFeeSettingData[$index] = $feeSetting;
                $applicationFeeSettingData[$index]['standard_name'] = $standard;
                $applicationFeeSettingData[$index]['application_name'] = $application->name;
            }
            
            return $applicationFeeSettingData;
        }

        public function find($id){

            $settingData = array();
            
            $feeSettingData = $this->applicationFeeSettingRepository->fetch($id);
            
            $standard = $this->institutionStandardService->fetchStandardByUsingId($feeSettingData->id_standard);

            $application = $this->applicationSettingRepository->fetch($feeSettingData->id_application_setting);

            $settingData = $feeSettingData;
            $settingData['standard_name'] = $standard;
            $settingData['application_name'] = $application->name;

            return $settingData;
        }

        public function add($applicationFeeSettingData){

            $insertedCount = 0;
            $existCount = 0;

            foreach($applicationFeeSettingData->standards as $standard){

                $check = ApplicationFeeSetting::where('id_academic_year', $applicationFeeSettingData->id_academic)->where('id_institute', $applicationFeeSettingData->id_institute)->where('id_application_setting', $applicationFeeSettingData->id_application_setting)->where('id_standard', $standard)->first();

                if(!$check){

                    $insertedCount++;

                    $data = array(
                        'id_academic_year' => $applicationFeeSettingData->id_academic, 
                        'id_institute' => $applicationFeeSettingData->id_institute, 
                        'id_application_setting' => $applicationFeeSettingData->application,  
                        'id_standard' => $standard, 
                        'fee_amount' => $applicationFeeSettingData->fee_amount,  
                        'receipt_prefix' => $applicationFeeSettingData->receipt_prefix,  
                        'receipt_starting_number' => $applicationFeeSettingData->receipt_starting_number,
                        'created_by' => Session::get('userId'),
                        'modified_by' => ''
                    );
                    
                    $storeData = $this->applicationFeeSettingRepository->store($data); 

                }

                $existCount++;

            }

            if($insertedCount > 0){

                $signal = 'success';
                $msg = 'Data inserted successfully!';

            }else if($existCount > 0){

                $signal = 'exist';
                $msg = 'This data already exists!';

            }else{

                $signal = 'failure';
                $msg = 'Error inserting data!';

            } 

            $output = array(
                'signal' => $signal,
                'message' => $msg
            );

            return $output;

        }
        
        public function update($applicationFeeSettingData, $id){

            $check = ApplicationFeeSetting::where('id_academic_year', $applicationFeeSettingData->id_academic)->where('id_institute', $applicationFeeSettingData->id_institute)->where('id_application_setting', $applicationFeeSettingData->application_id)->where('id_standard', $applicationFeeSettingData->standard_id)->where('id', '!=', $id)->first();

            if(!$check){

                $data = array(
                        'fee_amount' => $applicationFeeSettingData->fee_amount,  
                        'receipt_prefix' => $applicationFeeSettingData->receipt_prefix,  
                        'receipt_starting_number' => $applicationFeeSettingData->receipt_starting_number,
                        'created_by' => '',
                        'modified_by' => Session::get('userId')
                    );

                $storeData = $this->applicationFeeSettingRepository->update($data, $id); 
              
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
            
            $bloodGroup = $this->applicationFeeSettingRepository->delete($id);

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

        public function getDeletedRecords(){

            $data = array();
            $arraySettings = array();
            $settings = $this->applicationFeeSettingRepository->allDeleted();
            $settingData = array();

            foreach($settings as $index => $setting){

                $standard = $this->institutionStandardService->fetchStandardByUsingId($setting->id_standard);

                $application = $this->applicationSettingRepository->fetch($setting->id_application_setting);

                $settingData[$index] = $setting;
                $settingData[$index]['standard_name'] = $standard;
                $settingData[$index]['application_name'] = $application->name;
            }
            
            return $settingData;
        }

        public function restore($id){
            $module = $this->applicationFeeSettingRepository->restore($id);

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
            $module = $this->applicationFeeSettingRepository->restoreAll();

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
