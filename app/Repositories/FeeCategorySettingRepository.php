<?php
    namespace App\Repositories;
    use App\Models\FeeCategorySetting;
    use App\Interfaces\FeeCategorySettingRepositoryInterface;
    use Storage;
    use Session;
    use DB;

    class FeeCategorySettingRepository implements FeeCategorySettingRepositoryInterface{

        public function all($feeMasterId){
            return FeeCategorySetting::where('id_fee_master', $feeMasterId)->first();
        }

        public function store($data){
            return FeeCategorySetting::create($data);
        }

        public function fetch($masterId){
            return FeeCategorySetting::where('id_fee_master', $masterId)->first();
        }

        public function search($id){
            return FeeCategorySetting::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return FeeCategorySetting::find($id)->delete();
        }

        public function fetchCategoryDetail($idFeeMaster, $allSessions){

            DB::enableQueryLog();
            
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $response = FeeCategorySetting::join('tbl_category_fee_heading_masters', 'tbl_category_fee_heading_masters.id_category_setting', '=', 'tbl_fee_category_setting.id')
            ->where('id_fee_master', $idFeeMaster)
            ->whereNull('tbl_category_fee_heading_masters.deleted_at')
            ->orderBy('collection_priority', 'ASC')
            ->get(['tbl_category_fee_heading_masters.*']);
            // dd(DB::getQueryLog());
            // dd($response);
            return $response;

        }

    
        public function getCategoryWiseDetails($idFeeMaster){

            DB::enableQueryLog();
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $categoryDetails = FeeCategorySetting::join('tbl_fee_installment', 'tbl_fee_installment.id_fee_assign', '=', 'tbl_fee_category_setting.id')
            ->where('id_fee_master', $idFeeMaster)
            ->get(['tbl_fee_category_setting.*', 'tbl_fee_installment.*']);
            // dd(DB::getQueryLog());
            return $categoryDetails;

        }
    }

