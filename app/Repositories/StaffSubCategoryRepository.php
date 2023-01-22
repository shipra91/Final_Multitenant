<?php
    namespace App\Repositories;
    use App\Models\StaffSubCategory;
    use App\Models\StaffCategory;
    use App\Interfaces\StaffSubCategoryRepositoryInterface;

    class StaffSubCategoryRepository implements StaffSubCategoryRepositoryInterface{

        public function all(){
            return StaffSubCategory::all();
        }

        public function store($data){
            return StaffSubCategory::create($data);
        }

        public function fetch($id){
            return StaffSubCategory::find($id);
        }

        public function getSubCategoryId($categoryId){
            return StaffSubCategory::where('id_staff_categories', $categoryId)->first();
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return StaffSubCategory::find($id)->delete();
        }

        public function getStaffCategory(){
            return $staffCategory = StaffCategory::all();
        }

        public function allSubcategory($categoryId){
            return StaffSubCategory::where('id_staff_categories', $categoryId)->get();
        }

        public function getAllSubcategory($categoryIdArray){
            return StaffSubCategory::whereIn('id_staff_categories', $categoryIdArray)->get();
        }

        public function findSubCategory($idCategory, $idSubCategory){
            $data = StaffSubCategory::where('id', $idSubCategory)->where('id_staff_categories', $idCategory)->first();
            return $data;
        }

        public function fetchStaffSubCategoryId($staffSubCategory){
            return StaffSubCategory::where("name", $staffSubCategory)->first();
        }
    }
?>
