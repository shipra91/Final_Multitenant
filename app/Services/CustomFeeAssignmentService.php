<?php 
    namespace App\Services;
    use App\Models\CustomFeeAssignment;
    use App\Models\CustomFeeAssignHeading;
    use App\Models\CustomFeeAssignHeadingInstallment;
    use App\Services\CustomFeeAssignmentService;
    use App\Repositories\CustomFeeAssignmentRepository;
    use App\Repositories\CustomFeeAssignHeadingRepository;
    use App\Repositories\CustomFeeAssignHeadingInstallmentRepository;
    use App\Repositories\StudentMappingRepository;
    use Carbon\Carbon;
    use Session;

    class CustomFeeAssignmentService {

        public function add($request){

            $studentMappingRepository = new StudentMappingRepository();
            $customFeeAssignmentRepository = new CustomFeeAssignmentRepository();
            $customFeeAssignHeadingRepository = new CustomFeeAssignHeadingRepository();
            $customFeeAssignHeadingInstallmentRepository = new CustomFeeAssignHeadingInstallmentRepository();
            
            $check = CustomFeeAssignment::where('id_institute', $request->institute_id)->where('id_academic_year', $request->academic_id)->where('id_fee_category', $request->custom_fee_category_id)->where('id_institution_standard', $request->custom_standard_id)->where('id_student', $request->custom_student_id)->first();
            if(!$check){
              
                $data = array(
                    'id_institute' => $request->institute_id, 
                    'id_academic_year' => $request->academic_id,
                    'id_fee_category' => $request->custom_fee_category_id,
                    'id_institution_standard' => $request->custom_standard_id,
                    'id_student' => $request->custom_student_id, 
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );
                $storeData = $customFeeAssignmentRepository->store($data); 
                $assignmentId = $storeData->id;
                
            }else{
                $assignmentId = $check->id;
            }

            if($assignmentId) {                    

                foreach($request->fee_heading as $index => $fee_heading){

                    if($request->amount[$index] != ''){

                        $checkHeading = CustomFeeAssignHeading::where('id_custom_fee_assign', $assignmentId)->where('id_heading', $fee_heading)->first();
                        if(!$checkHeading){

                                $data = array(
                                    'id_custom_fee_assign' => $assignmentId,
                                    'id_heading' => $fee_heading,
                                    'amount' => $request->amount[$index],
                                    'no_of_installment' => $request->noOfInstalment[$index],
                                    'installment_type' => $request->feeInstallmentType[$index],
                                    'created_by' => Session::get('userId'),
                                    'created_at' => Carbon::now()
                                );

                                $storeHeadingData = $customFeeAssignHeadingRepository->store($data); 
                                $idCustomFeeAssignHeading = $storeHeadingData->id;

                        }else{

                                $customFeeAssignHeadingData = $customFeeAssignHeadingRepository->fetch($checkHeading->id);

                                $customFeeAssignHeadingData->amount = $request->amount[$index];
                                $customFeeAssignHeadingData->no_of_installment = $request->noOfInstalment[$index];
                                $customFeeAssignHeadingData->installment_type = $request->feeInstallmentType[$index];
                                $customFeeAssignHeadingData->modified_by = Session::get('userId');
                                $customFeeAssignHeadingData->updated_at = Carbon::now();

                                $storeHeadingData = $customFeeAssignHeadingRepository->update($customFeeAssignHeadingData); 

                                $idCustomFeeAssignHeading = $checkHeading->id;
                                // dd('hello',$idCustomFeeAssignHeading);
                        }

                        if($idCustomFeeAssignHeading){

                            $storeHeadingInstallmentData = $customFeeAssignHeadingInstallmentRepository->delete($idCustomFeeAssignHeading);
                                
                            foreach($request->installment_amount[$index] as $key => $installmentAmount){
                                    
                                if($installmentAmount != '' && $request->dueDate[$index][$key] != '' && $request->percentage[$index][$key]){
                                    
                                    $dueDate = $request->dueDate[$index][$key];
                                    $dueDate = Carbon::createFromFormat('d/m/Y', $dueDate)->format('Y-m-d');
                                            
                                    $data = array(

                                        'id_custom_fee_assign_heading' => $idCustomFeeAssignHeading,
                                        'installment_no' => $key + 1,
                                        'amount' => $installmentAmount,
                                        'percentage' => $request->percentage[$index][$key],
                                        'due_date' => $dueDate,
                                        'created_by' => Session::get('userId'),
                                        'created_at' => Carbon::now()

                                    );

                                    $storeHeadingInstallmentData = $customFeeAssignHeadingInstallmentRepository->store($data);                                         
                                        
                                }
                            }
                        }
                    }
                }
                
                //UPDATING STUDENT FEE TYPE

                $studentMappingData = $studentMappingRepository->fetch($request->custom_student_id);
                $studentMappingData->id_fee_type = $request->custom_fee_type;
                $studentMappingData->modified_by = Session::get('userId');
                $studentMappingData->updated_at = Carbon::now();

                $mappingResponse = $studentMappingRepository->updateStudentMapping($studentMappingData);

                $signal = 'success';
                $msg = 'Data inserted successfully!';

            }else{

                $signal = 'failure';
                $msg = 'Error inserting data!';

            } 

            // }else{
            //     $signal = 'exist';
            //     $msg = 'This data already exists!';
            // }
            
            //GET ALL THE PARAMS
            $studentData = array(
                'id_institute' => $request->institute_id, 
                'id_academic_year' => $request->academic_id,
                'id_fee_category' => $request->custom_fee_category_id,
                'id_institution_standard' => $request->custom_standard_id,
                'id_student' => $request->custom_student_id
            );
            
            $sqlSumFeeAssign = $customFeeAssignHeadingRepository->getAmount($studentData); 
            if($sqlSumFeeAssign->amount){
                $totalAmount = $sqlSumFeeAssign->amount;
            }else{
                $totalAmount = 0;
            }                    
            
            $output = array(
                'signal' => $signal,
                'message' => $msg,
                'totalAmount' => $totalAmount
            );

            return $output;
        }
    }
?>