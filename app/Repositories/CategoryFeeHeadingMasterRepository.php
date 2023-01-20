<?php
    namespace App\Repositories;
    use App\Models\CategoryFeeHeadingMaster;
    use App\Interfaces\CategoryFeeHeadingMasterRepositoryInterface;
    use DB;

    class CategoryFeeHeadingMasterRepository implements CategoryFeeHeadingMasterRepositoryInterface{

        public function all(){
            return CategoryFeeHeadingMaster::all();
        }

        public function store($data){
            return CategoryFeeHeadingMaster::create($data);
        }

        public function fetch($feeCategorySettingId, $feeHeadingId){
            DB::enableQueryLog();
            return CategoryFeeHeadingMaster::where('id_category_setting', $feeCategorySettingId)->where('id_fee_heading', $feeHeadingId)->first();
            // dd(DB::getQueryLog());
        }

        
        public function getCategorySetting($feeCategorySettingId){
            DB::enableQueryLog();
            return CategoryFeeHeadingMaster::where('id_category_setting', $feeCategorySettingId)->get();
            // dd(DB::getQueryLog());
        }

        public function update($data){
            return $data->save();
        }

        public function delete($categoryFeeSettingId){
            //DB::enableQueryLog();
            return CategoryFeeHeadingMaster::where('id_category_setting', $categoryFeeSettingId)->delete();
            //dd(DB::getQueryLog());
        }
    }

