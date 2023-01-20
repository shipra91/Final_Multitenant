<?php

namespace App\Services;

use App\Models\CurrencyDenomination;
use App\Repositories\CurrencyDenominationRepository;
use Session;


class CurrencyDenominationService{

    public function add($data, $idFeeCollection) {
        $allSessions = session()->all();
        $institutionId = $allSessions['institutionId'];
        $academicId = $data->academicId;
        $currencyDenominationRepository = new CurrencyDenominationRepository();

        $denomination = array();
        $denomination['2000'] = $data->two_thousand;
        $denomination['500'] = $data->five_hundred;
        $denomination['200'] = $data->two_hundred;
        $denomination['100'] = $data->hundred;
        $denomination['50'] = $data->fifty;
        $denomination['20'] = $data->twenty;
        $denomination['10'] = $data->ten;
        $denomination['5'] = $data->five;
        $denomination['2'] = $data->two;
        $denomination['1'] = $data->one;
      
        foreach($denomination as $key => $currency){

            if(empty($currency)) {
                $currency = 0;
            }

            $denominationData = array(
                'id_institute' => $institutionId,
                'id_academic' => $academicId,
                'id_student' => $data->studentId,
                'id_fee_collection' => $idFeeCollection,
                'denomination_type' => $key,
                'denomination_count' => $currency,
                'created_by' => Session::get('userId')
            );
           

            $store = $currencyDenominationRepository->store($denominationData);
        }
    }
}
?>