<?php
    namespace App\Services;
    use App\Models\AdmissionType;
    use App\Repositories\AdmissionTypeRepository;
    use Carbon\Carbon;
    use Session;

    class AdmissionTypeService {

        // Get all admission type
        public function getAll(){

            $admissionTypeRepository = new AdmissionTypeRepository();

            return $admissionTypeRepository->all();
        }

        // Get particular admission type
        public function find($id){

            $admissionTypeRepository = new AdmissionTypeRepository();

            return $admissionTypeRepository->fetch($id);
        }

        // Insert admission type
        public function add($admissionTypeData){

            $admissionTypeRepository = new AdmissionTypeRepository();

            $check = AdmissionType::where('type', $admissionTypeData->admission_type)
                                    ->where('display_name', $admissionTypeData->display_name)
                                    ->first();

            if(!$check){

                $data = array(
                    'type' => $admissionTypeData->admission_type,
                    'display_name' => $admissionTypeData->display_name,
                    'created_by' => Session::get('userId'),
                    'modified_by' => ''
                );

                $storeData = $admissionTypeRepository->store($data);

                if($storeData){
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

        // Update admission type
        public function update($admissionTypeData, $id){

            $admissionTypeRepository = new AdmissionTypeRepository();

            $check = AdmissionType::where('type', $admissionTypeData->admission_type)
                                    ->where('display_name', $admissionTypeData->display_name)
                                    ->where('id', '!=', $id)
                                    ->first();
            if(!$check){

                $admissionTypeDetails = $admissionTypeRepository->fetch($id);

                $admissionTypeDetails->type = $admissionTypeData->admission_type;
                $admissionTypeDetails->display_name = $admissionTypeData->display_name;
                $admissionTypeDetails->modified_by = Session::get('userId');
                $admissionTypeDetails->updated_at = Carbon::now();

                $updateData = $admissionTypeRepository->update($admissionTypeDetails);

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

        // Delete admission type
        public function delete($id){

            $admissionTypeRepository = new AdmissionTypeRepository();

            $type = $admissionTypeRepository->delete($id);

            if($type){
                $signal = 'success';
                $msg = 'Data deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
?>
