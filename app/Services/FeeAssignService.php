<?php
    namespace App\Services;
    use App\Models\FeeAssign;
    use App\Repositories\FeeMasterRepository;
    use App\Repositories\FeeAssignRepository;
    use App\Repositories\FeeAssignDetailRepository;
    use App\Repositories\FeeAssignSettingRepository;
    use App\Repositories\FeeCollectionDetailRepository;
    use App\Repositories\FeeCategorySettingRepository;
    use App\Repositories\FeeInstallmentRepository;
    use Carbon\Carbon;
    use Session;
    use DB;

    class FeeAssignService{

        public function assignFeeForStudent($idStandard, $idFeeType, $idStudent){

            $totalAmount = 0;
<<<<<<< HEAD
            $feeAssign_id = '';
=======
>>>>>>> main
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $organizationId = $allSessions['organizationId'];
            $academicYear = $allSessions['academicYear'];

            $feeMasterRepository = new FeeMasterRepository();
            $feeAssignRepository = new FeeAssignRepository();
            $feeAssignDetailRepository = new FeeAssignDetailRepository();
            $feeAssignSettingRepository = new FeeAssignSettingRepository();
            $feeCollectionDetailRepository = new FeeCollectionDetailRepository();
            $feeCategorySettingRepository = new FeeCategorySettingRepository();
            $feeInstallmentRepository =  new FeeInstallmentRepository();

            $getFeeMasterDetails = $feeMasterRepository->getInstallmentTypeDetails($idStandard, $idFeeType);
            // dd($getFeeMasterDetails);
            if(count($getFeeMasterDetails) > 0) {
                $deleteAllAssignedFee = $feeAssignRepository->delete($idStudent);
                foreach($getFeeMasterDetails as $feeCategory){

                    $idFeeCategory = $feeCategory->id_fee_category;
                    $checkFeeCollectionForCategory = $feeCollectionDetailRepository->getCollectionForFeeCategory($idFeeCategory, $idStudent);
                   
                    if(!$checkFeeCollectionForCategory) {

                        // Assigning fee type
                        $checkAssign = $feeAssignRepository->checkFeeAssignAvaibility($idStandard, $idStudent, $idFeeCategory, $idFeeType);

                        $requestData = array(
                            'idFeeCategory' => $idFeeCategory,
                            'standard' => $idStandard,
                            'feeType' => $idFeeType
                        );
                    
                        $totalAmount = $feeMasterRepository->getFeeTypeAmount($requestData);  
                    
                        $getFeeMasterData = $feeMasterRepository->getInstallmentType($idFeeCategory, $idStandard, $idFeeType);
                      
                        if($getFeeMasterData){

                            if($getFeeMasterData->installment_type == 'HEADING_WISE'){

                                $noOfInstallment = 0;

                                // Fee assign
                                if(!$checkAssign){

                                    $data = array(
                                        'id_organization' => $organizationId,
                                        'id_institution' => $institutionId,
                                        'id_academic' => $academicYear,
                                        'id_standard' => $idStandard,
                                        'id_student' => $idStudent,
                                        'id_fee_category' => $idFeeCategory,
                                        'id_fee_type' => $idFeeType,
                                        'total_amount' => $totalAmount,
                                        'no_of_installment' => $noOfInstallment,
                                        'installment_type' => $getFeeMasterData->installment_type,
                                        'created_by' => Session::get('userId'),
                                        'created_at' => Carbon::now()
                                    );

                                    $storeFeeAssign = $feeAssignRepository->store($data);
                                    $feeAssign_id = $storeFeeAssign->id;

                                }else{

                                    $feeAssign_id = $checkAssign->id;

                                    $feeAssignData = $feeAssignRepository->fetch($feeAssign_id);

                                    $feeAssignData->total_amount = $totalAmount;
                                    $storeFeeAssign = $feeAssignRepository->update($feeAssignData);
                                }

                                if($feeAssign_id){

                                    // Assign fee
                                    $action_type = 'ASSIGNED';

                                    $headingFeeResponse = $feeInstallmentRepository->fetchHeadingDetail($getFeeMasterData->id);
                                    // dd($headingFeeResponse);
                                    foreach($headingFeeResponse as $feeResponse){

                                        $assignedFeeData = array(
                                            'id_fee_assign' => $feeAssign_id,
                                            'id_fee_heading' => $feeResponse->id_fee_heading,
                                            'action_type' => 'ASSIGNED',
                                            'installment_no' => $feeResponse->installment_no,
                                            'amount' => $feeResponse->amount,
                                            'due_date' => $feeResponse->due_date,
                                            'created_by' => Session::get('userId'),
                                            'created_at' => Carbon::now()
                                        );

                                        $storeFeeAssign = $feeAssignDetailRepository->store($assignedFeeData);

                                    }
                                }

                            }else{

                                $installmentData = $feeCategorySettingRepository->fetch($getFeeMasterData->id);
                                $noOfInstallment = $installmentData->no_of_installment;

                                // Fee assign
                                if(!$checkAssign){

                                    $data = array(
                                        'id_organization' => $organizationId,
                                        'id_institution' => $institutionId,
                                        'id_academic' => $academicYear,
                                        'id_standard' => $idStandard,
                                        'id_student' => $idStudent,
                                        'id_fee_category' => $idFeeCategory,
                                        'id_fee_type' => $idFeeType,
                                        'total_amount' => $totalAmount,
                                        'no_of_installment' => $noOfInstallment,
                                        'installment_type' => $getFeeMasterData->installment_type,
                                        'created_by' => Session::get('userId'),
                                        'created_at' => Carbon::now()
                                    );

                                    $storeFeeAssign = $feeAssignRepository->store($data);
                                    $feeAssign_id = $storeFeeAssign->id;

                                }else{

                                    $feeAssign_id = $checkAssign->id;

                                    $feeAssignData = $feeAssignRepository->fetch($feeAssign_id);

                                    $feeAssignData->total_amount = $totalAmount;
                                    $storeFeeAssign = $feeAssignRepository->update($feeAssignData);
                                }

                                if($feeAssign_id){

                                    // Assign fee
                                    $action_type = 'ASSIGNED';

                                    $feeCategorySetting = $feeCategorySettingRepository->fetch($getFeeMasterData->id);
                                    $installmentCount = $feeCategorySetting->no_of_installment;
                                    $collectionType = $feeCategorySetting->collection_type;

                                    $headingFeeResponse = $feeCategorySettingRepository->fetchCategoryDetail($getFeeMasterData->id);

                                    if($collectionType === "PROPORTIONATE") {
                             
                                        foreach($headingFeeResponse as $feeResponse){

                                            $headingAmount = $feeResponse->heading_amount;

                                            for($i=1;$i<=$installmentCount;$i++){

                                                $installmentDetails = $feeInstallmentRepository->search($feeResponse->id_category_setting, $i);

                                                $installmentPercentage = $installmentDetails->percentage;

                                                $installmentAmount = ($installmentPercentage/100)*$headingAmount;
                                                //dd($installmentAmount.' - '. $installmentPercentage.'-'.$headingAmount);
                                                $assignedFeeData = array(
                                                    'id_fee_assign' => $feeAssign_id,
                                                    'id_fee_heading' => $feeResponse->id_fee_heading,
                                                    'action_type' => 'ASSIGNED',
                                                    'installment_no' => $i,
                                                    'amount' => $installmentAmount,
                                                    'due_date' => $installmentDetails->due_date,
                                                    'created_by' => Session::get('userId'),
                                                    'created_at' => Carbon::now()
                                                );

                                                $storeFeeAssign = $feeAssignDetailRepository->store($assignedFeeData);
                                            }
                                        }

                                    }else{

                                        $headingDetailsArray =  array();
                                        $headingDetailsArray =  array();

                                        foreach($headingFeeResponse as $index => $feeResponse){

                                            $headingDetailsArray['heading_amount'][$index] = $feeResponse->heading_amount;$headingDetailsArray['heading_id'][$index] = $feeResponse->id_fee_heading;

                                        }
                                     
                                        for($i=1;$i<=$installmentCount;$i++){

                                            $installmentDetails = $feeInstallmentRepository->search($feeResponse->id_category_setting, $i);
                                            
                                            $installmentAmount = $installmentDetails->amount;

                                            foreach($headingDetailsArray['heading_id'] as $index => $headingId){

                                                if($installmentAmount != 0 && $headingDetailsArray['heading_amount'][$index] > 0) {

                                                    if($headingDetailsArray['heading_amount'][$index] < $installmentAmount){

                                                        $installmentHeadingAmount = $headingDetailsArray['heading_amount'][$index];
                                                        $installmentAmount = $installmentAmount - $headingDetailsArray['heading_amount'][$index];
                                                        $headingDetailsArray['heading_amount'][$index] = 0;

                                                    }else{

                                                        $installmentHeadingAmount = $installmentAmount;
                                                        $headingDetailsArray['heading_amount'][$index] =  $headingDetailsArray['heading_amount'][$index] - $installmentAmount;
                                                        $installmentAmount = 0;

                                                    }

                                                    $assignedFeeData = array(
                                                        'id_fee_assign' => $feeAssign_id,
                                                        'id_fee_heading' => $headingId,
                                                        'action_type' => 'ASSIGNED',
                                                        'installment_no' => $i,
                                                        'amount' => $installmentHeadingAmount,
                                                        'due_date' => $installmentDetails->due_date,
                                                        'created_by' => Session::get('userId'),
                                                        'created_at' => Carbon::now()
                                                    );

                                                    $storeFeeAssign = $feeAssignDetailRepository->store($assignedFeeData);
<<<<<<< HEAD
                                                    
=======
>>>>>>> main
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
<<<<<<< HEAD
            return $feeAssign_id;
=======
>>>>>>> main
        }
    }

?>