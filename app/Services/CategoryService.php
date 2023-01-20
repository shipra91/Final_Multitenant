<?php
    namespace App\Services;
    use App\Models\Category;
    use App\Services\CategoryService;
    use App\Repositories\CategoryRepository;
    use Carbon\Carbon;
    use Session;

    class CategoryService {

        // Get all category
        public function getAll(){

            $categoryRepository = new CategoryRepository();

            $category = $categoryRepository->all();
            return $category;
        }

        // Get particular category
        public function find($id){

            $categoryRepository = new CategoryRepository();

            $category = $categoryRepository->fetch($id);
            return $category;
        }

        // Insert category
        public function add($categoryData){

            $categoryRepository = new CategoryRepository();

            $check = category::where('name', $categoryData->category)->first();

            if(!$check){

                $data = array(
                    'name' => $categoryData->category,
                    'created_by' => 'ADMIN',
                    'modified_by' => 'ADMIN'
                );

                $storeData = $categoryRepository->store($data);

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

        // Update category
        public function update($categoryData, $id){

            $categoryRepository = new CategoryRepository();

            $check = category::where('name', $categoryData->category)
                            ->where('id', '!=', $id)->first();

            if(!$check){

                $categoryDetails = $categoryRepository->fetch($id);

                $categoryDetails->name = $categoryData->category;
                $categoryDetails->modified_by = Session::get('userId');
                $categoryDetails->updated_at = Carbon::now();

                $updateData = $categoryRepository->update($categoryDetails);

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

        // Delete category
        public function delete($id){

            $categoryRepository = new CategoryRepository();
            $category = $categoryRepository->delete($id);

            if($category){
                $signal = 'success';
                $msg = 'Category deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
?>
