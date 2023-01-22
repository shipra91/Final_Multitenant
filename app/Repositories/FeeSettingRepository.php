<?php
    namespace App\Repositories;
    use App\Models\FeeSetting;
    use App\Interfaces\FeeSettingRepositoryInterface;
    use DB;
    use Session;

    class FeeSettingRepository implements FeeSettingRepositoryInterface{
  
        public function all($allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];
            return FeeSetting::where('id_institute', $institutionId)->where('id_academic', $academicId)->first();
        }

        public function store($data){
            return $feeSetting = FeeSetting::create($data);
        }

        public function fetch($id){            
            $feeSetting = FeeSetting::find($id);
            return $feeSetting;
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return FeeSetting::find($id)->delete();
        }
    }
