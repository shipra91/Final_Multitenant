<?php
    namespace App\Services;
    use App\Models\FeeAssign;
    use App\Services\StudentService;
    use App\Repositories\FeeMasterRepository;
    use App\Repositories\FeeCategoryRepository;
    use App\Repositories\FeeTypeRepository;
    use App\Repositories\FeeAssignRepository;
    use App\Repositories\FeeAssignDetailRepository;
    use App\Repositories\CustomFeeAssignHeadingRepository;
    use App\Repositories\CustomFeeAssignmentRepository;
    use App\Repositories\FeeCategorySettingRepository;
    use App\Repositories\FeeAssignSettingRepository;
    use App\Repositories\StudentMappingRepository;
    use App\Repositories\FeeMappingRepository;
    use App\Services\FeeAssignDetailService;
    use App\Repositories\FeeSettingRepository;
    use App\Repositories\FeeInstallmentRepository;
    use Carbon\Carbon;
    use Session;

    class FeeBulkAssignService{       

        public function getAllData($standardId, $allSessions){
            $feeMasterRepository = new FeeMasterRepository();
            $feeCategoryRepository = new FeeCategoryRepository();
            $feeTypeRepository = new FeeTypeRepository();

            $allCategory = array();
            $allCategoryData = array();
            
            $feeCategories = $feeMasterRepository->standardFeeCategory($standardId, $allSessions);
            
            foreach($feeCategories as $feeCategory => $value){
                
                $categoryData = $feeCategoryRepository->fetch($feeCategory);

                $allCategory = array(
                    'id' => $feeCategory,
                    'name' => $categoryData->name
                );
                array_push($allCategoryData, $allCategory);
            }
            return $allCategoryData;
        }

        public function getStudentData($request, $allSessions){
            
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $studentService = new StudentService();
            $customFeeAssignHeadingRepository = new CustomFeeAssignHeadingRepository();
            $feeAssignDetailService = new FeeAssignDetailService();            
            $feeAssignRepository = new FeeAssignRepository();
            $classStudents = array();

            $allStudents = $studentService->fetchStandardStudents($request->standard);

            foreach($allStudents as $key => $student){
                $classStudents[$key] = $student;

                $concessionResponse = $feeAssignDetailService->fetchFeeConcession($request->feeCategory, $student['id_student']);
                
                $totalConcessionAmount = $feeAssignDetailService->fetchFeeConcessionAmount($student['id_student']);

                $additionResponse = $feeAssignDetailService->fetchFeeAddition($request->feeCategory, $student['id_student']);
                
                $totalAdditionAmount = $feeAssignDetailService->fetchFeeAdditionAmount($student['id_student']);
                
                $studentFeeTypeData = $feeAssignRepository->fetchStudentFeeType($student['id_student']);
                if($studentFeeTypeData){
                    $studentFeeType = $studentFeeTypeData->id_fee_type;
                }else{
                    $studentFeeType = '';
                }

                $data = array(
                    'id_student' => $student['id_student'],
                    'id_institution_standard' => $request->standard,
                    'id_fee_category' => $request->feeCategory,
                    'id_institute' => $institutionId,
                    'id_academic_year' => $academicId,
                    'id_fee_type' => $studentFeeType
                );
                
                // $studentAmount = $customFeeAssignHeadingRepository->getAmount($data);
                $studentAmount = $feeAssignRepository->getAssignedAmount($data);
                if($studentAmount){
                    $totalAmount = $studentAmount->total_amount;
                }else{
                    $totalAmount = 0;
                }
                
                $classStudents[$key]['totalAmount'] = $totalAmount;  
                $classStudents[$key]['totalConcessionAmount'] = $totalConcessionAmount;  
                $classStudents[$key]['totalAdditionAmount'] = $totalAdditionAmount;                
                $classStudents[$key]['concession'] = $concessionResponse;              
                $classStudents[$key]['addition'] = $additionResponse;
                $classStudents[$key]['feeType'] = $studentFeeType;
            }
            return $classStudents;
        }

        public function add($request, $allSessions){

            $institutionId = $request->id_institute;
            $academicId = $request->id_academic;
            $organizationId = $request->organization;

            $idFeeCategory = $request->idFeeCategory;
            $idStandard = $request->idStudentStandard;

            $customFeeAssignmentRepository = new CustomFeeAssignmentRepository();
            $feeMasterRepository =  new FeeMasterRepository();
            $feeAssignRepository = new FeeAssignRepository();
            $feeAssignDetailRepository = new FeeAssignDetailRepository();
            $feeCategorySettingRepository = new FeeCategorySettingRepository();
            $feeAssignSettingRepository = new FeeAssignSettingRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $feeSettingRepository = new FeeSettingRepository();
            $feeInstallmentRepository = new FeeInstallmentRepository();

            $concessionApprovalRequired = '';
            $concessionApproved = 'PENDING';
            $feeSettingDetails = $feeSettingRepository->all($allSessions);
            if($feeSettingDetails) {
                $concessionApprovalRequired = $feeSettingDetails->concession_approval_required;
            }
          
            if($concessionApprovalRequired == 'NO') {
                $concessionApproved = 'YES';
            }
           
            foreach($request->idStudent as $index => $student){

                $check = $feeAssignRepository->checkFeeAssignAvaibility($idStandard, $student, $idFeeCategory, $request->feeType[$index], $allSessions);

                //if fee type is custom
                if($request->feeType[$index] == 'CUSTOM'){

                    if(!$check){
                        $data = array(
                            'id_organization' => $organizationId,
                            'id_institution' => $institutionId,
                            'id_academic' => $academicId,
                            'id_standard' => $idStandard,
                            'id_student' => $student,
                            'id_fee_category' => $idFeeCategory,
                            'id_fee_type' => $request->feeType[$index],
                            'total_amount' => $request->total_fee[$index],
                            'no_of_installment' => 0,
                            'installment_type' => 'HEADING_WISE',
                            'created_by' => Session::get('userId'),
                            'created_at' => Carbon::now()
                        );                        

                        $storeFeeAssign = $feeAssignRepository->store($data);
                        $feeAssign_id = $storeFeeAssign->id;

                    }else{

                        $feeAssign_id = $check->id;

                        $feeAssignData = $feeAssignRepository->fetch($feeAssign_id);

                        $feeAssignData->total_amount = $request->total_fee[$index];
                        $storeFeeAssign = $feeAssignRepository->update($feeAssignData);
                    }

                    if($feeAssign_id){

                        //ASSIGN FEE
                        $action_type = 'ASSIGNED';
                        $customFeeResponse = $customFeeAssignmentRepository->fetch($student, $idStandard, $idFeeCategory, $institutionId, $academicId);

                        $deleteAllAssignedFee = $feeAssignDetailRepository->delete($feeAssign_id, $action_type);

                        foreach($customFeeResponse as $feeResponse){

                            $assignedFeeData = array(
                                'id_fee_assign' => $feeAssign_id,
                                'id_fee_heading' => $feeResponse->id_heading,
                                'action_type' => 'ASSIGNED',
                                'installment_no' => $feeResponse->installment_no,
                                'amount' => $feeResponse->amount,
                                'due_date' => $feeResponse->due_date,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );

                            $storeFeeAssign = $feeAssignDetailRepository->store($assignedFeeData);

                        }

                        //ASSIGN CONCESSION
                        $action_type = 'CONCESSION';
                        // $deleteConcession = $feeAssignDetailRepository->delete($feeAssign_id, $action_type);                        

                        foreach($request->concession_heading_id[$student] as $key => $concession_heading){ 
                            
                            if($request->concession_amount[$student][$key] != ''){

                                $concessionFeeData = array(
                                    'id_fee_assign' => $feeAssign_id,
                                    'id_fee_heading' => $concession_heading,
                                    'action_type' => 'CONCESSION',
                                    'installment_no' => 0,
                                    'amount' => $request->concession_amount[$student][$key],
                                    'remark' => $request->concession_remark[$student][$key],
                                    'concession_approved' => $concessionApproved,
                                    'created_by' => Session::get('userId'),
                                    'created_at' => Carbon::now()
                                );

                                $storeFeeAssign = $feeAssignDetailRepository->store($concessionFeeData);
                            }
                        }

                        //ASSIGN ADDITION
                        $action_type = 'ADDITION';
                        // $deleteConcession = $feeAssignDetailRepository->delete($feeAssign_id, $action_type);                        

                        foreach($request->addition_heading_id[$student] as $key => $addition_heading){                                  
                            if($request->addition_amount[$student][$key] != ''){

                                $additionFeeData = array(
                                    'id_fee_assign' => $feeAssign_id,
                                    'id_fee_heading' => $addition_heading,
                                    'action_type' => 'ADDITION',
                                    'installment_no' => 0,
                                    'amount' => $request->addition_amount[$student][$key],
                                    'remark' => $request->addition_remark[$student][$key],
                                    'created_by' => Session::get('userId'),
                                    'created_at' => Carbon::now()
                                );

                                $storeFeeAssign = $feeAssignDetailRepository->store($additionFeeData);
                            }
                        }

                    }
                    
                }else{

                    $getFeeMasterData = $feeMasterRepository->getInstallmentType($idFeeCategory, $idStandard, $request->feeType[$index], $allSessions);

                    if($getFeeMasterData){

                        if($getFeeMasterData->installment_type == 'HEADING_WISE'){
                            $noOfInstallment = 0;

                            //FEE ASSIGN                    
                            if(!$check){
                                $data = array(
                                    'id_organization' => $organizationId,
                                    'id_institution' => $institutionId,
                                    'id_academic' => $academicId,
                                    'id_standard' => $idStandard,
                                    'id_student' => $student,
                                    'id_fee_category' => $idFeeCategory,
                                    'id_fee_type' => $request->feeType[$index],
                                    'total_amount' => $request->total_fee[$index],
                                    'no_of_installment' => $noOfInstallment,
                                    'installment_type' => $getFeeMasterData->installment_type,
                                    'created_by' => Session::get('userId'),
                                    'created_at' => Carbon::now()
                                );                        

                                $storeFeeAssign = $feeAssignRepository->store($data);
                                $feeAssign_id = $storeFeeAssign->id;

                            }else{

                                $feeAssign_id = $check->id;

                                $feeAssignData = $feeAssignRepository->fetch($feeAssign_id);

                                $feeAssignData->total_amount = $request->total_fee[$index];
                                $storeFeeAssign = $feeAssignRepository->update($feeAssignData);
                            }  

                            if($feeAssign_id){

                                //ASSIGN FEE
                                $action_type = 'ASSIGNED';

                                $headingFeeResponse = $feeInstallmentRepository->fetchHeadingDetail($getFeeMasterData->id, $allSessions);
                                // dd($headingFeeResponse);

                                $deleteAllAssignedFee = $feeAssignDetailRepository->delete($feeAssign_id, $action_type);

                                foreach($headingFeeResponse as $feeResponse){

                                    $assignedFeeData = array(
                                        'id_fee_assign' => $feeAssign_id,
                                        'id_fee_heading' => $feeResponse->id_fee_heading,
                                        'action_type' => 'ASSIGNED',
                                        'installment_no' => $feeResponse->installment_no,
                                        'amount' => $feeResponse->amount,
                                        'due_date' => $feeResponse->due_date,
                                        'created_by' => Session::get('userId'),
                                        'created_at' => Carbon::now()
                                    );

                                    $storeFeeAssign = $feeAssignDetailRepository->store($assignedFeeData);

                                }                                

                                //ASSIGN CONCESSION
                                $action_type = 'CONCESSION';
                                // $deleteConcession = $feeAssignDetailRepository->delete($feeAssign_id, $action_type);                        

                                foreach($request->concession_heading_id[$student] as $key => $concession_heading){ 
                                    if($request->concession_amount[$student][$key] != ''){

                                        $concessionFeeData = array(
                                            'id_fee_assign' => $feeAssign_id,
                                            'id_fee_heading' => $concession_heading,
                                            'action_type' => 'CONCESSION',
                                            'installment_no' => 0,
                                            'amount' => $request->concession_amount[$student][$key],
                                            'remark' => $request->concession_remark[$student][$key],
                                            'concession_approved' => $concessionApproved,
                                            'created_by' => Session::get('userId'),
                                            'created_at' => Carbon::now()
                                        );

                                        $storeFeeAssign = $feeAssignDetailRepository->store($concessionFeeData);
                                    }
                                }

                                //ASSIGN ADDITION
                                $action_type = 'ADDITION';
                                // $deleteConcession = $feeAssignDetailRepository->delete($feeAssign_id, $action_type);                        

                                foreach($request->addition_heading_id[$student] as $key => $addition_heading){                                  
                                    if($request->addition_amount[$student][$key] != ''){

                                        $additionFeeData = array(
                                            'id_fee_assign' => $feeAssign_id,
                                            'id_fee_heading' => $addition_heading,
                                            'action_type' => 'ADDITION',
                                            'installment_no' => 0,
                                            'amount' => $request->addition_amount[$student][$key],
                                            'remark' => $request->addition_remark[$student][$key],
                                            'created_by' => Session::get('userId'),
                                            'created_at' => Carbon::now()
                                        );

                                        $storeFeeAssign = $feeAssignDetailRepository->store($additionFeeData);
                                    }
                                }
                            }
                        }else{

                            $installmentData = $feeCategorySettingRepository->fetch($getFeeMasterData->id);
                            $noOfInstallment = $installmentData->no_of_installment;

                            //FEE ASSIGN                    
                            if(!$check){
                                $data = array(
                                    'id_organization' => $organizationId,
                                    'id_institution' => $institutionId,
                                    'id_academic' => $academicId,
                                    'id_standard' => $idStandard,
                                    'id_student' => $student,
                                    'id_fee_category' => $idFeeCategory,
                                    'id_fee_type' => $request->feeType[$index],
                                    'total_amount' => $request->total_fee[$index],
                                    'no_of_installment' => $noOfInstallment,
                                    'installment_type' => $getFeeMasterData->installment_type,
                                    'created_by' => Session::get('userId'),
                                    'created_at' => Carbon::now()
                                );                        

                                $storeFeeAssign = $feeAssignRepository->store($data);
                                $feeAssign_id = $storeFeeAssign->id;

                            }else{

                                $feeAssign_id = $check->id;

                                $feeAssignData = $feeAssignRepository->fetch($feeAssign_id);

                                $feeAssignData->total_amount = $request->total_fee[$index];
                                $storeFeeAssign = $feeAssignRepository->update($feeAssignData);
                            }  

                            if($feeAssign_id){

                                //ASSIGN FEE
                                $action_type = 'ASSIGNED';

                                $headingFeeResponse = $feeCategorySettingRepository->fetchCategoryDetail($getFeeMasterData->id, $allSessions);
                                // dd($headingFeeResponse);
                                $deleteAllAssignedFee = $feeAssignDetailRepository->delete($feeAssign_id, $action_type);

                                foreach($headingFeeResponse as $feeResponse){

                                    $assignedFeeData = array(
                                        'id_fee_assign' => $feeAssign_id,
                                        'id_fee_heading' => $feeResponse->id_fee_heading,
                                        'action_type' => 'ASSIGNED',
                                        'installment_no' => $feeResponse->installment_no,
                                        'amount' => $feeResponse->amount,
                                        'due_date' => $feeResponse->due_date,
                                        'created_by' => Session::get('userId'),
                                        'created_at' => Carbon::now()
                                    );

                                    $storeFeeAssign = $feeAssignDetailRepository->store($assignedFeeData);

                                }

                                                             

                                //ASSIGN CONCESSION
                                $action_type = 'CONCESSION';
                                // $deleteConcession = $feeAssignDetailRepository->delete($feeAssign_id, $action_type);                        

                                foreach($request->concession_heading_id[$student] as $key => $concession_heading){ 
                                    
                                    if($request->concession_amount[$student][$key] != ''){

                                        $concessionFeeData = array(
                                            'id_fee_assign' => $feeAssign_id,
                                            'id_fee_heading' => $concession_heading,
                                            'action_type' => 'CONCESSION',
                                            'installment_no' => 0,
                                            'amount' => $request->concession_amount[$student][$key],
                                            'remark' => $request->concession_remark[$student][$key],
                                            'concession_approved' => $concessionApproved,
                                            'created_by' => Session::get('userId'),
                                            'created_at' => Carbon::now()
                                        );

                                        $storeFeeAssign = $feeAssignDetailRepository->store($concessionFeeData);
                                    }
                                }

                                //ASSIGN ADDITION
                                $action_type = 'ADDITION';
                                // $deleteConcession = $feeAssignDetailRepository->delete($feeAssign_id, $action_type);                        

                                foreach($request->addition_heading_id[$student] as $key => $addition_heading){                                  
                                    if($request->addition_amount[$student][$key] != ''){

                                        $additionFeeData = array(
                                            'id_fee_assign' => $feeAssign_id,
                                            'id_fee_heading' => $addition_heading,
                                            'action_type' => 'ADDITION',
                                            'installment_no' => 0,
                                            'amount' => $request->addition_amount[$student][$key],
                                            'remark' => $request->addition_remark[$student][$key],
                                            'created_by' => Session::get('userId'),
                                            'created_at' => Carbon::now()
                                        );

                                        $storeFeeAssign = $feeAssignDetailRepository->store($additionFeeData);
                                    }
                                }
                            }
                        }
                    } 
                }

                //UPDATE FEE TYPE OF STUDENT IN STUDENT MAPPING TABLE
                $studentMappingData = $studentMappingRepository->fetch($student, $allSessions);
                
                $studentMappingData->id_fee_type = $request->feeType[$index];
                $studentMappingData->modified_by = Session::get('userId');
                $studentMappingData->updated_at = Carbon::now();

                $mappingResponse = $studentMappingRepository->updateStudentMapping($studentMappingData);

            }

            $signal = 'success';
            $msg = 'Data inserted successfully!';
            
            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );
            return $output;
        }

        //GET STUDENT CONCESSION ASSIGNED
        public function studentConcessionAssignedDetails($idStudent, $allSessions){
            $feeAssignRepository = new FeeAssignRepository();
            $feeCategoryRepository = new FeeCategoryRepository();
            $feeMappingRepository = new FeeMappingRepository();
            $studentMappingRepository = new StudentMappingRepository();

            $studentConcessionDetails = array();
            $concessionDetails = $feeAssignRepository->studentConcessionAssignedDetails($idStudent, $allSessions);
            $studentDetails = $studentMappingRepository->fetchStudent($idStudent, $allSessions);
            foreach($concessionDetails as $index => $details) {
                
                $studentConcessionDetails[$index]['uid'] = $studentDetails->egenius_uid;
                $studentConcessionDetails[$index]['name']= $studentDetails->name;
                $feeCategoryDetails = $feeCategoryRepository->fetch($details->id_fee_category);
                $feeHeadingDetails = $feeMappingRepository->fetch($details->id_fee_heading);
                $studentConcessionDetails[$index]['id_fee_assign_details'] = $details->id;
                $studentConcessionDetails[$index]['fee_category'] = $feeCategoryDetails->name;
                $studentConcessionDetails[$index]['heading_name'] = $feeHeadingDetails->display_name;
                $studentConcessionDetails[$index]['concession_amount'] = $details->amount;
                $studentConcessionDetails[$index]['concession_approval_status'] = $details->concession_approved;
            }
            return $studentConcessionDetails;
        }

        public function approveConcession($data, $id) {
            $feeAssignDetailRepository = new FeeAssignDetailRepository();
            $details = $feeAssignDetailRepository->fetch($id);
            $details->concession_approved = 'YES';
            $details->concession_approved_date = date('Y-m-d');
            $details->modified_by = Session::get('userId');
            $details->updated_at = Carbon::now();

            $approve = $feeAssignDetailRepository->update($details);
            if($approve){
                $signal = 'success';
                $msg = 'Concession approved successfully!';

            }else{
                $signal = 'failure';
                $msg = 'Error in approving!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function rejectConcession($data, $id) {
            $feeAssignDetailRepository = new FeeAssignDetailRepository();
            $details = $feeAssignDetailRepository->fetch($id);
            $details->concession_approved = 'NO';
            $details->concession_rejected_date = date('Y-m-d');
            $details->concession_rejected_reason = $data->rejection_reason;
            $details->modified_by = Session::get('userId');
            $details->updated_at = Carbon::now();

            $approve = $feeAssignDetailRepository->update($details);
            if($approve){
                $signal = 'success';
                $msg = 'Concession Rejected successfully!';

            }else{
                $signal = 'failure';
                $msg = 'Error in rejecting!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function findAssignedData($feeMasterDetails) {
            
            $feeAssignRepository = new FeeAssignRepository();

            $idInstitutionStandard = $feeMasterDetails->id_institution_standard;
            $idFeeCategory = $feeMasterDetails->id_fee_category;
            $idFeeType = $feeMasterDetails->id_fee_type;
            $installmentType = $feeMasterDetails->installment_type;

            $assignedFeeData = $feeAssignRepository->getAssignedData($idInstitutionStandard, $idFeeCategory, $idFeeType, $installmentType);
            return $assignedFeeData;
        }


    }
?>


