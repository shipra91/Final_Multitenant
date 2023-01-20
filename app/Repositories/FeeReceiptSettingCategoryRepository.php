<?php
    namespace App\Repositories;
    use App\Models\FeeReceiptSettingCategory;
    use App\Interfaces\FeeReceiptSettingCategoryRepositoryInterface;
    use Session;
    use DB;

    class FeeReceiptSettingCategoryRepository implements FeeReceiptSettingCategoryRepositoryInterface{

        public function all($idFeeReceiptSetting){

            return FeeReceiptSettingCategory::where('id_fee_receipt_settings', $idFeeReceiptSetting)->get();
            
        }  

        public function allReceiptSettingCategory(){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $allCategories = FeeReceiptSettingCategory::join('tbl_fee_receipt_settings', 'tbl_fee_receipt_settings.id', '=', 'tbl_fee_receipt_setting_categories.id_fee_receipt_settings')
                            ->where('id_institute', $institutionId)
                            ->where('id_academic', $academicId)
                            ->select('tbl_fee_receipt_setting_categories.id_fee_category')
                            ->get();
                            
            return $allCategories;
            
        }  
        
        public function store($data){
            return FeeReceiptSettingCategory::create($data);
        }

        public function fetch($id){
            return FeeReceiptSettingCategory::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($idFeeReceiptSetting){
            return FeeReceiptSettingCategory::where('id_fee_receipt_settings', $idFeeReceiptSetting)->delete();
        }
        
    }
?>
