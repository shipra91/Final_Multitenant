<?php
    namespace App\Services;
    use App\Models\FeeChallanSetting;
    use App\Repositories\FeeChallanSettingRepository;
    use App\Repositories\FeeChallanSettingCategoryRepository;
    use App\Repositories\FeeCategoryRepository;
    use App\Repositories\FeeMappingRepository;
    use App\Repositories\CreateFeeChallanRepository;
    use App\Repositories\InstitutionBankDetailsRepository;
    use Carbon\Carbon;
    use Session;

    class FeeChallanSettingService{ 
        
        //GET ALL SETTINGS
        public function getAll(){
            $feeChallanSettingRepository = new FeeChallanSettingRepository();
            $feeChallanSettingCategoryRepository = new FeeChallanSettingCategoryRepository();
            $feeCategoryRepository = new FeeCategoryRepository();
            $createFeeChallanRepository =  new CreateFeeChallanRepository();
            $feeChallanData = array();
            
            $getResult = $feeChallanSettingRepository->all();
            foreach($getResult as $index => $data){

                $feeCategory = $feeChallanSettingCategoryRepository->all($data->id);
                $deleteStatus = "show";
                $feeChallanSettingCategory = '';

                foreach($feeCategory as $category){

                    $categoryData = $feeCategoryRepository->fetch($category->id_fee_category);
                    if($categoryData){
                        $feeChallanSettingCategory .= $categoryData->name.', ';
                    }                    
                }
                
                $feeChallanSettingCategory = substr($feeChallanSettingCategory, 0, -2);

                $feeChallanDetails = $createFeeChallanRepository->getChallanForChallanSetting($data->id);
                if(count($feeChallanDetails) > 0){
                    $deleteStatus = "hide";
                }
                $feeChallanData[$index]['id'] = $data->id;
                $feeChallanData[$index]['template'] = 'Template 1';
                $feeChallanData[$index]['fee_category'] = $feeChallanSettingCategory;
                $feeChallanData[$index]['display_type'] = $data->display_type;
                $feeChallanData[$index]['challan_prefix'] = $data->challan_prefix;
                $feeChallanData[$index]['challan_no_sequence'] = $data->challan_no_sequence;
                $feeChallanData[$index]['no_of_copy'] = $data->no_of_copy;
                $feeChallanData[$index]['copy_name'] = $data->copy_name;
                $feeChallanData[$index]['delete_status'] = $deleteStatus;
                               
            }
            return $feeChallanData;

        }

        // ADD FEE RECEIPT SETTING
        public function add($challanSettingData){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            $count = 0;

            $feeChallanSettingRepository = new FeeChallanSettingRepository();
            $feeChallanSettingCategoryRepository = new FeeChallanSettingCategoryRepository();

            //INSERT FEE RECEIPT SETTING
            $display_name = implode(",", $challanSettingData->display_name);

            $data = array(
                'id_institute' => $institutionId,
                'id_academic' => $academicId,
                'id_template' => $challanSettingData->template,
                'display_type' => $challanSettingData->display_type,
                'challan_prefix' => $challanSettingData->challan_prefix,
                'challan_no_sequence' => $challanSettingData->challan_sequence,
                'no_of_copy' => $challanSettingData->no_of_copy,
                'id_institution_bank_detail' => $challanSettingData->bank_detail_id,
                'copy_name' => $display_name,
                'created_by' => Session::get('userId'),
                'created_at' => Carbon::now()
            );
            $storeResult = $feeChallanSettingRepository->store($data);

            if($storeResult){

                foreach($challanSettingData->fee_category as $index => $feeCategory){
                
                    $dataSetting = array(
                        'id_fee_challan_settings' => $storeResult->id,
                        'id_fee_category' => $feeCategory,
                        'created_by' => Session::get('userId'),
                        'created_at' => Carbon::now()
                    );

                    $storeDetailResult = $feeChallanSettingCategoryRepository->store($dataSetting);
                }

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

        //DELETE RECEIPT SETTING
        public function delete($id){
            $feeChallanSettingRepository = new FeeChallanSettingRepository();
            $feeChallanSettingCategoryRepository = new FeeChallanSettingCategoryRepository();

            $feeSetting = $feeChallanSettingRepository->delete($id);

            if($feeSetting){
                
                $feeSettingCategory = $feeChallanSettingCategoryRepository->delete($id);

                $signal = 'success';
                $msg = 'Data deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
        
        public function getChallanFeeCategories(){
            $feeMappingRepository = new FeeMappingRepository();
            $feeChallanSettingCategoryRepository = new FeeChallanSettingCategoryRepository();
            $existingFeeCategory = array();

            $allChallanSettingCategories = $feeChallanSettingCategoryRepository->allChallanSettingCategory();
            
            foreach($allChallanSettingCategories as $feeCategory){
                array_push($existingFeeCategory, $feeCategory->id_fee_category);
            }
            
            $feeCategories = $feeMappingRepository->getReceiptSettingCategory($existingFeeCategory);
            return $feeCategories;
        }

        public function find($id){
           
            $feeChallanSettingCategoryRepository = new FeeChallanSettingCategoryRepository();
            $feeCategoryRepository = new FeeCategoryRepository();
            $feeChallanSettingRepository = new FeeChallanSettingRepository();
            $institutionBankDetailsRepository = new InstitutionBankDetailsRepository();

            $feeChallanSettingCategory = '';
            $challanSettingData = $feeChallanSettingRepository->find($id);
            $feeCategory = $feeChallanSettingCategoryRepository->all($challanSettingData->id);
            $bankDetails = $institutionBankDetailsRepository->fetch($challanSettingData->id_institution_bank_detail);
            foreach($feeCategory as $category){

                $categoryData = $feeCategoryRepository->fetch($category->id_fee_category);
                if($categoryData){
                    $feeChallanSettingCategory .= $categoryData->name.', ';
                }                    
            }
            $feeChallanSettingCategory = substr($feeChallanSettingCategory, 0, -2);

            $challanSettingData['feeChallanSettingCategory'] = $feeChallanSettingCategory;
            $challanSettingData['bank_name'] = $bankDetails->bank_name;
            $challanSettingData['branch_name'] = $bankDetails->branch_name;
            $challanSettingData['account_number'] = $bankDetails->account_number;
            $challanSettingData['ifsc_code'] = $bankDetails->ifsc_code;
            return $challanSettingData;
        }
    }
?>