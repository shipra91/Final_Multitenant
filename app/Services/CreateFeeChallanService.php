<?php
    namespace App\Services;

    use App\Models\CreateFeeChallan;
    use App\Repositories\FeeCollectionRepository;
    use App\Repositories\FeeCollectionDetailRepository;
    use App\Repositories\StudentMappingRepository;
    use App\Repositories\AcademicYearMappingRepository;
    use App\Repositories\AcademicYearRepository;
    use App\Repositories\FeeAssignDetailRepository;
    use App\Repositories\FeeAssignRepository;
    use App\Repositories\FeeChallanSettingRepository;
    use App\Repositories\FeeMappingRepository;
    use App\Repositories\CreateFeeChallanRepository;
    use App\Repositories\FeeChallanDetailRepository;
    use App\Repositories\FeeReceiptSettingRepository;
    use App\Repositories\InstitutionBankDetailsRepository;
    use Carbon\Carbon;
    use Session;

    class CreateFeeChallanService {

        public function add($request) {

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $request->academicId;

            $feeAssignRepository = new FeeAssignRepository();
            $feeChallanSettingRepository = new FeeChallanSettingRepository();
            $feeMappingRepository = new FeeMappingRepository();
            $createFeeChallanRepository = new CreateFeeChallanRepository();
            $feeChallanDetailRepository = new FeeChallanDetailRepository();
            $institutionBankDetailsRepository = new InstitutionBankDetailsRepository();

            //CREATE CHALLAN

            $challanCount = 0;
            $feeChallanId = array();
            $feeAssignedCategory = $request->feeAssignedCategory;
            $allChallanSettings = $feeChallanSettingRepository->academicAllChallanSetting($academicId);
            
            foreach($allChallanSettings as $index => $challanSetting) {
              
                $totalCategoryPayable = 0 ;
                $totalSGST = 0 ;
                $totalCGST = 0 ;
                $totalGST = 0 ;

                foreach($challanSetting['setting_categories'] as $key => $idFeeCategory) {  
                    if(in_array($idFeeCategory, $feeAssignedCategory)){                     
                        foreach($request->id_fee_heading[$idFeeCategory] as $headIndex => $idFeeHeading) {
                            if($request->paying_amount[$idFeeCategory][$headIndex] != '') {

                                $totalCategoryPayable = $totalCategoryPayable + $request->paying_amount[$idFeeCategory][$headIndex];

                                $sgstBaseAmount = 0 ;
                                $cgstBaseAmount = 0 ;
                                $sgst = 0 ;
                                $cgst = 0 ;

                                //CALCULATION OF SGST
                                $feeMappingData = $feeMappingRepository->getAcademicHeadingMapping($idFeeHeading, $academicId);

                                if($feeMappingData->sgst != 0){
                                    $sgstBaseAmount = $request->paying_amount[$idFeeCategory][$headIndex]/(1 + $feeMappingData->sgst/100);

                                    $sgst = $request->paying_amount[$idFeeCategory][$headIndex] - $sgstBaseAmount;

                                    $totalSGST = $totalSGST + $sgst;

                                }

                                //CALCULATION OF CGST
                                if($feeMappingData->cgst != 0){
                                    $cgstBaseAmount = $request->paying_amount[$idFeeCategory][$headIndex]/(1 + $feeMappingData->cgst/100);

                                    $cgst = $request->paying_amount[$idFeeCategory][$headIndex] - $cgstBaseAmount;

                                    $totalCGST = $totalCGST + $cgst;

                                }
                            }
                        }
                    }
                }

                $totalGST = $totalSGST + $totalCGST;
                $totalCategoryPayable = $totalCategoryPayable - $totalGST;

                //CHECKING FEE CHALLAN NUMBER
                $getMaxChallanNo = $createFeeChallanRepository->getMaxChallanNo($academicId);
                $challanNo = $getMaxChallanNo + 1;

                $paymentMethod = "CHALLAN";
                $institutionBankDetails = $institutionBankDetailsRepository->fetch($challanSetting['id_institution_bank_detail']);
              
                $bankName = $institutionBankDetails->bank_name;
                $branchName = $institutionBankDetails->branch_name;
                $accountNumber = $institutionBankDetails->account_number;
                $ifscCode = $institutionBankDetails->ifsc_code;

                $transaction_date = Carbon::createFromFormat('d/m/Y', $request->challan_date)->format('Y-m-d');

                if($totalCategoryPayable > 0){

                    $data = array(
                        'id_institute' => $institutionId,
                        'id_academic_year' => $academicId,
                        'id_student' => $request->studentId,
                        'id_challan_setting' => $challanSetting['id_challan_setting'],
                        'challan_created_by' => Session::get('userId'),
                        'payment_mode' => $paymentMethod,
                        'challan_no' => $challanNo,
                        'bank_name' => $bankName,
                        'branch_name' => $branchName,
                        'account_number' => $accountNumber,
                        'ifsc_code' => $ifscCode,
                        'transaction_date' => $transaction_date,
                        'amount_received' => $totalCategoryPayable,
                        'sgst' => $totalSGST,
                        'cgst' => $totalCGST,
                        'gst' => $totalGST,
                        'created_by' => Session::get('userId'),
                        'created_at' => Carbon::now()
                    );

                    //INSERT THE CHALLAN DETAILS
                    $storeFeeChallanDetails = $createFeeChallanRepository->store($data);

                    if($storeFeeChallanDetails) {

                        $feeChallanId[] = $storeFeeChallanDetails->id;
                        $challanCount++;
                        
                        foreach($challanSetting['setting_categories'] as $key => $idFeeCategory) { 
                            if(in_array($idFeeCategory, $feeAssignedCategory)){                       
                                foreach($request->id_fee_heading[$idFeeCategory] as $headIndex => $idFeeHeading) {                          
                                    $totalHeadingBaseAmount = 0;
                                    $headingSGSTBaseAmount = 0;
                                    $headingCGSTBaseAmount = 0;
                                    $totalHeadingBaseAmount = 0;
                                    $totalHeadingGST = 0;
                                    $headingSGST = 0;
                                    $headingCGST = 0;

                                    if($request->paying_amount[$idFeeCategory][$headIndex] != ''){
                                        //CALCULATION OF SGST
                                        $feeMappingData = $feeMappingRepository->getAcademicHeadingMapping($idFeeHeading, $academicId);
                                        if($feeMappingData->sgst != 0){

                                            $headingSGSTBaseAmount = $request->paying_amount[$idFeeCategory][$headIndex]/(1 + $feeMappingData->sgst/100);

                                            $headingSGST = $request->paying_amount[$idFeeCategory][$headIndex] - $headingSGSTBaseAmount;

                                        }

                                        //CALCULATION OF CGST
                                        if($feeMappingData->cgst != 0){

                                            $headingCGSTBaseAmount = $request->paying_amount[$idFeeCategory][$headIndex]/(1 + $feeMappingData->cgst/100);

                                            $headingCGST = $request->paying_amount[$idFeeCategory][$headIndex] - $headingCGSTBaseAmount;

                                        }

                                        $totalHeadingGST = $headingSGST + $headingCGST;
                                        $totalHeadingBaseAmount =  $request->paying_amount[$idFeeCategory][$headIndex] - $totalHeadingGST;
                                    

                                        //COLLECTION DETAIL INSERTION
                                        if($totalHeadingBaseAmount > 0) {
                                            $challanDetail = array(
                                                'id_fee_challan' => $storeFeeChallanDetails->id,
                                                'id_fee_category' => $idFeeCategory,
                                                'id_fee_mapping_heading' => $idFeeHeading,
                                                'installment_no' => $request->installment_no[$idFeeCategory][$headIndex],
                                                'fee_amount' => $totalHeadingBaseAmount,
                                                'sgst_received' => $headingSGST,
                                                'cgst_received' => $headingCGST,
                                                'gst_received' => $totalHeadingGST,
                                                'created_by' => Session::get('userId'),
                                                'created_at' => Carbon::now()
                                            );
                                            // dd($collectDetail);
                                            $storeChallanDetail = $feeChallanDetailRepository->store($challanDetail);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        
            $feeChallanId = implode(',' ,$feeChallanId);
            if($challanCount){

                $signal = 'success';
                $msg = 'Challan created successfully!';
                $location = 'fee-challan-download/'.$feeChallanId;

            }else{

                $signal = 'failure';
                $msg = 'Error inserting data!';
                $location = '';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg,
                'location'=>$location
            );
            return $output;
            //END CREATE CHALLAN
        }

        public function getChallan($idAcademic, $idStudent) {
          
            $challanDetails = array();
            $createFeeChallanRepository = new CreateFeeChallanRepository();
            $challanDetail = $createFeeChallanRepository->fetch($idAcademic, $idStudent);
            foreach($challanDetail as $key => $details)
            {
                $challanDetails[$key]['id'] = $details->id;
                $challanDetails[$key]['challan_no'] = $details->challan_no;
                $challanDetails[$key]['bank_transaction_id'] = $details->bank_transaction_id;
                $challanDetails[$key]['amount_received'] = $details->amount_received + $details->gst;
                $challanDetails[$key]['transaction_date'] = Carbon::createFromFormat('Y-m-d', $details->transaction_date)->format('d-m-Y');
                $challanDetails[$key]['status'] = $details->approved;
                $challanDetails[$key]['rejection_reason'] = $details->rejection_reason;
            }
            return $challanDetails;
        }

        public function approveChallan($approveData, $idFeeChallan) {

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $approveDate = date('Y-m-d');
            $approveStatus = 'YES';
            $approvedBy = Session::get('userId');

            $createFeeChallanRepository = new CreateFeeChallanRepository();
            $feeReceiptSettingRepository = new FeeReceiptSettingRepository();
            $feeChallanDetailRepository = new FeeChallanDetailRepository();
            $feeCollectionRepository = new FeeCollectionRepository();
            $feeCollectionDetailRepository = new FeeCollectionDetailRepository();

            $bankTransactionId = '';
            $orderIdOnline = '';
            $remarks = '';
            $feeReceiptId = array();
            $challanDetail = $createFeeChallanRepository->search($idFeeChallan);
            $academicId = $challanDetail->id_academic_year;
            $studentId = $challanDetail->id_student;
            $bankName = $challanDetail->bank_name;
            $branchName = $challanDetail->branch_name;
            $transactionDate = $challanDetail->transaction_date;
            $paymentMode = 'CHALLAN';
            $paidDate  =  Carbon::createFromFormat('d/m/Y', $approveData->challan_paid_date)->format('Y-m-d');

            if($approveData->bank_transaction_id) {
                $bankTransactionId  = $approveData->bank_transaction_id;
            }

            $challanDetail->approved = $approveStatus;
            $challanDetail->approved_by = $approvedBy;
            $challanDetail->approved_date = $approveDate;
            $challanDetail->bank_transaction_id = $bankTransactionId;
            $challanDetail->modified_by = Session::get('userId');
            $challanDetail->updated_at = Carbon::now();             
            $updateData = $createFeeChallanRepository->update($challanDetail);
           
            $collectionCount = 0;

            if($updateData){
                $allReceiptSettings = $feeReceiptSettingRepository->academicAllReceiptSetting($academicId);
                foreach($allReceiptSettings as $index => $receiptSetting){
                    $totalCategoryPayable = 0 ;
                    $totalSGST = 0 ;
                    $totalCGST = 0 ;
                    $totalGST = 0 ;
                    foreach($receiptSetting['setting_categories'] as $key => $idFeeCategory){
                        $categoryFeeHeadings = $feeChallanDetailRepository->fetch($idFeeCategory, $idFeeChallan);
                        if(count($categoryFeeHeadings) > 0){
                            foreach ($categoryFeeHeadings as $paidHeading) {
                                if(!empty($paidHeading->fee_amount)) {
                                    $totalCategoryPayable = $totalCategoryPayable + $paidHeading->fee_amount;
                                    $totalSGST = $totalSGST + $paidHeading->sgst_received;
                                    $totalCGST = $totalCGST + $paidHeading->cgst_received;
                                    $totalGST = $totalGST + $paidHeading->gst_received;
                                }
                            }
                        }
                    }

                    if($totalCategoryPayable > 0){
                        //CHECKING FEE RECEIPT NUMBER
                        $getMaxReceiptNo = $feeCollectionRepository->getMaxReceiptNo($receiptSetting['id_receipt_setting'], $academicId);
                        if($getMaxReceiptNo == ""){
                            $receiptNo = $receiptSetting['receipt_no_sequence'];
                        }else{
                            $receiptNo = $getMaxReceiptNo + 1;
                        }

                    $data = array(
                        'id_institute' => $institutionId,
                        'id_academic_year' => $academicId,
                        'id_student' => $studentId,
                        'collected_by' => Session::get('userId'),
                        'paid_date' => $paidDate,
                        'payment_mode' => $paymentMode,
                        'receipt_prefix' => $receiptSetting['receipt_prefix'],
                        'receipt_no' => $receiptNo,
                        'id_receipt_setting' => $receiptSetting['id_receipt_setting'],
                        'transaction_no' => $bankTransactionId,
                        'bank_name' => $bankName,
                        'branch_name' => $branchName,
                        'transaction_date' => $transactionDate,
                        'amount_received' => $totalCategoryPayable,
                        'sgst' => $totalSGST,
                        'cgst' => $totalCGST,
                        'gst' => $totalGST,
                        'orderId_online' => $orderIdOnline,
                        'cancelled' => 'NO',
                        'remarks' => $remarks,
                        'created_by' => Session::get('userId')
                    );

                        $storeFeeCollection = $feeCollectionRepository->store($data);
                        if($storeFeeCollection){
                            $feeReceiptId[] = $storeFeeCollection->id;
                            $collectionCount++;
                            foreach($receiptSetting['setting_categories'] as $key => $idFeeCategory){
                                $categoryFeeHeadings = $feeChallanDetailRepository->fetch($idFeeCategory, $idFeeChallan);
                                if(count($categoryFeeHeadings) > 0){
                                    foreach ($categoryFeeHeadings as $paidHeading) {
                                        if(!empty($paidHeading->fee_amount)) {

                                            $headingAmount = $paidHeading->fee_amount;
                                            $sgstReceived = $paidHeading->sgst_received;
                                            $cgstReceived = $paidHeading->cgst_received;
                                            $gstReceived = $paidHeading->gst_received;
                                            $idFeeHeading = $paidHeading->id_fee_mapping_heading;
                                            $installmentNo = $paidHeading->installment_no;

                                        //COLLECTION DETAIL INSERTION
                                    $collectDetail = array(
                                        'id_fee_collection' => $storeFeeCollection->id,
                                        'id_fee_category' => $idFeeCategory,
                                        'id_fee_mapping_heading' => $idFeeHeading,
                                        'installment_no' => $installmentNo,
                                        'fee_amount' => $headingAmount,
                                        'sgst_received' => $sgstReceived,
                                        'cgst_received' => $cgstReceived,
                                        'gst_received' => $gstReceived,
                                        'created_by' => Session::get('userId'),
                                    );
                                   
                                    $storeFeeCollectionDetail = $feeCollectionDetailRepository->store($collectDetail);
                                    
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
              
                $feeReceiptId = implode(',' ,$feeReceiptId);
                if($collectionCount>0){
                    $signal = 'success';
                    $msg = 'Challan Approved successfully!';
                    $location = 'fee-receipt-download/'.$feeReceiptId;

                }else{

                    $signal = 'failure';
                    $msg = 'Error in approve!';
                    $location = '';
                }

            }else{

                $signal = 'failure';
                $msg = 'Error in approve!';
                $location = '';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg,
                'location'=>$location
            );
            return $output;
        }


        public function rejectChallan($rejectData, $idFeeChallan) {
         
            $createFeeChallanRepository = new CreateFeeChallanRepository();

            $challanDetail = $createFeeChallanRepository->search($idFeeChallan);
            if($rejectData->rejection_reason == 'OTHER')
            {
                $rejectionReason = $rejectData->other_reject_reason;
            }
            else
            {
                $rejectionReason = $rejectData->rejection_reason;
            }
            $challanDetail->approved = 'NO';
            $challanDetail->rejection_reason = $rejectionReason;
            $challanDetail->modified_by = Session::get('userId');
            $challanDetail->updated_at = Carbon::now();             
            $updateData = $createFeeChallanRepository->update($challanDetail);

            if($updateData){
                $signal = 'success';
                $msg = 'Challan Rejected successfully!';
            }else{

                $signal = 'failure';
                $msg = 'Error in approve!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );
            return $output;
        }
    }