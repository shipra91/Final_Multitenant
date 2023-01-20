<?php
    namespace App\Services;

    use App\Models\FeeCollection;
    use App\Repositories\FeeCollectionRepository;
    use App\Repositories\FeeCollectionDetailRepository;
    use App\Repositories\StudentMappingRepository;
    use App\Repositories\AcademicYearMappingRepository;
    use App\Repositories\AcademicYearRepository;
    use App\Repositories\FeeAssignDetailRepository;
    use App\Repositories\FeeAssignRepository;
    use App\Repositories\FeeReceiptSettingRepository;
    use App\Repositories\FeeMappingRepository;
    use App\Repositories\PaymentGatewaySettingsRepository;
    use App\Repositories\FeeChallanSettingRepository;
    use App\Services\CreateFeeChallanService;
    use App\Services\FineSettingService;
    use Carbon\Carbon;
    use Session;

    class FeeCollectionService{

        public function studentFeeDetail($request){
            
            $studentMappingRepository = new StudentMappingRepository();
            $academicYearMappingRepository = new AcademicYearMappingRepository();
            $academicYearRepository = new AcademicYearRepository();
            $feeAssignDetailRepository = new FeeAssignDetailRepository();
            $feeAssignRepository = new FeeAssignRepository();
            $feeCollectionRepository = new FeeCollectionRepository();
            $feeCollectionDetailRepository = new FeeCollectionDetailRepository();
            $paymentGatewaySettingsRepository = new PaymentGatewaySettingsRepository();
            $fineSettingService = new FineSettingService();
            $institutionStandardService = new InstitutionStandardService();
            $feeChallanSettingRepository =  new FeeChallanSettingRepository();
            $feeReceiptSettingRepository =  new FeeReceiptSettingRepository();

            $paymentGatewayDetails = $paymentGatewaySettingsRepository->all();
            $studentFeeDetail = array();

            $idStudent = $request['student'];
            $standardName = '';
            $studentDetails = $studentMappingRepository->getStuentsAcademicYear($idStudent);
            $student = $studentMappingRepository->fetchStudent($idStudent);
            if($student){
                $standardName = $institutionStandardService->fetchStandardByUsingId($student->id_standard);
            }

            $studentData = $student;
            $studentData['standard_name'] = $standardName;
            

            $studentFeeDetail[0]['payment_gateway'] = $paymentGatewayDetails;
            $studentFeeDetail[0]['student_data'] = $studentData;
           
            if($studentDetails){
                foreach($studentDetails as $index => $detail){     

                    $pendingPaymentHistory = array();
                    $grossTotalAssignedFee = 0;
                    $getFeeBalance = 0;
                  
                    $studentFeeDetail[$index]['academic_year'] = $detail->name;
                    $studentFeeDetail[$index]['academic_year_id'] = $detail->id_academic_year;

                    $getTotalAssigned = $feeAssignDetailRepository->getAcademicTotalAssignedAmount($idStudent, $detail->id_academic_year);
                    if($getTotalAssigned->amount != ""){
                        $studentFeeDetail[$index]['assignedAmount'] = $getTotalAssigned->amount;
                    }else{
                        $studentFeeDetail[$index]['assignedAmount'] = 0;
                    }

                    $getTotalAdditional = $feeAssignDetailRepository->getAcademicTotalAdditionalAmount($idStudent, $detail->id_academic_year);
                    if($getTotalAdditional->amount != ""){
                        $studentFeeDetail[$index]['additionalAmount'] = $getTotalAdditional->amount;
                    }else{
                        $studentFeeDetail[$index]['additionalAmount'] = 0;
                    }

                    $getTotalConcession = $feeAssignDetailRepository->getAcademicTotalConcessionAmount($idStudent, $detail->id_academic_year);
                  
                    if($getTotalConcession->amount != ''){
                        $studentFeeDetail[$index]['concessionAmount'] = $getTotalConcession->amount;
                    }else{
                        $studentFeeDetail[$index]['concessionAmount'] = 0;
                    }

                    
                    //TOTAL PAID
                    $getTotalFeePaid = $feeCollectionRepository->totalPaid($idStudent, $detail->id_academic_year);

                    if($getTotalFeePaid->amount != ''){
                        $studentFeeDetail[$index]['totalPaidAmount'] = $getTotalFeePaid->amount;
                    }else{
                        $studentFeeDetail[$index]['totalPaidAmount'] = 0;
                    }

                    //PAYMENT HISTORY
                    $paymentHistory = $feeCollectionDetailRepository->getPaymentDetails($idStudent, $detail->id_academic_year);
                    // dd($paymentHistory);

                    
                    $createChallanHideCount = 0;
                    $collectFeeHideCount = 0;
                    //PENDING HISTORY
                    $feeCategories = $feeAssignRepository->fetchStudentFeeCategory($idStudent, $detail->id_academic_year);
                    foreach($feeCategories as $key => $feeCategory){

                        $feeCategoryChallanSetting = $feeChallanSettingRepository->fetch($feeCategory->id, $detail->id_academic_year);

                        if(!$feeCategoryChallanSetting) {
                            $createChallanHideCount++;
                        }

                        $feeCategoryReceiptSetting = $feeReceiptSettingRepository->fetch($feeCategory->id, $detail->id_academic_year);

                        if(!$feeCategoryReceiptSetting) {
                            $collectFeeHideCount++;
                        }

                        $pendingPaymentHistory[$key]['id_feeCategory'] = $feeCategory->id;
                        $pendingPaymentHistory[$key]['feeCategory'] = $feeCategory->name;
                        $feeCategoryDetails = array();

                        $getAssignedFee = $feeAssignDetailRepository->all($idStudent, $feeCategory->id, $detail->id_academic_year);

                      
                        foreach($getAssignedFee as $in => $assignedFee){ 
                            
                            $totalInstallmentPaidAmount = 0;
                            $intallmentAmount = 0;
                            $outstandingIntallmentAmount = 0;
                            
                            //GET ADDITIONAL AMOUNT
                            $getAdditionalAmount = $feeAssignDetailRepository->fetchAddition($assignedFee->id_fee_heading, $idStudent);
                            
                            if($getAdditionalAmount->amount != ''){
                                $additionAmount = $getAdditionalAmount->amount;
                            }else{
                                $additionAmount = 0;
                            }

                            //GET CONCESSION AMOUNT
                            $getConcessionAmount = $feeAssignDetailRepository->fetchApprovedConcession($assignedFee->id_fee_heading, $idStudent);

                            if($getConcessionAmount->amount != ''){
                                $concessionAmount = $getConcessionAmount->amount;
                            }else{
                                $concessionAmount = 0;
                            }

                            $intallmentAmount = $assignedFee->amount + $additionAmount;

                            //CHECK IF INSTALLMENT IS ALREADY PAID
                            $checkCollectionAgainstHeading = $feeCollectionDetailRepository->getHeadingWiseInstallmentPaymentDetails($idStudent, $assignedFee->id_fee_heading, $assignedFee->installment_no, $detail->id_academic_year);
                            
                            if($checkCollectionAgainstHeading) {
                                foreach($checkCollectionAgainstHeading as $paidInstallmentAmount){
                                    $totalInstallmentPaidAmount = $totalInstallmentPaidAmount + $paidInstallmentAmount['fee_amount'] + $paidInstallmentAmount['gst_received'];
                                }                                
                            }
                            $totalInstallmentFinePaid = 0;
                            $fineAmount = $fineSettingService->getFineAmount($assignedFee->due_date,$totalInstallmentFinePaid);

                            $outstandingIntallmentAmount = $intallmentAmount - $concessionAmount - $totalInstallmentPaidAmount;
                            
                            $feeCategoryDetails[$in]['id_fee_heading'] = $assignedFee->id_fee_heading;
                            $feeCategoryDetails[$in]['fee_heading'] = $assignedFee->display_name;
                            $feeCategoryDetails[$in]['action_type'] = $assignedFee->action_type;
                            $feeCategoryDetails[$in]['installment_no'] = $assignedFee->installment_no;
                            $feeCategoryDetails[$in]['baseAmount'] = $assignedFee->amount;
                            $feeCategoryDetails[$in]['intallmentAmount'] = $intallmentAmount;
                            $feeCategoryDetails[$in]['totalPayable'] = $outstandingIntallmentAmount;
                            $feeCategoryDetails[$in]['additionAmount'] = $additionAmount;
                            $feeCategoryDetails[$in]['concessionAmount'] = $concessionAmount;
                            $feeCategoryDetails[$in]['paidIntallmentAmount'] = $totalInstallmentPaidAmount;
                            $feeCategoryDetails[$in]['outstandingIntallmentAmount'] = $outstandingIntallmentAmount;
                            $feeCategoryDetails[$in]['due_date'] = $assignedFee->due_date;
                            $feeCategoryDetails[$in]['remark'] = $assignedFee->remark;
                            $feeCategoryDetails[$in]['fine_amount'] = $fineAmount;
                        }

                        $pendingPaymentHistory[$key]['feeCategoryDetail'] = $feeCategoryDetails;
                    }
                    
                    $grossTotalAssignedFee = $studentFeeDetail[$index]['assignedAmount'] + $studentFeeDetail[$index]['additionalAmount'];
                    $getFeeBalance = $grossTotalAssignedFee - $studentFeeDetail[$index]['totalPaidAmount'] - $studentFeeDetail[$index]['concessionAmount'];

                    $studentFeeDetail[$index]['totalPayableFee'] = $grossTotalAssignedFee;
                    $studentFeeDetail[$index]['totalFeeBalance'] = $getFeeBalance;
                    $studentFeeDetail[$index]['totalPaidFee'] = $studentFeeDetail[$index]['totalPaidAmount'];
                    $studentFeeDetail[$index]['paidHistory'] = $paymentHistory;
                    $studentFeeDetail[$index]['pendingHistory'] = $pendingPaymentHistory;
                    $studentFeeDetail[$index]['createChallanHideCount'] = $createChallanHideCount;
                    $studentFeeDetail[$index]['collectFeeHideCount'] = $collectFeeHideCount;
                    
                }
            }
            //dd($studentFeeDetail);
            return $studentFeeDetail;
        }

        // STORE FEE COLLECTION

        public function add($request){
        
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $request->academicId;
            
            $currencyDenominationService = new CurrencyDenominationService();
            $createFeeChallanService = new CreateFeeChallanService();
            $feeAssignRepository = new FeeAssignRepository();
            $feeReceiptSettingRepository = new FeeReceiptSettingRepository();
            $feeCollectionRepository = new FeeCollectionRepository();
            $feeCollectionDetailRepository = new FeeCollectionDetailRepository();
            $feeMappingRepository = new FeeMappingRepository();

            //COLLECT FEE
            if($request->collection_type == "COLLECT_FEE"){

                $collectionCount = 0;
                $grossFineAmount = 0;
                $feeReceiptId = array();
                $feeAssignedCategory = $request->feeAssignedCategory;

                $allReceiptSettings = $feeReceiptSettingRepository->academicAllReceiptSetting($academicId);
                // dd($allReceiptSettings);
                foreach($allReceiptSettings as $index => $receiptSetting){

                    $totalCategoryPayable = 0 ;
                    $totalSGST = 0 ;
                    $totalCGST = 0 ;
                    $totalGST = 0 ;

                    foreach($receiptSetting['setting_categories'] as $key => $idFeeCategory){    
                        if(in_array($idFeeCategory, $feeAssignedCategory)){                      
                            foreach($request->id_fee_heading[$idFeeCategory] as $headIndex => $idFeeHeading){

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

                    if($totalCategoryPayable > 0){

                        //CHECKING FEE RECEIPT NUMBER
                        $getMaxReceiptNo = $feeCollectionRepository->getMaxReceiptNo($receiptSetting['id_receipt_setting'], $academicId);
                        if($getMaxReceiptNo == ""){
                            $receiptNo = $receiptSetting['receipt_no_sequence'];
                        }else{
                            $receiptNo = $getMaxReceiptNo + 1;
                        }
                        
                        //INSERT RECORD TO TBL_FEE_COLLECTION TABLE 
                        $paymentMethod = $request->payment_method;
                        if($request->payment_method == "CASH"){

                            $transaction_no = 0;
                            $bank_name = '';
                            $branch_name = '';
                            $transaction_date = '';
                            $orderId_online = '';

                        }else if($request->payment_method == "CHEQUE"){

                            $transaction_no = $request->cheque_number;
                            $bank_name = $request->cheque_bank;
                            $branch_name = $request->cheque_branch;
                            $transaction_date = Carbon::createFromFormat('d/m/Y', $request->cheque_date)->format('Y-m-d');
                            $orderId_online = '';

                        }else if($request->payment_method == "DD"){

                            $transaction_no = $request->dd_number;
                            $bank_name = $request->dd_bank;
                            $branch_name = $request->dd_branch;
                            $transaction_date = Carbon::createFromFormat('d/m/Y', $request->dd_date)->format('Y-m-d');
                            $orderId_online = '';

                        }else if($request->payment_method == "CHALLAN"){

                            $transaction_no = $request->challan_number;
                            $bank_name = $request->challan_bank;
                            $branch_name = $request->challan_branch;
                            $transaction_date = Carbon::createFromFormat('d/m/Y', $request->challan_date)->format('Y-m-d');
                            $orderId_online = '';

                        }else if($request->payment_method == "ONLINE"){
                            $paymentMethod = $request->payment_gateway;
                            $transaction_no = $request->transaction_id;
                            $bank_name = '';
                            $branch_name = '';
                            $transaction_date = Carbon::createFromFormat('d/m/Y', $request->net_date)->format('Y-m-d');
                            $orderId_online = '';

                        }
                        if($request->grossFine){
                            $grossFineAmount = $request->grossFine;
                        }
                        $data = array(
                            'id_institute' => $institutionId,
                            'id_academic_year' => $academicId,
                            'id_student' => $request->studentId,
                            'collected_by' => Session::get('userId'),
                            'paid_date' => Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d'),
                            'payment_mode' => $paymentMethod,
                            'receipt_prefix' => $receiptSetting['receipt_prefix'],
                            'receipt_no' => $receiptNo,
                            'id_receipt_setting' => $receiptSetting['id_receipt_setting'],
                            'transaction_no' => $transaction_no,
                            'bank_name' => $bank_name,
                            'branch_name' => $branch_name,
                            'transaction_date' => $transaction_date,
                            'amount_received' => $totalCategoryPayable,
                            'sgst' => $totalSGST,
                            'cgst' => $totalCGST,
                            'gst' => $totalGST,
                            'orderId_online' => $orderId_online,
                            'cancelled' => 'NO',
                            'remarks' => $request->remarks,
                            'total_fine_amount' => $grossFineAmount,
                            'created_by' => Session::get('userId')
                        );
                    
                        //INSERT THE FEE COLLECTION RECORD SETTINGWISE
                        $storeFeeCollection = $feeCollectionRepository->store($data);
                    
                        if($storeFeeCollection){
                            $feeReceiptId[] = $storeFeeCollection->id;
                            $collectionCount++;

                            foreach($receiptSetting['setting_categories'] as $key => $idFeeCategory){    
                                if(in_array($idFeeCategory, $feeAssignedCategory)){                      
                                    foreach($request->id_fee_heading[$idFeeCategory] as $headIndex => $idFeeHeading){
                                        
                                        $totalHeadingBaseAmount = 0;
                                        $headingSGSTBaseAmount = 0;
                                        $headingCGSTBaseAmount = 0;
                                        $totalHeadingBaseAmount = 0;
                                        $totalHeadingGST = 0; 
                                        $fineAmount = $headingCGST = $headingSGST = 0;

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
                                            $installmentNumber = $request->installment_no[$idFeeCategory][$headIndex];
                                            if($totalHeadingBaseAmount > 0) {
                                                $fine = 'fine_amount_'.$idFeeHeading.'_'.$installmentNumber;
                                                $fineAmount = $request->$fine;
                                            }
                                        
                                            //COLLECTION DETAIL INSERTION
                                            if($totalHeadingBaseAmount > 0) {
                                                $collectDetail = array(
                                                    'id_fee_collection' => $storeFeeCollection->id,
                                                    'id_fee_category' => $idFeeCategory,
                                                    'id_fee_mapping_heading' => $idFeeHeading,
                                                    'installment_no' => $request->installment_no[$idFeeCategory][$headIndex],
                                                    'fee_amount' => $totalHeadingBaseAmount,
                                                    'sgst_received' => $headingSGST,
                                                    'cgst_received' => $headingCGST,
                                                    'gst_received' => $totalHeadingGST,
                                                    'fine_amount' => $fineAmount,
                                                    'created_by' => Session::get('userId'),
                                                );
                                                // dd($collectDetail);
                                                $storeFeeCollectionDetail = $feeCollectionDetailRepository->store($collectDetail);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                   
                    } 
                }
                $feeReceiptId = implode(',' ,$feeReceiptId);
                if($collectionCount){

                    $signal = 'success';
                    $msg = 'Fee paid successfully!';
                    $location = 'fee-receipt-download/'.$feeReceiptId;

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

               
            } //END COLLECT FEE - START CREATE CHALLAN
            else if($request->collection_type == "CREATE_CHALLAN"){
                $output = $createFeeChallanService->add($request);
            }
            //END CREATE CHALLAN
            return $output;

        }

        public function getStudentFeeDetails($request) {
            
            $feeCollectionDetailRepository = new FeeCollectionDetailRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $institutionStandardService = new InstitutionStandardService();

            $paidHistoryArray['studentDetails'] = array();
            $paidHistoryArray['collectionDetails'] = array();
            $idStudent = $request['student'];
            
            $studentDetails = $studentMappingRepository->fetchStudent($idStudent);
            if($studentDetails){
                $standard = $institutionStandardService->fetchStandardByUsingId($studentDetails->id_standard); 
                $paymentHistory = $feeCollectionDetailRepository->getFeePaymentDetails($idStudent);
                
                $paidHistoryArray['studentDetails']['name'] = $studentDetails->name;
                $paidHistoryArray['studentDetails']['class'] = $standard;
                $paidHistoryArray['studentDetails']['UID'] = $studentDetails->egenius_uid;
              
                foreach($paymentHistory as $index => $history) {
                    if($history->paid_amount !='') {
                        if($history->cancelled_date) {
                            $cancelledDate = Carbon::createFromFormat('Y-m-d', $history->cancelled_date)->format('d-m-Y'); 
                        }else{
                            $cancelledDate = '';
                        }
                        $paidHistoryArray['collectionDetails'][$index]['idFeeCollection'] = $history->id;
                        $paidHistoryArray['collectionDetails'][$index]['paid_date'] = Carbon::createFromFormat('Y-m-d', $history->paid_date)->format('d-m-Y');  
                        $paidHistoryArray['collectionDetails'][$index]['payment_mode'] = $history->payment_mode;
                        $paidHistoryArray['collectionDetails'][$index]['paid_amount'] = $history->paid_amount;
                        $paidHistoryArray['collectionDetails'][$index]['receipt_prefix'] = $history->receipt_prefix;
                        $paidHistoryArray['collectionDetails'][$index]['receipt_no'] = $history->receipt_no;
                        $paidHistoryArray['collectionDetails'][$index]['collected_by'] = $history->collected_by; 
                        $paidHistoryArray['collectionDetails'][$index]['cancelled_status'] = $history->cancelled;
                        $paidHistoryArray['collectionDetails'][$index]['cancelled_date'] = $cancelledDate;
                        $paidHistoryArray['collectionDetails'][$index]['cancellation_remarks'] = $history->cancellation_remarks;
                    }
                }
            }
            return $paidHistoryArray;
        }
        
        public function update($data, $id) {
            $feeCollectionRepository = new FeeCollectionRepository();
            $feeCollectionDetails = $feeCollectionRepository->fetch($id);
            $feeCollectionDetails->cancelled = 'YES';$feeCollectionDetails->cancelled_date = date('Y-m-d');
            $feeCollectionDetails->cancellation_remarks = $data->cancel_remarks;
            $feeCollectionDetails->cancelled_by = Session::get('userId');
            $feeCollectionDetails->modified_by = Session::get('userId');
            $feeCollectionDetails->updated_at = Carbon::now();
            $updateData = $feeCollectionRepository->update($feeCollectionDetails);

            if($updateData){
                $signal = 'success';
                $msg = 'Data updated successfully!';

            }else{
                $signal = 'failure';
                $msg = 'Error updating data!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
?>