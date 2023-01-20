<?php
    namespace App\Services;

    use App\Models\AcademicYearMapping;
    use App\Repositories\AcademicYearMappingRepository;
    use App\Repositories\AcademicYearRepository;
    use App\Repositories\InstitutionRepository;
    use Carbon\Carbon;
    use Session;

    class AcademicYearMappingService {

        // Get all academic year mapping
        public function getAll(){

            $academicYearMappingRepository = new AcademicYearMappingRepository();
            $academicYearRepository = new AcademicYearRepository();
            $institutionRepository = new InstitutionRepository();

            $academicMappings = $academicYearMappingRepository->all();
            $arrayData = array();

            foreach($academicMappings as $key => $academicMapping){

                $academic = $academicYearRepository->fetch($academicMapping->id_academic_year);

                if($academic){
                    $academicYearName = $academic->name;
                }else{
                    $academicYearName = '-';
                }

                $institution = $institutionRepository->fetch($academicMapping->id_institute);

                $data = array(
                    'id' => $academicMapping->id,
                    'id_institute' => $institution->name,
                    'id_academic_year' => $academicYearName,
                    'default_year' => $academicMapping->default_year,
                    'created_by' => $academicMapping->created_by,
                    'modified_by' => $academicMapping->modified_by,
                );
                array_push($arrayData, $data);
            }

            return $arrayData;
        }

        // Get particular academic year mapping
        public function find($id){

            $academicYearMappingRepository = new AcademicYearMappingRepository();
            return $academicYearMappingRepository->fetch($id);

        }

        // Get all institution
        public function allInstitution(){

            $institutionRepository = new InstitutionRepository();
            return $institutionRepository->all();
        }

        // Get all academic year
        public function allAcademicYear(){

            $academicYearMappingRepository = new AcademicYearMappingRepository();
            return $academicYearMappingRepository->all();
        }

        // Get institute academic year
        public function institutionAllAcademicYears($idInstitution){

            $academicYearMappingRepository = new AcademicYearMappingRepository();
            return $academicYearMappingRepository->getInstitutionAcademics($idInstitution);
        }

        // Insert academic year mapping
        public function add($academicMappingData){

            $academicYearMappingRepository = new AcademicYearMappingRepository();

            $check = AcademicYearMapping::where('id_institute', $academicMappingData->institute)
                                        ->where('id_academic_year', $academicMappingData->academicYear)
                                        ->first();
            if(!$check){

                $data = array(
                    'id_institute' => $academicMappingData->institute,
                    'id_academic_year' => $academicMappingData->academicYear,
                    'default_year' => $academicMappingData->defaultYear,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );

                $storeData = $academicYearMappingRepository->store($data);

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

        // Update academic year mapping
        public function update($academicMappingData, $id){

            $academicYearMappingRepository = new AcademicYearMappingRepository();

            $check = AcademicYearMapping::where('id_institute', $academicMappingData->institute)
                                        ->where('id_academic_year', $academicMappingData->defaultYear)
                                        ->where('id', '!=', $id)
                                        ->first();
            if(!$check){

                $academicYearMappingDetails = $academicYearMappingRepository->fetch($id);

                $academicYearMappingDetails->id_academic_year = $academicMappingData->academicYear;
                $academicYearMappingDetails->default_year = $academicMappingData->defaultYear;
                $academicYearMappingDetails->modified_by = Session::get('userId');
                $academicYearMappingDetails->updated_at = Carbon::now();

                $updateData = $academicYearMappingRepository->update($academicYearMappingDetails);
                // dd($updateData);
                if($updateData){
                    // if($academicMappingData->defaultYear === 'YES'){
                    //     $getAcademicsDetail = $academicYearMappingRepository->allExceptSelected($academicMappingData->institute, $id);
                    //     dd($getAcademicsDetail);
                    //     foreach($getAcademicsDetail as $getAcademic){

                    //         $academicYearMappingInfo = $academicYearMappingRepository->fetch($getAcademic['id']);
                    //         $academicYearMappingInfo->default_year = 'NO';
                    //         $academicYearMappingInfo->modified_by = Session::get('userId');
                    //         $academicYearMappingInfo->updated_at = Carbon::now();

                    //         $updateDetail = $academicYearMappingRepository->update($academicYearMappingInfo);
                    //     }
                    // }

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

        // Delete academic year mapping
        public function delete($id){

            $academicYearMappingRepository = new AcademicYearMappingRepository();

            $academicYearMapping = $academicYearMappingRepository->delete($id);

            if($academicYearMapping){
                $signal = 'success';
                $msg = 'Data deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Deleted academic year mapping records
        public function getDeletedRecords(){

            $academicYearMappingRepository = new AcademicYearMappingRepository();
            $academicYearRepository = new AcademicYearRepository();
            $institutionRepository = new InstitutionRepository();

            $academicMappings = $academicYearMappingRepository->allDeleted();
            $arrayData = array();

            foreach($academicMappings as $key => $academicMapping){

                $academic = $academicYearRepository->fetch($academicMapping->id_academic_year);

                if($academic){
                    $academicYearName = $academic->name;
                }else{
                    $academicYearName = '-';
                }
                $institution = $institutionRepository->fetch($academicMapping->id_institute);

                $data = array(
                    'id' => $academicMapping->id,
                    'id_institute' => $institution->name,
                    'id_academic_year' => $academicYearName,
                    'default_year' => $academicMapping->default_year,
                    'created_by' => $academicMapping->created_by,
                    'modified_by' => $academicMapping->modified_by,
                );
                array_push($arrayData, $data);
            }

            return $arrayData;
        }

        // Restore academic year mapping records
        public function restore($id){

            $academicYearMappingRepository = new AcademicYearMappingRepository();

            $data = $academicYearMappingRepository->restore($id);

            if($data){

                $signal = 'success';
                $msg = 'Data restored successfully!';

            }else{

                $signal = 'failure';
                $msg = 'Data deletion is failed!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
?>
