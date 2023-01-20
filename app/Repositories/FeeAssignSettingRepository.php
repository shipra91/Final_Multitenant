<?php
    namespace App\Repositories;
    use App\Models\FeeAssignSetting;
    use App\Interfaces\FeeAssignSettingRepositoryInterface;
    use DB;

    class FeeAssignSettingRepository implements FeeAssignSettingRepositoryInterface{

        public function all($feeMasterId, $feeHeadingId){

            DB::enableQueryLog();
            $data = FeeAssignSetting::where('id_fee_master', $feeMasterId)->where('id_fee_heading', $feeHeadingId)->first();

            // dd(DB::getQueryLog());
            return $data;

        }

        public function store($data){
            return FeeAssignSetting::create($data);
        }

        public function fetch($id){
            return FeeAssignSetting::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return FeeAssignSetting::find($id)->delete();
        }    
    }

