<?php

namespace App\Services;

use App\Models\FineSetting;
use App\Repositories\FineSettingRepository;
use App\Repositories\FineOptionsRepository;
use Session;
use Carbon\Carbon;

class FineSettingService {

    public function getOptionDetails(){
        $fineOptionsRepository = new FineOptionsRepository();
        return $fineOptionsRepository->all();
    }

    public function getSetting($allSessions){
        $data = array();
        $fineOptionsRepository = new FineOptionsRepository();
        $fineSettingRepository = new FineSettingRepository();
        $data = $fineSettingRepository->all($allSessions);
     
        if(count($data)>0) {
            $fineOptionDetails = $fineOptionsRepository->fetch($data[0]->label_fine_options);
            $data[0]['label'] = $fineOptionDetails->name;
        }
        return $data;
    }

    public function find($label){
        $fineSettingRepository = new FineSettingRepository();
        return $fineSettingRepository->fetchData($label);
    }

    public function getSettingDetails($labelFineOption, $allSessions){
        $fineSettingDetails = array();
        $settingTypes = array();
        $fineSettingRepository = new FineSettingRepository();

        $fineSetting = $fineSettingRepository->fetchData($labelFineOption, $allSessions);

        if($labelFineOption == 'FIXED' || $labelFineOption == 'PERDAY')
        {
            $settingTypes[0] = $labelFineOption;
        }else{
            $settingTypes[0] = 'FIXED';
            $settingTypes[1] = 'PERDAY';
        }

        $fine_setting_details = $fineSettingRepository->getData($allSessions);
        $fineSettingDetails = array(
            'fine_setting'=>$fineSetting,
            'label_fine_option'=>$labelFineOption,
            'setting_types'=>$settingTypes,
            'fine_setting_details'=>$fine_setting_details
        );
        return $fineSettingDetails;
    }

    public function add($fineSettingData) {
        
        $institutionId = $fineSettingData->id_institute;
        $academicYear = $fineSettingData->id_academic;
        $count = 0;
        $fineSettingRepository = new FineSettingRepository();
        foreach($fineSettingData->number_of_days as $key => $numberOfDays) {
          
            $data = array(
                'id_institute'=>$institutionId,
                'id_academic'=>$academicYear,
                'label_fine_options'=>$fineSettingData->fine_option,
                'number_of_days'=>$numberOfDays,
                'setting_type'=>$fineSettingData->setting_type[$key],
                'amount'=>$fineSettingData->amount[$key],
                'created_by' => Session::get('userId'),
                'created_at' => Carbon::now()
            );
            $store = $fineSettingRepository->store($data);

            if($store){
                $count  = $count + 1;
            }
        }
        if($count > 0){
            $signal = 'success';
            $msg = 'Data inserted successfully!';
        }else{
            $signal = 'failure';
            $msg = 'Error inserting data!';
        }

        $output = array(
            'signal'=>$signal,
            'message'=>$msg
        );
        return $output;
    }

    public function update($fineSettingData, $label) {
        $fineSettingRepository = new FineSettingRepository();
        $delete = $fineSettingRepository->delete($label);
        if($delete){
            $store = $this->add($fineSettingData);        
        }
        return $store;
    }

    public function delete($label) {
       
        $fineSettingRepository = new FineSettingRepository();
        $delete = $fineSettingRepository->delete($label);
        if($delete){
            $signal = 'success';
            $msg = 'Data deleted successfully!';
        }else{
            $signal = 'failure';
            $msg = 'Error in deleting!';
        }

        $output = array(
            'signal'=>$signal,
            'message'=>$msg
        );
        return $output;
    }
    
    public function getFineAmount($dueDate, $totalInstallmentFinePaid, $allSessions) {
        $fineSettingRepository = new FineSettingRepository();
        $fineDetails = array();
        $todaysDate = date('Y-m-d');
        $dueDate = strtotime($dueDate);
        $todaysDate = strtotime($todaysDate);
        $diff = $todaysDate - $dueDate;
        $numberOfDays = round($diff / 86400);
        $fineAmount = 0;
        $fineSettingDetails = $fineSettingRepository->getData($allSessions);
        foreach($fineSettingDetails as $key => $data) {
            if($numberOfDays>0) {
                if($numberOfDays <= $data->number_of_days) {
                    if($data->setting_type == 'FIXED') {
                        $fineAmount = $data->amount;
                    }else {
                        $fineAmount = $data->amount * $numberOfDays;
                    }
                    return $fineAmount;
                }
            }else{
                $fineAmount = 0;
            }
        }
        return $fineAmount;
    }
}
?>