<?php
    namespace App\Services;
    use App\Models\BloodGroup;
    use App\Services\BloodGroupService;
    use App\Repositories\BloodGroupRepository;
    use Carbon\Carbon;
    use Session;

    class BloodGroupService {

        // Get all blood group
        public function getAll(){

            $bloodGroupRepository = new BloodGroupRepository();
            $bloodGroup = $bloodGroupRepository->all();

            return $bloodGroup;
        }

        // Get particular blood group
        public function find($id){

            $bloodGroupRepository = new BloodGroupRepository();
            $bloodGroup = $bloodGroupRepository->fetch($id);

            return $bloodGroup;
        }

        // Insert blood group
        public function add($bloodGroupData){

            $bloodGroupRepository = new BloodGroupRepository();

            $check = BloodGroup::where('name', $bloodGroupData->bloodGroup)->first();

            if(!$check){

                $data = array(
                    'name' => $bloodGroupData->bloodGroup,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );

                $storeData = $bloodGroupRepository->store($data);

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

        // Update blood group
        public function update($bloodGroupData, $id){

            $bloodGroupRepository = new BloodGroupRepository();

            $check = BloodGroup::where('name', $bloodGroupData->bloodGroup)
                                ->where('id', '!=', $id)
                                ->first();

            if(!$check){

                $bloodGroupDetails = $bloodGroupRepository->fetch($id);

                $bloodGroupDetails->name = $bloodGroupData->bloodGroup;
                $bloodGroupDetails->modified_by = Session::get('userId');
                $bloodGroupDetails->updated_at = Carbon::now();

                $updateData = $bloodGroupRepository->update($bloodGroupDetails);

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

        // Delete blood group
        public function delete($id){

            $bloodGroupRepository = new BloodGroupRepository();

            $bloodGroup = $bloodGroupRepository->delete($id);

            if($bloodGroup){
                $signal = 'success';
                $msg = 'Blood Group deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
