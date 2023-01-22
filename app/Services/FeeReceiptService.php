<?php
    namespace App\Services;
    use App\Repositories\FeeCollectionRepository;
    use App\Repositories\FeeCollectionDetailRepository;
    use App\Repositories\StudentMappingRepository;
    use App\Repositories\InstitutionRepository;
    use App\Repositories\FeeMappingRepository;
    use App\Repositories\FeeCategoryRepository;
    use App\Repositories\AcademicYearMappingRepository;
    use App\Repositories\FeeReceiptSettingRepository;
    use App\Services\InstitutionStandardService;
    use App\Services\CurrencyService;
    use App\Services\FeeAssignDetailService;
    use Carbon\Carbon;
    use Session;

    class FeeReceiptService {

        public function getReceiptData($idFeeCollection, $allSessions) {

            $feeCollectionRepository = new FeeCollectionRepository();
            $feeCollectionDetailRepository = new FeeCollectionDetailRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $institutionRepository = new InstitutionRepository();
            $feeMappingRepository = new FeeMappingRepository();
            $feeCategoryRepository = new FeeCategoryRepository();
            $institutionStandardService = new InstitutionStandardService();
            $currencyService = new CurrencyService();
            $academicYearMappingRepository = new AcademicYearMappingRepository();
            $feeAssignDetailService = new FeeAssignDetailService();
            $feeReceiptSettingRepository = new FeeReceiptSettingRepository();

            $feeReceiptData = array();
            $totalGst = 0;
            $feeReceipt = $feeCollectionRepository->search($idFeeCollection);
            
            $feeReceiptSetting = $feeReceiptSettingRepository->fetchData($feeReceipt->id_receipt_setting);
            $institute = $institutionRepository->fetch($feeReceipt->id_institute);
            // dd($institute);
            $academicYearDetails = $academicYearMappingRepository->fetch($feeReceipt->id_academic_year);
            if(!empty($feeReceipt->gst) && $feeReceipt->gst != '0' )
            {
                $totalGst = $feeReceipt->gst;
            }

            $totalBalanceAmount = $feeAssignDetailService->fetchTotalBalanceAmount($feeReceipt->id_student, $feeReceipt->id_academic_year, $allSessions);

            $feeReceiptData['total_receipt_amount'] = $feeReceipt->amount_received +  $feeReceipt->gst;
            // dd($feeReceiptData['total_receipt_amount']);
            $feeReceiptData['total_balance_amount'] = $totalBalanceAmount;
            $feeReceipt['academic_year'] = $academicYearDetails->name;
            $feeReceipt['paid_date'] = Carbon::createFromFormat('Y-m-d', $feeReceipt->paid_date)->format('d-m-Y');
            $feeReceipt['transaction_date'] = Carbon::createFromFormat('Y-m-d', $feeReceipt->transaction_date)->format('d-m-Y');
            $feeReceipt['amount_in_words'] = $currencyService->getIndianCurrency($feeReceiptData['total_receipt_amount']);
            
            $idStudent = $feeReceipt->id_student;
            $studentDetails = $studentMappingRepository->fetchStudent($idStudent, $allSessions);
            $studentDetails['standard'] = $institutionStandardService->fetchStandardByUsingId($studentDetails->id_standard);
            
            $feeReceiptData['institute'] = $institute;
            $feeReceiptData['student'] = $studentDetails;
            $feeReceiptData['receipt_data'] = $feeReceipt;
            $feeReceiptData['feeReceiptSetting'] = $feeReceiptSetting;

            if($feeReceiptSetting->display_type === "HEADWISE"){

                $receiptDetails = $feeCollectionDetailRepository->getReceipt($idFeeCollection);

                foreach($receiptDetails as $index => $receipt) {
                    $amountPerHeading = 0;
                
                    $feeHeadingDetails = $feeMappingRepository->fetch($receipt->id_fee_mapping_heading);
                    

                    $amountPerHeading = $receipt->fee_amount + $receipt->gst_received;
                    $displayName = $feeHeadingDetails->display_name.' '.$receipt->installment_no;
                
                    $feeReceiptData['receipt_details'][$index]['fee_heading'] =  $displayName;
                    $feeReceiptData['receipt_details'][$index]['heading_amount'] =  $amountPerHeading;
                }
            }else{
                $feeCategoryDetail = $feeCollectionDetailRepository->getReceiptCategories($idFeeCollection);
                
                foreach($feeCategoryDetail as $index => $category) {
                    
                    $categoryData = $feeCategoryRepository->fetch($category->id_fee_category);
                    
                    $categoryCollectedTotal = $feeCollectionDetailRepository->totalCollectedAmountCategoryWise($idFeeCollection, $category->id_student, $category->id_fee_category, $allSessions);
                    // dd($categoryCollectedTotal);
                    $feeReceiptData['receipt_details'][$index]['fee_heading'] =  $categoryData->name;
                    $feeReceiptData['receipt_details'][$index]['heading_amount'] =  $categoryCollectedTotal->paid_amount;
                }
            }          
            
            // dd($feeReceiptData);
            return $feeReceiptData;
        }
    }

?>