<?php
    namespace App\Services;
    use App\Models\Religion;
    use App\Services\ReligionService;
    use App\Repositories\ReligionRepository;
    use Carbon\Carbon;
    use Session;

    class ReligionService {

        // Get all religion
        public function getAll(){

            $religionRepository = new ReligionRepository();
            $religion = $religionRepository->all();

            return $religion;
        }

        // Get particular religion
        public function find($id){

            $religionRepository = new ReligionRepository();
            $religion = $religionRepository->fetch($id);

            return $religion;
        }

        // Insert religion
        public function add($religionData){

            $religionRepository = new ReligionRepository();

            $check = Religion::where('name', $religionData->religion)->first();

            if(!$check){

                $data = array(
                    'name' => $religionData->religion,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );

                $storeData = $religionRepository->store($data);

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

        // Update religion
        public function update($religionData, $id){

            $religionRepository = new ReligionRepository();

            $check = Religion::where('name', $religionData->religion)
                            ->where('id', '!=', $id)
                            ->first();
            if(!$check){

                $religionDetails = $religionRepository->fetch($id);

                $religionDetails->name = $religionData->religion;
                $religionDetails->modified_by = Session::get('userId');
                $religionDetails->updated_at = Carbon::now();

                $updateData = $religionRepository->update($religionDetails);

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

        // Delete religion
        public function delete($id){

            $religionRepository = new ReligionRepository();

            $religion = $religionRepository->delete($id);

            if($religion){
                $signal = 'success';
                $msg = 'Religion deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
