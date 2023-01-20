<?php
    namespace App\Repositories;
    use App\Models\FeeChallanSetting;
    use App\Interfaces\FeeChallanSettingRepositoryInterface;
    use App\Repositories\FeeChallanSettingCategoryRepository;
    use Session;
    use DB;

    class FeeChallanSettingRepository implements FeeChallanSettingRepositoryInterface{

        public function all(){

            // DB::enableQueryLog();
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return FeeChallanSetting::where('id_institute', $institutionId)->where('id_academic', $academicId)->get();
            
        }  

        public function academicAllChallanSetting($academicId){

            // DB::enableQueryLog();
            $feeChallanSettingCategoryRepository = new FeeChallanSettingCategoryRepository();

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];

            $arrChallanData = array();

            $allChallanSetting = FeeChallanSetting::where('id_institute', $institutionId)->where('id_academic', $academicId)->get();
            if($allChallanSetting){
                foreach($allChallanSetting as $key => $challanSetting){

                    $arrChallanData[$key]['id_challan_setting'] = $challanSetting->id;$arrChallanData[$key]['id_institution_bank_detail'] = $challanSetting->id_institution_bank_detail;
                    $arrChallanData[$key]['challan_prefix'] = $challanSetting->challan_prefix;
                    $arrChallanData[$key]['challan_no_sequence'] = $challanSetting->challan_no_sequence;
                    $arrChallanData[$key]['display_type'] = $challanSetting->display_type;
                    $arrChallanData[$key]['challan_size'] = $challanSetting->challan_size;
                    $arrChallanData[$key]['no_of_copy'] = $challanSetting->no_of_copy;
                    $arrChallanData[$key]['copy_name'] = $challanSetting->copy_name;

                    $allFeeCategory = $feeChallanSettingCategoryRepository->all($challanSetting->id);
                    // dd($allFeeCategory);
                    foreach($allFeeCategory as $index => $feeCategory){

                        $arrChallanData[$key]['setting_categories'][$index] = $feeCategory->id_fee_category;

                    }
                    
                }
            }
            return $arrChallanData;
            
        }  
        
        public function store($data){
            return FeeChallanSetting::create($data);
        }

        public function find($id){
            return FeeChallanSetting::find($id);
        }


        //FETCH SETTING ON CATEGORY BASIS
        public function fetch($idFeeCategory, $idAcademic){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            //DB::enableQueryLog();
            $setting = FeeChallanSetting::join('tbl_fee_challan_setting_categories', 'tbl_fee_challan_setting_categories.id_fee_challan_settings', '=', 'tbl_fee_challan_setting.id')
            ->where('tbl_fee_challan_setting_categories.id_fee_category', $idFeeCategory)
            ->where('id_institute', $institutionId)
            ->where('id_academic', $idAcademic)
            ->select('tbl_fee_challan_setting.*')
            ->first();
            //dd(DB::getQueryLog());
            return $setting;
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return FeeChallanSetting::find($id)->delete();
        }
        
        public function getBankInChallanSetting($idBankDetail){
            return FeeChallanSetting::where('id_institution_bank_detail', $idBankDetail)->first();
        }
    }
?>
