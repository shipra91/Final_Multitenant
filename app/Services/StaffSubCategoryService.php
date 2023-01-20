<?php
    namespace App\Services;
    use App\Models\StaffSubCategory;
    use App\Repositories\StaffSubCategoryRepository;
    use App\Repositories\StaffCategoryRepository;
    use Carbon\Carbon;
    use Session;

    class StaffSubCategoryService {

        // Get all staff subcategory
        public function getAll(){

            $staffSubCategoryRepository = new StaffSubCategoryRepository();
            $staffCategoryRepository = new StaffCategoryRepository();

            $staffsubcategories = $staffSubCategoryRepository->all();
            $arrayData = array();

            foreach($staffsubcategories as $key => $staffsubcategory){

                $categoryName = '';
                $staffCategory = $staffCategoryRepository->fetch($staffsubcategory->id_staff_categories);

                if($staffCategory){
                    $categoryName = $staffCategory->name;
                }

                $data = array(
                    'id' => $staffsubcategory->id,
                    'id_staffcategory' => $categoryName,
                    'staff_subcategory' => $staffsubcategory->name,
                    'created_by' => $staffsubcategory->created_by,
                    'modified_by' => $staffsubcategory->modified_by,
                );

                array_push($arrayData, $data);
            }

            return $arrayData;
        }

        // Get particular staff subcategory
        public function find($id){

            $staffSubCategoryRepository = new StaffSubCategoryRepository();
            $staffSubCategory = $staffSubCategoryRepository->fetch($id);

            return $staffSubCategory;
        }

        // Get staff category
        public function allStaffCategory(){

            $staffSubCategoryRepository = new StaffSubCategoryRepository();
            $staffCategory = $staffSubCategoryRepository->getStaffCategory();

            return $staffCategory;
        }

        // Insert staff subcategory
        public function add($subcategoryData){

            $staffSubCategoryRepository = new StaffSubCategoryRepository();
            $check = StaffSubCategory::where('id_staff_categories', $subcategoryData->staffCategory)
                                    ->where('name', $subcategoryData->staffSubCategory)->first();
            if(!$check){

                $data = array(
                    'id_staff_categories' => $subcategoryData->staffCategory,
                    'name' => $subcategoryData->staffSubCategory,
                    'created_by' => Session::get('userId'),
                    'modified_by' => ''
                );

                $storeData = $staffSubCategoryRepository->store($data);

                if($storeData) {

                    $signal = 'success';
                    $msg = 'Data inserted successfully!';

                }else{

                    $signal = 'failure';
                    $msg = 'Error inserting data!';
                }

            }else{
                $signal = 'exist';
                $msg = 'This data already exists!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Update staff category
        public function update($subcategoryData, $id){

            $staffSubCategoryRepository = new StaffSubCategoryRepository();

            $check = StaffSubCategory::where('id_staff_categories', $subcategoryData->staffCategory)
                                    ->where('name', $subcategoryData->staffSubCategory)
                                    ->where('id', '!=', $id)->first();

            if(!$check){

                $staffSubCategoryDetails = $staffSubCategoryRepository->fetch($id);

                $staffSubCategoryDetails->id_staff_categories = $subcategoryData->staffCategory;
                $staffSubCategoryDetails->name = $subcategoryData->staffSubCategory;
                $staffSubCategoryDetails->modified_by = Session::get('userId');
                $staffSubCategoryDetails->updated_at = Carbon::now();

                $updateData = $staffSubCategoryRepository->update($staffSubCategoryDetails);

                if($updateData){
                    $signal = 'success';
                    $msg = 'Data updated successfully!';

                }else{
                    $signal = 'failure';
                    $msg = 'Error updating data!';
                }

            }else{
                $signal = 'exist';
                $msg = 'This data already exists!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Delete staff subcategory
        public function delete($id){

            $staffSubCategoryRepository = new StaffSubCategoryRepository();
            $staffSubCategory = $staffSubCategoryRepository->delete($id);

            if($staffSubCategory){
                $signal = 'exist';
                $msg = 'Data deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Get all staff subcategory
        public function getSubcategoryOption($categoryId){

            $staffSubCategoryRepository = new StaffSubCategoryRepository();
            $staffSubCategories = $staffSubCategoryRepository->allSubcategory($categoryId);
            $arrayData = '';

            foreach($staffSubCategories as $key => $staffSubcategory){
                $arrayData .='<option value="'.$staffSubcategory->id.'">'.$staffSubcategory->name.'</option>';
            }

            return $arrayData;
        }

        // Get staff subcategory
        public function getAllSubcategory($categoryIdArray){

            $staffSubCategoryRepository = new StaffSubCategoryRepository();
            $staffSubCategories = $staffSubCategoryRepository->getAllSubcategory($categoryIdArray);
            $arrayData = '';

            foreach($staffSubCategories as $key => $staffSubcategory){
                $arrayData .='<option value="'.$staffSubcategory->id.'">'.$staffSubcategory->name.'</option>';
            }

            return $arrayData;
        }
    }
?>
