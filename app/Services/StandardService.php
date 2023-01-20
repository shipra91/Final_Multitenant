<?php
    namespace App\Services;
    use App\Models\Standard;
    use App\Services\StandardService;
    use App\Repositories\StandardRepository;
    use Carbon\Carbon;
    use Session;

    class StandardService {

        // Get all standard
        public function getAll(){

            $standardRepository = new StandardRepository();

            $standard = $standardRepository->all();
            return $standard;
        }

        // Get particular standard
        public function find($id){

            $standardRepository = new StandardRepository();

            $standard = $standardRepository->fetch($id);
            return $standard;
        }

        // Insert standard
        public function add($standardData){

            $standardRepository = new StandardRepository();

            $check = Standard::where('name', $standardData->standard)->first();

            if(!$check){

                $data = array(
                    'name' => $standardData->standard,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );

                $storeData = $standardRepository->store($data);

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

        // Update standard
        public function update($standardData, $id){

            $standardRepository = new StandardRepository();

            $check = Standard::where('name', $standardData->standard)
                            ->where('id', '!=', $id)->first();

            if(!$check){

                $standardDetails = $standardRepository->fetch($id);

                $standardDetails->name = $standardData->standard;
                $standardDetails->modified_by = Session::get('userId');
                $standardDetails->updated_at = Carbon::now();

                $updateData = $standardRepository->update($standardDetails);

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

        // Delete standard
        public function delete($id){

            $standardRepository = new StandardRepository();

            $standard = $standardRepository->delete($id);

            if($standard){
                $signal = 'success';
                $msg = 'Standard deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
?>
