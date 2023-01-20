<?php
    namespace App\Services;
    use App\Models\InstitutionType;
    use App\Repositories\InstitutionTypeRepository;
    use Carbon\Carbon;
    use Session;

    class InstitutionTypeService {

        // Get All Institution Type
        public function getAll(){
            $institutionTypeRepository = new InstitutionTypeRepository();
            $instituteType = $institutionTypeRepository->all();
            return $instituteType;
        }

        // Get Perticular Institution Type
        public function find($id){
            $institutionTypeRepository = new InstitutionTypeRepository();
            $instituteType = $institutionTypeRepository->fetch($id);
            return $instituteType;
        }

        // Add Institution Type
        public function add($institutionTypeData)
        {
            $institutionTypeRepository = new InstitutionTypeRepository();
            $check = InstitutionType::where('type_name', $institutionTypeData->institutionType)->first();

            if(!$check){

                $data = array(
                    'type_name' => $institutionTypeData->institutionType,
                    'created_by' => Session::get('userId'),
                );
                $storeData = $institutionTypeRepository->store($data);

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

        // Update Institution Type
        public function update($institutionTypeData, $id){
            $institutionTypeRepository = new InstitutionTypeRepository();

            $check = InstitutionType::where('type_name', $institutionTypeData->institutionType)
                            ->where('id', '!=', $id)->first();

            if(!$check){

                $data = array(
                    'type_name' => $institutionTypeData->institutionType,
                    'modified_by' => Session::get('userId'),
                );

                $storeData = $institutionTypeRepository->update($data, $id);

                if($storeData){
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

        // Delete Institution Type
        public function delete($id){
            $institutionTypeRepository = new InstitutionTypeRepository();

            $institutionType = $institutionTypeRepository->delete($id);

            if($institutionType){
                $signal = 'success';
                $msg = 'Institution Type deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
?>
