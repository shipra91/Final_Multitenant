<?php
    namespace App\Services;

    use App\Models\FeeReceiptSetting;
    use App\Repositories\FeeReceiptSettingRepository;
    use App\Repositories\FeeReceiptSettingCategoryRepository;
    use App\Repositories\FeeCategoryRepository;
    use App\Repositories\FeeMappingRepository;
    use App\Repositories\FeeCollectionRepository;
    use Carbon\Carbon;
    use Session;

    class FeeReceiptSettingService {

        // Get all settings
        public function getAll($allSessions){

            $feeReceiptSettingRepository = new FeeReceiptSettingRepository();
            $feeReceiptSettingCategoryRepository = new FeeReceiptSettingCategoryRepository();
            $feeCategoryRepository = new FeeCategoryRepository();
            $feeCollectionRepository = new FeeCollectionRepository();
            $feeReceiptData = array();

            $getResult = $feeReceiptSettingRepository->all($allSessions);
            // dd($getResult);
            foreach($getResult as $index => $data){

                $feeCategory = $feeReceiptSettingCategoryRepository->all($data->id);
                $deleteStatus = "show";
                $feeReceiptSettingCategory = '';

                foreach($feeCategory as $category){

                    $categoryData = $feeCategoryRepository->fetch($category->id_fee_category);

                    if($categoryData){
                        $feeReceiptSettingCategory .= $categoryData->name.', ';
                    }
                }

                $feeReceiptSettingCategory = substr($feeReceiptSettingCategory, 0, -2);
                $feeCollectionDetails = $feeCollectionRepository->getCollectionForReceiptSetting($data->id, $allSessions);

                if(count($feeCollectionDetails) > 0){
                    $deleteStatus = "hide";
                }

                $feeReceiptData[$index]['id'] = $data->id;
                $feeReceiptData[$index]['template'] = 'Template 1';
                $feeReceiptData[$index]['fee_category'] = $feeReceiptSettingCategory;
                $feeReceiptData[$index]['display_type'] = $data->display_type;
                $feeReceiptData[$index]['receipt_prefix'] = $data->receipt_prefix;
                $feeReceiptData[$index]['receipt_no_sequence'] = $data->receipt_no_sequence;
                $feeReceiptData[$index]['receipt_size'] = $data->receipt_size;
                $feeReceiptData[$index]['no_of_copy'] = $data->no_of_copy;
                $feeReceiptData[$index]['copy_name'] = $data->copy_name;
                $feeReceiptData[$index]['delete_status'] = $deleteStatus;
            }

            return $feeReceiptData;
        }

        // Add fee receipt setting
        public function add($receiptSettingData){

            $institutionId = $receiptSettingData->id_institute;
            $academicId = $receiptSettingData->id_academic;
            $count = 0;

            $feeReceiptSettingRepository = new FeeReceiptSettingRepository();
            $feeReceiptSettingCategoryRepository = new FeeReceiptSettingCategoryRepository();

            // Insert fee receipt setting
            $display_name = implode(",", $receiptSettingData->display_name);

            $data = array(
                'id_institute' => $institutionId,
                'id_academic' => $academicId,
                'id_template' => $receiptSettingData->template,
                'display_type' => $receiptSettingData->display_type,
                'receipt_prefix' => $receiptSettingData->receipt_prefix,
                'receipt_no_sequence' => $receiptSettingData->receipt_sequence,
                'receipt_size' => $receiptSettingData->receipt_size,
                'no_of_copy' => $receiptSettingData->no_of_copy,
                'copy_name' => $display_name,
                'created_by' => Session::get('userId'),
                'created_at' => Carbon::now()
            );

            $storeResult = $feeReceiptSettingRepository->store($data);

            if($storeResult){

                foreach($receiptSettingData->fee_category as $index => $feeCategory){

                    $dataSetting = array(
                        'id_fee_receipt_settings' => $storeResult->id,
                        'id_fee_category' => $feeCategory,
                        'created_by' => Session::get('userId'),
                        'created_at' => Carbon::now()
                    );

                    $storeDetailResult = $feeReceiptSettingCategoryRepository->store($dataSetting);
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

        // Delete receipt setting
        public function delete($id){

            $feeReceiptSettingRepository = new FeeReceiptSettingRepository();
            $feeReceiptSettingCategoryRepository = new FeeReceiptSettingCategoryRepository();

            $feeSetting = $feeReceiptSettingRepository->delete($id);

            if($feeSetting){

                $feeSettingCategory = $feeReceiptSettingCategoryRepository->delete($id);

                $signal = 'success';
                $msg = 'Data deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function getReceiptFeeCategories($allSessions){

            $feeMappingRepository = new FeeMappingRepository();
            $feeReceiptSettingCategoryRepository = new FeeReceiptSettingCategoryRepository();
            $existingFeeCategory = array();

            $allReceiptSettingCategories = $feeReceiptSettingCategoryRepository->allReceiptSettingCategory($allSessions);

            foreach($allReceiptSettingCategories as $feeCategory){
                array_push($existingFeeCategory, $feeCategory->id_fee_category);
            }

            $feeCategories = $feeMappingRepository->getReceiptSettingCategory($existingFeeCategory, $allSessions);

            return $feeCategories;
        }
    }
?>
