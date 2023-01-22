<?php
    namespace App\Services;

    use App\Models\Batch;
    use App\Models\BatchDetail;
    use App\Models\BatchStudent;
    use App\Repositories\BatchRepository;
    use App\Repositories\BatchDetailRepository;
    use App\Repositories\BatchStudentRepository;
    use App\Repositories\StudentRepository;
    use App\Repositories\StudentMappingRepository;
    use App\Services\InstitutionStandardService;
    use Carbon\Carbon;
    use Session;
    use DB;

    class BatchService {

        public function getStandard($allSessions){

            $institutionStandardService = new InstitutionStandardService();

            $institutionStandards = $institutionStandardService->fetchStandard($allSessions);
            return $institutionStandards;
        }

        // Get batch number based on standard
        public function getBatchNoByStandard($standardId, $allSessions){

            $batchRepository = new BatchRepository();

            $batch = $batchRepository->fetchBatchNoByStandard($standardId, $allSessions);
            return $batch;
        }

        // Get all students
        // public function getStudentsData($request){

        //     $batchRepository = new BatchRepository();
        //     $studentMappingRepository = new StudentMappingRepository();
        //     $studentRepository = new StudentRepository();

        //     $batch = $batchRepository->all();
        //     $standard = $request->get('standard');

        //     $studentData = $studentMappingRepository->fetchInstitutionStandardStudents($standard);
        //     return $studentData;
        // }

        // Get all students
        public function getStudentsData($request){

            $batchRepository = new BatchRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $studentRepository = new StudentRepository();

            $arrayData = array();
            $batch = $batchRepository->all($allSessions);
            $standard = $request->get('standard');

            $studentData = $studentMappingRepository->fetchInstitutionStandardStudents($standard, $allSessions);
            foreach($studentData as $key => $data){
                //dd($data);
                $studentName = $studentMappingRepository->getFullName($data->name, $data->middle_name, $data->last_name);

                $studentDetails = array(
                    'id_student'=>$data->id_student,
                    'UID'=>$data->egenius_uid,
                    'name'=>$studentName,
                );

                array_push($arrayData, $studentDetails);
            }

            return $arrayData;
        }

        // Get particular batch
        public function getBatchStudent($standard, $allSessions){

            $batchRepository = new BatchRepository();
            $batchStudentRepository = new BatchStudentRepository();

            $batchDetail = array();
            $batchInfo = $batchRepository->getBatchDetails($standard, $allSessions);

            foreach($batchInfo as $key => $batchData){

                $batchDetail[$key]['id'] = $batchData['id'];
                $batchDetail[$key]['name'] = $batchData['batch_name'];
                $studentArray = array();

                $batchStudent = $batchStudentRepository->getBatchStudent($batchData['id']);

                foreach($batchStudent as $index => $student){
                    array_push($studentArray, $student['id_student']);
                }

                $batchDetail[$key]['student'] = $studentArray;
            }

            return $batchDetail;
        }

        // Insert and update batch
        public function add($batchData, $allSessions){

            $batchRepository = new BatchRepository();
            $batchDetailRepository = new BatchDetailRepository();
            $batchStudentRepository = new BatchStudentRepository();
            $studentMappingRepository = new StudentMappingRepository();

            $institutionId = $batchData->id_institute;
            $academicYear = $batchData->id_academic;

            $standard = $batchData->standardId;
            $batchNo = $batchData->no_of_batch;

            $studentData = $studentMappingRepository->fetchInstitutionStandardStudents($standard, $allSessions);

            $check = Batch::where('id_standard', $standard)
                            ->where('id_institute', $institutionId)
                            ->where('id_academic', $academicYear)->first();

            if(!$check){

                $data = array(
                    'id_institute' => $institutionId,
                    'id_academic' => $academicYear,
                    'id_standard' => $standard,
                    'no_of_batch' => $batchNo,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );

                $storeData = $batchRepository->store($data);
                $idBatch = $storeData->id;

            }else{

                $idBatch = $check->id;

                $updateData = $batchRepository->fetch($idBatch);
                $updateData->no_of_batch = $batchNo;
                $updateData->modified_by = Session::get('userId');
                $updateData->updated_at = Carbon::now();

                $update = $batchRepository->update($updateData);
            }

            if($idBatch){

                // Batch detail
                $batchDetailId = array();
                $getAllBatchDetail = $batchDetailRepository->all($idBatch);

                if($getAllBatchDetail){

                    foreach($getAllBatchDetail as $batchDetail){
                        array_push($batchDetailId, $batchDetail['id']);
                    }
                }

                $arrayDifferent = array_diff($batchDetailId, $batchData->batchId);
                // dd($arrayDifferent);
                foreach($batchData->batchId as $key => $batch){

                    if($batch != ""){

                        if(!in_array($batch, $arrayDifferent)){

                            $idBatchDetail = $batch;
                            $updateBatchDetail = $batchDetailRepository->fetch($idBatchDetail);
                            // dd($idBatchDetail);
                            $updateBatchDetail->batch_name = $batchData->batch[$key];
                            $updateBatchDetail->modified_by = Session::get('userId');
                            $updateBatchDetail->updated_at = Carbon::now();

                            $updateBatchDetailData = $batchDetailRepository->update($updateBatchDetail);
                        }

                        // Delete extra data
                        $updateBatchDetailData = $batchDetailRepository->delete($arrayDifferent);

                    }else{

                        $data = array(
                            'id_batch' => $idBatch,
                            'batch_name' => $batchData->batch[$key],
                            'created_by' => Session::get('userId'),
                            'created_at' => Carbon::now()
                        );

                        $storeBatchDetail = $batchDetailRepository->store($data);
                        $idBatchDetail = $storeBatchDetail->id;
                    }

                    if($idBatchDetail){

                        // Student batch
                        foreach($studentData as $student){

                            $check = BatchStudent::where('id_student', $student['id_student'])->first();

                            if(!$check){

                                if(isset($batchData->student[$student['id_student']])){

                                    if($batchData->student[$student['id_student']] == 'batch_'.$key){

                                        $data = array(
                                            'id_batch_detail' => $idBatchDetail,
                                            'id_student' => $student['id_student'],
                                            'created_by' => Session::get('userId'),
                                            'created_at' => Carbon::now()
                                        );

                                        $storeStudentBatch = $batchStudentRepository->store($data);
                                    }
                                }

                            }else{

                                $id = $check->id;
                                $getData = $batchStudentRepository->fetch($id);

                                if(isset($batchData->student[$student['id_student']])){

                                    if($batchData->student[$student['id_student']] == 'batch_'.$key){

                                        $getData->id_batch_detail = $idBatchDetail;
                                        $getData->modified_by = Session::get('userId');
                                        $getData->updated_at = Carbon::now();
                                        $storeStudentBatch = $batchStudentRepository->update($getData);

                                    }
                                }
                            }
                        }
                    }
                }

                $signal = 'success';
                $msg = 'Data inserted successfully!';

            }else{
                $signal = 'failure';
                $msg = 'Error inserting data!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
?>
