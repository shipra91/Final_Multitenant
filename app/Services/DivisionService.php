<?php
    namespace App\Services;
    use App\Models\Division;
    use App\Repositories\DivisionRepository;
    use Carbon\Carbon;
    use Session;

    class DivisionService {

        // Get all division
        public function getAll(){

            $divisionRepository = new DivisionRepository();
            $divisions = $divisionRepository->all();

            return $divisions;
        }

        // Get particular division
        public function find($id){

            $divisionRepository = new DivisionRepository();
            $division = $divisionRepository->fetch($id);

            return $division;
        }

        // Insert division
        public function add($divisionData){

            $divisionRepository = new DivisionRepository();

            $check = Division::where('name', $divisionData->division_label)->first();

            if(!$check){

                $data = array(
                    'name' => $divisionData->division_label,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );

                $storeData = $divisionRepository->store($data);

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

        // Update division
        public function update($divisionData, $id){

            $divisionRepository = new DivisionRepository();

            $check = Division::where('name', $divisionData->division_label)
                            ->where('id', '!=', $id)->first();

            if(!$check){

                $divisionDetails = $divisionRepository->fetch($id);

                $divisionDetails->name = $divisionData->division_label;
                $divisionDetails->modified_by = Session::get('userId');
                $divisionDetails->updated_at = Carbon::now();

                $updateData = $divisionRepository->update($divisionDetails);

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

        // Delete division
        public function delete($id){

            $divisionRepository = new DivisionRepository();
            $division = $divisionRepository->delete($id);

            if($division){
                $signal = 'success';
                $msg = 'Division deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
?>
