<?php
    namespace App\Services;
    use App\Repositories\CreateFeeChallanRepository;
    use App\Repositories\FeeChallanDetailRepository;
    use App\Repositories\StudentMappingRepository;
    use App\Repositories\InstitutionRepository;
    use App\Repositories\FeeMappingRepository;
    use App\Repositories\FeeCategoryRepository;
    use App\Repositories\AcademicYearMappingRepository;
    use App\Repositories\FeeChallanSettingRepository;
    use App\Services\InstitutionStandardService;
    use App\Services\CurrencyService;
    use Carbon\Carbon;
    use Session;

    class FeeChallanService {

        public function getChallanData($idFeeChallan) {

            $createFeeChallanRepository = new CreateFeeChallanRepository();
            $feeChallanDetailRepository = new FeeChallanDetailRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $institutionRepository = new InstitutionRepository();
            $feeMappingRepository = new FeeMappingRepository();
            $feeCategoryRepository = new FeeCategoryRepository();
            $institutionStandardService = new InstitutionStandardService();
            $currencyService = new CurrencyService();
            $academicYearMappingRepository = new AcademicYearMappingRepository();
            $feeChallanSettingRepository = new FeeChallanSettingRepository();

            $feeChallanData = array();
            
            $feeChallan = $createFeeChallanRepository->search($idFeeChallan);
            $feeChallanSetting = $feeChallanSettingRepository->find($feeChallan->id_challan_setting);
            $institute = $institutionRepository->fetch($feeChallan->id_institute);
            $academicYearDetails = $academicYearMappingRepository->fetch($feeChallan->id_academic_year);

            $feeChallanData['total_challan_amount'] = $feeChallan->amount_received +  $feeChallan->gst;
            $feeChallan['academic_year'] = $academicYearDetails->name;
            $feeChallan['transaction_date'] = Carbon::createFromFormat('Y-m-d', $feeChallan->transaction_date)->format('d-m-Y');
            $feeChallan['amount_in_words'] = $currencyService->getIndianCurrency($feeChallanData['total_challan_amount']);

            
            $idStudent = $feeChallan->id_student;
            $studentDetails = $studentMappingRepository->fetchStudent($idStudent);
            $studentDetails['standard'] = $institutionStandardService->fetchStandardByUsingId($studentDetails->id_standard);
            $challanDetails = $feeChallanDetailRepository->getChallan($idFeeChallan);

            $feeChallanData['institute'] = $institute;
            $feeChallanData['student'] = $studentDetails;
            $feeChallanData['challan_data'] = $feeChallan;
            $feeChallanData['feeChallanSetting'] = $feeChallanSetting;
            $feeChallanData['copy_name'] = ["BANK COPY", "OFFICE COPY", "STUDENT COPY"];
            
            if($feeChallanSetting->display_type === "HEADWISE"){
                foreach($challanDetails as $index => $challan) {
                    $amountPerHeading = 0;
                    $feeCategoryDetails = $feeCategoryRepository->fetch($challan->id_fee_category);
                    $feeHeadingDetails = $feeMappingRepository->fetch($challan->id_fee_mapping_heading);

                    $amountPerHeading =  $challan->fee_amount +  $challan->gst_received;
                    $displayName = $feeHeadingDetails->display_name.' '.$challan->installment_no;
                
                    $feeChallanData['challan_details'][$index]['fee_category'] =  $feeCategoryDetails->name;
                    $feeChallanData['challan_details'][$index]['fee_heading'] =  $displayName;
                    $feeChallanData['challan_details'][$index]['heading_amount'] =  $amountPerHeading;
                }
            }else{

                $feeCategoryDetail = $feeChallanDetailRepository->getChallanCategories($idFeeChallan);
                
                foreach($feeCategoryDetail as $index => $category) {
                    
                    $categoryData = $feeCategoryRepository->fetch($category->id_fee_category);
                    
                    $categoryCollectedTotal = $feeChallanDetailRepository->totalChallanAmountCategoryWise($idFeeChallan, $category->id_fee_category);
                    // dd($categoryCollectedTotal);
                    $feeChallanData['challan_details'][$index]['fee_heading'] =  $categoryData->name;
                    $feeChallanData['challan_details'][$index]['heading_amount'] =  $categoryCollectedTotal->paid_amount;
                }
            }

            return $feeChallanData;
        }
    }

?>