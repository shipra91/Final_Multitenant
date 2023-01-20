<?php
    namespace App\Services;
    use App\Models\Nationality;
    use App\Services\NationalityService;
    use App\Repositories\NationalityRepository;
    use Carbon\Carbon;
    use Session;

    class NationalityService
    {
        // Get all nationality
        public function getAll(){

            $nationalityRepository = new NationalityRepository();

            $nationality = $nationalityRepository->all();
            return $nationality;
        }

        // Get particular nationality
        public function find($id){

            $nationalityRepository = new NationalityRepository();

            $nationality = $nationalityRepository->fetch($id);
            return $nationality;
        }

        // Insert nationality
        public function add($nationalityData){

            $nationalityRepository = new NationalityRepository();

            $check = Nationality::where('name', $nationalityData->nationality)->first();

            if(!$check){

                $data = array(
                    'name' => $nationalityData->nationality,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );

                $storeData = $nationalityRepository->store($data);

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

        // Update nationality
        public function update($nationalityData, $id){

            $nationalityRepository = new NationalityRepository();

            $check = Nationality::where('name', $nationalityData->nationality)
                                ->where('id', '!=', $id)
                                ->first();

            if(!$check){

                $nationalityDetails = $nationalityRepository->fetch($id);

                $nationalityDetails->name = $nationalityData->nationality;
                $nationalityDetails->modified_by = Session::get('userId');
                $nationalityDetails->updated_at = Carbon::now();

                $updateData = $nationalityRepository->update($nationalityDetails);

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

        // Delete nationality
        public function delete($id){

            $nationalityRepository = new NationalityRepository();

            $nationality = $nationalityRepository->delete($id);

            if($nationality){
                $signal = 'success';
                $msg = 'Nationality deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
