<?php
    namespace App\Services;
    use App\Models\InstitutionTypeMapping;
    use App\Repositories\InstitutionTypeMappingRepository;
    use Carbon\Carbon;
    use Session;

    class InstitutionTypeMappingService {

        // Get All Institution Type
        public function getAll(){
            $institutionTypeMappingRepository = new InstitutionTypeMappingRepository();
            $instituteTypes = $institutionTypeMappingRepository->all();
            return $instituteType;
        }

        // Get Perticular Institution Type
        public function find($id){
            $institutionTypeMappingRepository = new InstitutionTypeMappingRepository();
            $instituteType = $institutionTypeMappingRepository->fetch($id);
            return $instituteType;
        }

        // Add Institution Type
        public function add($data)
        {
            $institutionTypeMappingRepository = new InstitutionTypeMappingRepository();
            $check = InstitutionTypeMapping::where('id_board_university', $data->id_board_university)->where('id_institution_type', $data->id_institution_type)->first();

            if(!$check){

                $data = array(
                    "id_board_university" => $data->id_board_university,
                    "id_institution_type" => $data->id_institution_type,
                    'created_by' => Session::get('userId'),
                );
                $storeData = $institutionTypeMappingRepository->store($data);

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
            $institutionTypeMappingRepository = new InstitutionTypeMappingRepository();

            $check = InstitutionType::where('type_name', $institutionTypeData->institutionType)
                            ->where('id', '!=', $id)->first();

            if(!$check){

                $data = array(
                    'type_name' => $institutionTypeData->institutionType,
                    'modified_by' => Session::get('userId'),
                );

                $storeData = $institutionTypeMappingRepository->update($data, $id);

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
            $institutionTypeMappingRepository = new InstitutionTypeMappingRepository();

            $institutionType = $institutionTypeMappingRepository->delete($id);

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
