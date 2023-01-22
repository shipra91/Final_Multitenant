<?php
    namespace App\Services;
<<<<<<< HEAD

=======
>>>>>>> main
    use App\Models\InstitutionFeeTypeMapping;
    use App\Repositories\InstitutionFeeTypeMappingRepository;
    use App\Repositories\FeeTypeRepository;
    use App\Repositories\InstitutionRepository;
    use App\Repositories\FeeMasterRepository;
    use App\Repositories\StudentMappingRepository;
    use Carbon\Carbon;
    use Session;

    class InstitutionFeeTypeMappingService {

<<<<<<< HEAD
        // Get all Institution feetype mapping
        public function getAll(){
=======
        // Get all academic year mapping
        public function getAll($allSessions){
>>>>>>> main

            $institutionFeeTypeMappingRepository = new InstitutionFeeTypeMappingRepository();
            $feeTypeRepository = new FeeTypeRepository();
            $institutionRepository = new InstitutionRepository();

<<<<<<< HEAD
            $institutionFeeTypeMapping = $institutionFeeTypeMappingRepository->all();
=======
            $institutionFeeTypeMapping = $institutionFeeTypeMappingRepository->all($allSessions);
>>>>>>> main
            $arrayData = array();

            foreach($institutionFeeTypeMapping as $key => $institutionFeeType){

                $feeType = $feeTypeRepository->fetch($institutionFeeType->id_fee_type);
<<<<<<< HEAD

=======
>>>>>>> main
                if($feeType){
                    $feeTypeName = $feeType->name;
                }else{
                    $feeTypeName = '-';
                }
                $institution = $institutionRepository->fetch($institutionFeeType->id_institute);

                $data = array(
                    'id' => $institutionFeeType->id,
                    'id_institute' => $institution->name,
                    'fee_type' => $feeTypeName,
                    'created_by' => $institutionFeeType->created_by,
                    'modified_by' => $institutionFeeType->modified_by,
                );
                array_push($arrayData, $data);
            }

            return $arrayData;
        }

<<<<<<< HEAD
        // Get particular Institution feetype mapping
        public function find($id){
            $institutionFeeTypeMappingRepository = new InstitutionFeeTypeMappingRepository();
            return $institutionFeeTypeMappingRepository->fetch($id);
        }

        // Insert Institution feetype mapping
        public function add($feeTypeMappingData){

            $institutionFeeTypeMappingRepository = new InstitutionFeeTypeMappingRepository();

            $storeCount = 0;

            foreach($feeTypeMappingData->fee_type as $feeType){

                $check = InstitutionFeeTypeMapping::where('id_institute', $feeTypeMappingData->institute)
                                                    ->where('id_fee_type', $feeType)
                                                    ->first();
=======
        // Get particular academic year mapping
        public function find($id){

            $institutionFeeTypeMappingRepository = new InstitutionFeeTypeMappingRepository();
            return $institutionFeeTypeMappingRepository->fetch($id);
            
        }

        // Insert academic year mapping
        public function add($feeTypeMappingData){

            $institutionFeeTypeMappingRepository = new InstitutionFeeTypeMappingRepository();
            $storeCount = 0;
            
            foreach($feeTypeMappingData->fee_type as $feeType) {
                $check = InstitutionFeeTypeMapping::where('id_institute', $feeTypeMappingData->institute)
                                            ->where('id_fee_type', $feeType)
                                            ->first();
>>>>>>> main
                if(!$check){

                    $data = array(
                        'id_institute' => $feeTypeMappingData->institute,
                        'id_fee_type' => $feeType,
                        'created_by' => Session::get('userId'),
                        'created_at' => Carbon::now()
                    );

                    $storeData = $institutionFeeTypeMappingRepository->store($data);
                    if($storeData){
                        $storeCount++;
                    }
                }
            }

            if($storeCount > 0){

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

<<<<<<< HEAD
        // Delete Institution feetype mapping
=======
        // Delete academic year mapping
>>>>>>> main
        public function delete($id){

            $institutionFeeTypeMappingRepository = new InstitutionFeeTypeMappingRepository();
            $feeMasterRepository = new FeeMasterRepository();
            $studentMappingRepository =  new StudentMappingRepository();

            $checkStudent = $studentMappingRepository->checkFeeTypeUsedInStudent($id);
            $checkFeeMaster = $feeMasterRepository->checkFeeTypeUsedInFeemaster($id);
<<<<<<< HEAD

            if($checkStudent || $checkFeeMaster){

                $signal = 'exist';
                $msg = "Can't delete. This fee type already used..!";

            }else{

=======
            if($checkStudent || $checkFeeMaster){
                $signal = 'exist';
                $msg = "Can't delete. This fee type already used..!";
            }else{
>>>>>>> main
                $institutionFeeTypeMapping = $institutionFeeTypeMappingRepository->delete($id);

                if($institutionFeeTypeMapping){
                    $signal = 'success';
                    $msg = 'Data deleted successfully!';
                }
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

<<<<<<< HEAD
        // Deleted Institution feetype mapping records
        public function getDeletedRecords(){
=======
        public function getDeletedRecords($allSessions){
>>>>>>> main

            $institutionFeeTypeMappingRepository = new InstitutionFeeTypeMappingRepository();
            $feeTypeRepository = new FeeTypeRepository();
            $institutionRepository = new InstitutionRepository();

<<<<<<< HEAD
            $institutionFeeTypeMapping = $institutionFeeTypeMappingRepository->allDeleted();
=======
            $institutionFeeTypeMapping = $institutionFeeTypeMappingRepository->allDeleted($allSessions);
>>>>>>> main
            $deletedFeeTypeDetails = array();

            foreach($institutionFeeTypeMapping as $key => $institutionFeeType){

                $feeType = $feeTypeRepository->fetch($institutionFeeType->id_fee_type);
<<<<<<< HEAD

=======
>>>>>>> main
                if($feeType){
                    $feeTypeName = $feeType->name;
                }else{
                    $feeTypeName = '-';
                }
<<<<<<< HEAD

=======
>>>>>>> main
                $institution = $institutionRepository->fetch($institutionFeeType->id_institute);

                $data = array(
                    'id' => $institutionFeeType->id,
                    'id_institute' => $institution->name,
                    'fee_type' => $feeTypeName,
                    'created_by' => $institutionFeeType->created_by,
                    'modified_by' => $institutionFeeType->modified_by,
                );
<<<<<<< HEAD

=======
>>>>>>> main
                array_push($deletedFeeTypeDetails, $data);
            }

            return $deletedFeeTypeDetails;
        }

<<<<<<< HEAD
        // Restore Institution feetype mapping records
=======
        // Restore homework records
>>>>>>> main
        public function restore($id){

            $institutionFeeTypeMappingRepository = new InstitutionFeeTypeMappingRepository();

            $institutionFeeType = $institutionFeeTypeMappingRepository->restore($id);

            if($institutionFeeType){
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
<<<<<<< HEAD
=======
?>
>>>>>>> main
