<?php
    namespace App\Services;
    use App\Models\Designation;
    use App\Services\DesignationService;
    use App\Repositories\DesignationRepository;
    use Carbon\Carbon;
    use Session;

    class DesignationService {

        // Get all designation
        public function getAll(){

            $designationRepository = new DesignationRepository();

            $designation = $designationRepository->all();
            return $designation;
        }

        // Get particular designation
        public function find($id){

            $designationRepository = new DesignationRepository();

            $designation = $designationRepository->fetch($id);
            return $designation;
        }

        // Insert designation
        public function add($designationData){

            $designationRepository = new DesignationRepository();

            $check = Designation::where('name', $designationData->designation)->first();

            if(!$check){

                $data = array(
                    'name' => $designationData->designation,
                    'created_by' => Session::get('userId'),
                    'modified_by' => ''
                );

                $storeData = $designationRepository->store($data);

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

        // Update designation
        public function update($designationData, $id){

            $designationRepository = new DesignationRepository();

            $check = Designation::where('name', $designationData->designation)
                                ->where('id', '!=', $id)
                                ->first();

            if(!$check){

                $designationDetails = $designationRepository->fetch($id);

                $designationDetails->name = $designationData->designation;
                $designationDetails->modified_by = Session::get('userId');
                $designationDetails->updated_at = Carbon::now();

                $updateData = $designationRepository->update($designationDetails);

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

        // Delete designation
        public function delete($id){

            $designationRepository = new DesignationRepository();

            $designation = $designationRepository->delete($id);

            if($designation){
                $signal = 'success';
                $msg = 'Designation deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
?>
