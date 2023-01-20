<?php
    namespace App\Repositories;
    use App\Models\ClassTimeTableSetting;
    use App\Interfaces\ClassTimeTableSettingRepositoryInterface;

    class ClassTimeTableSettingRepository implements ClassTimeTableSettingRepositoryInterface{

        public function all(){
            return ClassTimeTableSetting::all();
        }

        public function store($data){
            return ClassTimeTableSetting::create($data);
        }

        public function fetch($id){
            return ClassTimeTableSetting::find($id);
        }

        public function update($data, $id){
            return ClassTimeTableSetting::whereId($id)->update($data);
        }

        public function delete($id){
            return ClassTimeTableSetting::find($id)->delete();
        }
    }
?>
