<?php 
    namespace App\Repositories;
    use App\Models\PreadmissionApplicationSetting;
    use App\Interfaces\ApplicationSettingRepositoryInterface;

    class ApplicationSettingRepository implements ApplicationSettingRepositoryInterface{

        public function all($allSessions){

            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return PreadmissionApplicationSetting::where('id_institution', $institutionId)->where('id_academic', $academicId)->get();            
        }

        public function store($data){
            return PreadmissionApplicationSetting::create($data);
        }        

        public function fetch($id){
            return PreadmissionApplicationSetting::find($id);
        }        

        public function update($data){
            return $data->save();
        }        

        public function delete($id){
            return PreadmissionApplicationSetting::find($id)->delete();
        }

        public function allDeleted($allSessions){
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return PreadmissionApplicationSetting::where('id_institution', $institutionId)->where('id_academic', $academicId)->onlyTrashed()->get();            
        }

        public function restore($id){
            return PreadmissionApplicationSetting::withTrashed()->find($id)->restore();
        } 
        
        public function restoreAll($allSessions){
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            return PreadmissionApplicationSetting::where('id_institution', $institutionId)->where('id_academic', $academicId)->onlyTrashed()->restore();
        }
    }
?>