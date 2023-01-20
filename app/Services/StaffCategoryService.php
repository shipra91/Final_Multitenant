<?php
    namespace App\Services;
    use App\Models\StaffCategory;
    use App\Services\StaffCategoryService;
    use App\Repositories\StaffCategoryRepository;
    use Carbon\Carbon;
    use Session;

    class StaffCategoryService {

        // Get all staff category
        public function getAll(){

            $staffCategoryRepository = new StaffCategoryRepository();
            $staffCategory = $staffCategoryRepository->all();

            return $staffCategory;
        }

        // Get particular staff category
        public function find($id){

            $staffCategoryRepository = new StaffCategoryRepository();
            $staffCategory = $staffCategoryRepository->fetch($id);

            return $staffCategory;
        }

        // Insert staff category
        public function add($staffCategoryData){

            $staffCategoryRepository = new StaffCategoryRepository();

            $check = StaffCategory::where('name', $staffCategoryData->staffCategory)->first();

            if(!$check){

                $data = array(
                    'name' => $staffCategoryData->staffCategory,
                    'created_by' => Session::get('userId'),
                    'modified_by' => ''
                );

                $storeData = $staffCategoryRepository->store($data);

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
        public function update($staffCategoryData, $id){

            $staffCategoryRepository = new StaffCategoryRepository();

            $check = StaffCategory::where('name', $staffCategoryData->staffCategory)
                                    ->where('id', '!=', $id)->first();

            if(!$check){

                $staffCategoryDetails = $staffCategoryRepository->fetch($id);

                $staffCategoryDetails->name = $staffCategoryData->staffCategory;
                $staffCategoryDetails->modified_by = Session::get('userId');
                $staffCategoryDetails->updated_at = Carbon::now();

                $updateData = $staffCategoryRepository->update($staffCategoryDetails);

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

        // Delete staff category
        public function delete($id){

            $staffCategoryRepository = new StaffCategoryRepository();
            $staffCategory = $staffCategoryRepository->delete($id);

            if($staffCategory){
                $signal = 'success';
                $msg = 'Staff Category deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
?>
