<?php
    namespace App\Services;

    use App\Models\PreadmissionApplicationSetting;
    use App\Services\ApplicationSettingService;
    use App\Interfaces\ApplicationSettingRepositoryInterface;
    use App\Services\InstitutionStandardService;
    use Carbon\Carbon;
    use Session;

    class ApplicationSettingService {

        private ApplicationSettingRepositoryInterface $applicationSettingRepository;
        private InstitutionStandardService $institutionStandardService;

        public function __construct(ApplicationSettingRepositoryInterface $applicationSettingRepository, InstitutionStandardService $institutionStandardService){

            $this->applicationSettingRepository = $applicationSettingRepository;
            $this->institutionStandardService = $institutionStandardService;
        }

        public function getAll(){

            $applicationSetting = $this->applicationSettingRepository->all();
            $applicationSettingData = array();

            foreach($applicationSetting as $index => $setting){
                $standards = explode(",", $setting['standards']);
                $standardData = array();

                $applicationSettingData[$index] = $setting;

                foreach($standards as $standardId){
                    $standard = $this->institutionStandardService->fetchStandardByUsingId($standardId);

                    array_push($standardData, $standard);
                }

                $standardData = implode(", ", $standardData);
                $applicationSettingData[$index]['standardName'] = $standardData;
            }

            return $applicationSettingData;
        }

        public function find($id){
            return $this->applicationSettingRepository->fetch($id);
        }

        public function add($applicationSettingData){

            // dd($applicationSettingData);
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

                $storeData = $this->applicationSettingRepository->store($data);

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

            $check = PreadmissionApplicationSetting::where('id_academic', $applicationSettingData->id_academic)
                                                    ->where('id_institution', $applicationSettingData->id_institute)
                                                    ->where('name', $applicationSettingData->application_name)
                                                    ->where('id', '!=', $id)
                                                    ->first();

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

                $storeData = $this->applicationSettingRepository->update($data, $id);

                if($storeData){

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

            $applicationSetting = $this->applicationSettingRepository->delete($id);

            if($applicationSetting){
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
            $settings = $this->applicationSettingRepository->allDeleted();
            $applicationSettingData = array();

            foreach($settings as $index => $setting){

                $standards = explode(",", $setting['standards']);
                $standardData = array();

                $applicationSettingData[$index] = $setting;

                foreach($standards as $standardId){

                    $standard = $this->institutionStandardService->fetchStandardByUsingId($standardId);
                    array_push($standardData, $standard);
                }

                $standardData = implode(", ", $standardData);
                $applicationSettingData[$index]['standardName'] = $standardData;
            }

            return $applicationSettingData;
        }

        public function restore($id){

            $module = $this->applicationSettingRepository->restore($id);

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

            $module = $this->applicationSettingRepository->restoreAll();

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
