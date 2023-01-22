<?php
    namespace App\Services;
    use App\Models\FeeType;
    use App\Services\FeeTypeService;
    use App\Repositories\FeeTypeRepository;
    use Carbon\Carbon;
    use Session;

    class FeeTypeService {

        // Get all fee type
        public function getAll(){

            $feeTypeRepository = new FeeTypeRepository();
            $feeType = $feeTypeRepository->all();

            return $feeType;
        }

        // Get particular fee type
        public function find($id){

            $feeTypeRepository = new FeeTypeRepository();

            $feeType = $feeTypeRepository->fetch($id);
            return $feeType;
        }

        // Insert fee type
        public function add($feeTypeData){

            $feeTypeRepository = new FeeTypeRepository();

            foreach($feeTypeData['feeType'] as $key => $feeType){

                $check = FeeType::where('name', $feeType)->first();

                if(!$check){

                    $data = array(
                        'name' => $feeType,
                        'created_by' => Session::get('userId'),
                        'modified_by' => ''
                    );

                    $storeData = $feeTypeRepository->store($data);

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

        // Update fee type
        public function update($feeTypeData, $id){

            $feeTypeRepository = new FeeTypeRepository();

            $check = FeeType::where('name', $feeTypeData->feeType)
                            ->where('id', '!=', $id)
                            ->first();

            if(!$check){

                $feeTypeDetails = $feeTypeRepository->fetch($id);

                $feeTypeDetails->name = $feeTypeData->feeType;
                $feeTypeDetails->modified_by = Session::get('userId');
                $feeTypeDetails->updated_at = Carbon::now();

                $updateData = $feeTypeRepository->update($feeTypeDetails);

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

        // Delete fee type
        public function delete($id){

            $feeTypeRepository = new FeeTypeRepository();

            $feeType = $feeTypeRepository->delete($id);

            if($feeType){
                $signal = 'success';
                $msg = 'Fee Type deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

<<<<<<< HEAD
        public function getStandardFeeTypeDetails($idStandard){

            $feeTypeRepository = new FeeTypeRepository();
            return $feeTypeRepository->getStandardFeeType($idStandard);
=======
        public function getStandardFeeTypeDetails($idStandard, $allSessions){

            $feeTypeRepository = new FeeTypeRepository();
            return $feeTypeRepository->getStandardFeeType($idStandard, $allSessions);
>>>>>>> main
        }
    }
