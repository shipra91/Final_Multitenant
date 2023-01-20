<?php
    namespace App\Repositories;
    use App\Models\FeeChallanSettingCategory;
    use App\Interfaces\FeeChallanSettingCategoryRepositoryInterface;
    use Session;
    use DB;

    class FeeChallanSettingCategoryRepository implements FeeChallanSettingCategoryRepositoryInterface{

        public function all($idFeeChallanSetting){

            return FeeChallanSettingCategory::where('id_fee_challan_settings', $idFeeChallanSetting)->get();
            
        }  

        public function allChallanSettingCategory($allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $allCategories = FeeChallanSettingCategory::join('tbl_fee_challan_setting', 'tbl_fee_challan_setting.id', '=', 'tbl_fee_challan_setting_categories.id_fee_challan_settings')
                            ->where('id_institute', $institutionId)
                            ->where('id_academic', $academicId)
                            ->select('tbl_fee_challan_setting_categories.id_fee_category')
                            ->get();
                            
            return $allCategories;
            
        }  
        
        public function store($data){
            return FeeChallanSettingCategory::create($data);
        }

        public function fetch($id){
            return FeeChallanSettingCategory::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($idFeeChallanSetting){
            return FeeChallanSettingCategory::where('id_fee_challan_settings', $idFeeChallanSetting)->delete();
        }
        
    }
?>
