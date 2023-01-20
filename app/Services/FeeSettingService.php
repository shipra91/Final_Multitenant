<?php

namespace App\Services;

use App\Models\FeeSetting;
use App\Repositories\FeeSettingRepository;
use Session;
use Carbon\Carbon;

class FeeSettingService {

    public function fetchData(){
        $feeSettingDetails['concession_approval_required'] = '';
        $feeSettingRepository = new FeeSettingRepository();
        $feeSettingData = $feeSettingRepository->all();
        if($feeSettingData){
            $feeSettingDetails['concession_approval_required'] = $feeSettingData->concession_approval_required;
        }
        return $feeSettingDetails;
    }

    public function add($feeSettingData) {
        $feeSettingRepository = new FeeSettingRepository();
        $allSessions = session()->all();
        $institutionId = $allSessions['institutionId'];
        $academicYear = $allSessions['academicYear'];
         
        $check = $feeSettingRepository->all();
        if(!$check){

            $data = array(
                'id_institute'=>$institutionId,
                'id_academic'=>$academicYear,
                'concession_approval_required'=>$feeSettingData->concession_approval_required,
                'created_by' => Session::get('userId'),
                'created_at' => Carbon::now()
            );
            $store = $feeSettingRepository->store($data);

        } else {

            $check->concession_approval_required = $feeSettingData->concession_approval_required;
            $check->modified_by = Session::get('userId');
            $check->updated_at = Carbon::now();
            $store = $feeSettingRepository->update($check);
        }

        if($store){

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
}

?>