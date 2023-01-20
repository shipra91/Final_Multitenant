<?php 
    namespace App\Repositories;
    use App\Models\PreadmissionApplicationSetting;
    use App\Interfaces\ApplicationSettingRepositoryInterface;

    class ApplicationSettingRepository implements ApplicationSettingRepositoryInterface{

        public function all(){
            return PreadmissionApplicationSetting::all();            
        }

        public function store($data){
            return PreadmissionApplicationSetting::create($data);
        }        

        public function fetch($id){
            return PreadmissionApplicationSetting::find($id);
        }        

        public function update($data, $id){
            return PreadmissionApplicationSetting::whereId($id)->update($data);
        }        

        public function delete($id){
            return PreadmissionApplicationSetting::find($id)->delete();
        }

        public function allDeleted(){
            return PreadmissionApplicationSetting::onlyTrashed()->get();            
        }

        public function restore($id){
            return PreadmissionApplicationSetting::withTrashed()->find($id)->restore();
        } 
        
        public function restoreAll(){
            return PreadmissionApplicationSetting::onlyTrashed()->restore();
        }
    }
?>