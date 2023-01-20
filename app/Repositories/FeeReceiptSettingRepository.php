<?php
    namespace App\Repositories;

    use App\Models\FeeReceiptSetting;
    use App\Interfaces\FeeReceiptSettingRepositoryInterface;
    use App\Repositories\FeeReceiptSettingCategoryRepository;
    use Session;
    use DB;

    class FeeReceiptSettingRepository implements FeeReceiptSettingRepositoryInterface {

        public function all(){

            // DB::enableQueryLog();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return FeeReceiptSetting::where('id_institute', $institutionId)->where('id_academic', $academicId)->get();
        }

        public function academicAllReceiptSetting($academicId, $allSessions){

            // DB::enableQueryLog();
            $feeReceiptSettingCategoryRepository = new FeeReceiptSettingCategoryRepository();

            $institutionId = $allSessions['institutionId'];

            $arrReceiptData = array();

            $allReceiptSetting = FeeReceiptSetting::where('id_institute', $institutionId)->where('id_academic', $academicId)->get();

            if($allReceiptSetting){

                foreach($allReceiptSetting as $key => $receiptSetting){

                    $arrReceiptData[$key]['id_receipt_setting'] = $receiptSetting->id;
                    $arrReceiptData[$key]['receipt_prefix'] = $receiptSetting->receipt_prefix;
                    $arrReceiptData[$key]['receipt_no_sequence'] = $receiptSetting->receipt_no_sequence;
                    $arrReceiptData[$key]['display_type'] = $receiptSetting->display_type;
                    $arrReceiptData[$key]['receipt_size'] = $receiptSetting->receipt_size;
                    $arrReceiptData[$key]['no_of_copy'] = $receiptSetting->no_of_copy;
                    $arrReceiptData[$key]['copy_name'] = $receiptSetting->copy_name;

                    $allFeeCategory = $feeReceiptSettingCategoryRepository->all($receiptSetting->id);
                    // dd($allFeeCategory);
                    foreach($allFeeCategory as $index => $feeCategory){
                        $arrReceiptData[$key]['setting_categories'][$index] = $feeCategory->id_fee_category;
                    }
                }
            }

            return $arrReceiptData;
        }

        public function store($data){
            return FeeReceiptSetting::create($data);
        }

        public function find($id){
            return FeeReceiptSetting::find($id);
        }

        // Fetch setting on category basis
        public function fetch($idFeeCategory, $idAcademic, $allSessions){

            $institutionId = $allSessions['institutionId'];

            $setting = FeeReceiptSetting::join('tbl_fee_receipt_setting_categories', 'tbl_fee_receipt_setting_categories.id_fee_receipt_settings', '=', 'tbl_fee_receipt_settings.id')
                        ->where('tbl_fee_receipt_setting_categories.id_fee_category', $idFeeCategory)
                        ->where('id_institute', $institutionId)
                        ->where('id_academic', $idAcademic)
                        ->select('tbl_fee_receipt_settings.*')
                        ->first();

            return $setting;
        }

        // Fetch setting on ID
        public function fetchData($id){

            $setting = FeeReceiptSetting::find($id);

            return $setting;
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return FeeReceiptSetting::find($id)->delete();
        }
    }
?>
