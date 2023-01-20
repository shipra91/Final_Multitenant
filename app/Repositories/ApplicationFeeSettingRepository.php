<?php 
    namespace App\Repositories;
    use App\Models\ApplicationFeeSetting;
    use App\Interfaces\ApplicationFeeSettingRepositoryInterface;

    class ApplicationFeeSettingRepository implements ApplicationFeeSettingRepositoryInterface{

        public function all(){
            return ApplicationFeeSetting::all();            
        }

        public function store($data){
            return ApplicationFeeSetting::create($data);
        }        

        public function fetch($id){
            return ApplicationFeeSetting::find($id);
        }        

        public function update($data, $id){
            return ApplicationFeeSetting::whereId($id)->update($data);
        }        

        public function delete($id){
            return ApplicationFeeSetting::find($id)->delete();
        }

        public function allDeleted(){
            return ApplicationFeeSetting::onlyTrashed()->get();            
        }

        public function restore($id){
            return ApplicationFeeSetting::withTrashed()->find($id)->restore();
        } 
        
        public function restoreAll(){
            return ApplicationFeeSetting::onlyTrashed()->restore();
        }
    }
?>