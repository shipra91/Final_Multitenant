<?php
    namespace App\Services;
    use App\Models\FeeCategory;
    use App\Repositories\FeeCategoryRepository;
    use Carbon\Carbon;
    use Session;

    class FeeCategoryService {

        // Get all fee category
        public function getAll(){

            $feeCategoryRepository = new FeeCategoryRepository();

            $feeCategory = $feeCategoryRepository->all();
            return $feeCategory;
        }

        // Get particular fee category
        public function find($id){

            $feeCategoryRepository = new FeeCategoryRepository();

            $feeCategory = $feeCategoryRepository->fetch($id);
            return $feeCategory;
        }

        // Insert fee category
        public function add($feeCategoryData){

            $feeCategoryRepository = new FeeCategoryRepository();

            foreach($feeCategoryData['feeCategory'] as $key => $feeCategory){

                $check = FeeCategory::where('name', $feeCategory)->first();

                if(!$check){

                    $data = array(
                        'name' => $feeCategory,
                        'created_by' => Session::get('userId'),
                        'modified_by' => ''
                    );

                    $storeData = $feeCategoryRepository->store($data);

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
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Update fee category
        public function update($feeCategoryData, $id){

            $feeCategoryRepository = new FeeCategoryRepository();

            $check = FeeCategory::where('name', $feeCategoryData->feeCategory)
                                ->where('id', '!=', $id)->first();

            if(!$check){

                $feeCategoryDetails = $feeCategoryRepository->fetch($id);

                $feeCategoryDetails->name = $feeCategoryData->feeCategory;
                $feeCategoryDetails->modified_by = Session::get('userId');
                $feeCategoryDetails->updated_at = Carbon::now();

                $updateData = $feeCategoryRepository->update($feeCategoryDetails);

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

        // Delete fee category
        public function delete($id){

            $feeCategoryRepository = new FeeCategoryRepository();

            $feeCategory = $feeCategoryRepository->delete($id);

            if($feeCategory){
                $signal = 'success';
                $msg = 'Fee Category deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
