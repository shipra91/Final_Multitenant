<?php
    namespace App\Repositories;
    use App\Models\BloodGroup;
    use App\Interfaces\BloodGroupRepositoryInterface;

    class BloodGroupRepository implements BloodGroupRepositoryInterface{

        public function all(){
            return BloodGroup::all();
        }

        public function store($data){
            return BloodGroup::create($data);
        }

        public function fetch($id){
            return BloodGroup::find($id);
        }

        // public function update($data, $id){
        //     return BloodGroup::whereId($id)->update($data);
        // }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return BloodGroup::find($id)->delete();
        }
    }
?>
