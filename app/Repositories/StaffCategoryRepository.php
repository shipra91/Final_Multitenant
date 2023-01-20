<?php
    namespace App\Repositories;
    use App\Models\StaffCategory;
    use App\Interfaces\StaffCategoryRepositoryInterface;

    class StaffCategoryRepository implements StaffCategoryRepositoryInterface{

        public function all(){
            return StaffCategory::all();
        }

        public function store($data){
            return StaffCategory::create($data);
        }

        public function fetch($id){
            return StaffCategory::find($id);
        }

        public function getCategoryId($label = ""){
            return StaffCategory::where('label', $label)->first();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return StaffCategory::find($id)->delete();
        }

        public function fetchStaffCategoryId($staffCategory){
            return StaffCategory::where("name", $staffCategory)->first();
        }
    }
?>
