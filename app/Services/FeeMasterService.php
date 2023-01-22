<?php
    namespace App\Services;
    use App\Models\FeeMaster;
    use App\Repositories\FeeMasterRepository;
    use App\Repositories\FeeMappingRepository;
    use App\Repositories\FeeCategoryRepository;
    use App\Repositories\InstitutionFeeTypeMappingRepository;
    use App\Repositories\FeeHeadingRepository;
    use App\Repositories\FeeAssignSettingRepository;
    use App\Repositories\FeeInstallmentRepository;
    use App\Repositories\FeeCategorySettingRepository;
    use App\Repositories\CategoryFeeHeadingMasterRepository;
    use App\Repositories\FeeCollectionRepository;
    use App\Repositories\StudentMappingRepository;
    use App\Services\FeeAssignService;
    use App\Services\InstitutionStandardService;
    use App\Services\FeeBulkAssignService;
    use Carbon\Carbon;
    use Session;

    class FeeMasterService{       

<<<<<<< HEAD
        public function getFeeMasterData(){
=======
        public function getFeeMasterData($allSessions){
>>>>>>> main
            
            $feeMasterRepository = new FeeMasterRepository(); 
            $feeCategoryRepository = new FeeCategoryRepository();
            $institutionFeeTypeMappingRepository = new InstitutionFeeTypeMappingRepository();
            $institutionStandardService = new InstitutionStandardService();
            $output = array();
<<<<<<< HEAD
            $feeMasterDetails = $feeMasterRepository->getAll();
=======
            $feeMasterDetails = $feeMasterRepository->getAll($allSessions);
>>>>>>> main
            foreach($feeMasterDetails as $details) {
                $feeCategory = $feeCategoryRepository->fetch($details->id_fee_category);
                $feeType = $institutionFeeTypeMappingRepository->fetch($details->id_fee_type);
             
                $standard = $institutionStandardService->fetchStandardByUsingId($details->id_institution_standard);
                $output[] = array(
                    'id' => $details->id,
                    'feeCategory' => $feeCategory->name,
                    'feeType' => $feeType->name,
                    'installmentType' => $details->installment_type,
                    'standard' => $standard
                );
            }
            return $output;
        }

<<<<<<< HEAD
        public function getAllData(){
=======
        public function getAllData($allSessions){
>>>>>>> main
            
            $feeMappingRepository = new FeeMappingRepository();
            $institutionFeeTypeMappingRepository = new InstitutionFeeTypeMappingRepository();
            $institutionStandardService = new InstitutionStandardService();
            
<<<<<<< HEAD
            $feeCategory = $feeMappingRepository->getFeeCategory();
            $feeType = $institutionFeeTypeMappingRepository->getInstitutionFeetype();
            $standard = $institutionStandardService->fetchStandard();
=======
            $feeCategory = $feeMappingRepository->getFeeCategory($allSessions);
            $feeType = $institutionFeeTypeMappingRepository->getInstitutionFeetype($allSessions);
            $standard = $institutionStandardService->fetchStandard($allSessions);
>>>>>>> main

            $output = array(
                'feeCategory' => $feeCategory,
                'feeType' => $feeType,
                'standard' => $standard
            );
            return $output;
        }

        // Get Fee Heading Based On Fee Category
<<<<<<< HEAD
        public function allFeeData($request){
=======
        public function allFeeData($request, $allSessions){
>>>>>>> main
            $allData = array();

            $feeMappingRepository = new FeeMappingRepository();
            $feeMasterRepository = new FeeMasterRepository();
            $feeAssignSettingRepository = new FeeAssignSettingRepository();
            $feeInstallmentRepository = new FeeInstallmentRepository();
            $feeCategorySettingRepository = new FeeCategorySettingRepository();
            $categoryFeeHeadingMasterRepository = new CategoryFeeHeadingMasterRepository();
            $feeHeadingRepository = new FeeHeadingRepository();
            $feeCollectionRepository = new FeeCollectionRepository();

            $idFeeCategory = $request->feeCategory;
            $allStandards = $request->standard;
            $fee_type = $request->feeType;
            $installment_type = $request->instalmentType;

            $feeMasterStatus = "not-added";
            $feeCollectionStatus = "not-collected";

<<<<<<< HEAD
            $feeMasterCheck = $feeMasterRepository->getFeeMasterDetails($allStandards, $fee_type, $idFeeCategory);
=======
            $feeMasterCheck = $feeMasterRepository->getFeeMasterDetails($allStandards, $fee_type, $idFeeCategory, $allSessions);
>>>>>>> main

            
            if($feeMasterCheck && ($feeMasterCheck->installment_type != $installment_type)){
                
                $feeMasterStatus = "added";
            }

<<<<<<< HEAD
            $feeCollectionForMaster = $feeCollectionRepository->getCollectionForFeeMaster($allStandards, $fee_type, $idFeeCategory);
=======
            $feeCollectionForMaster = $feeCollectionRepository->getCollectionForFeeMaster($allStandards, $fee_type, $idFeeCategory, $allSessions);
>>>>>>> main
            if($feeCollectionForMaster){
                $feeCollectionStatus = 'collected';
                $allData['feeCollectionStatus'] = $feeCollectionStatus;
                return $allData;
            }

            if($installment_type === "HEADING_WISE"){

                foreach($allStandards as $standard){ 

<<<<<<< HEAD
                    $feeHeadings = $feeMappingRepository->fetchCategoryHeadingFromMapping($idFeeCategory);
=======
                    $feeHeadings = $feeMappingRepository->fetchCategoryHeadingFromMapping($idFeeCategory, $allSessions);
>>>>>>> main
                    // $feeHeadings = $feeHeadingRepository->fetchCategoryWiseHeading($idFeeCategory);

                    foreach($feeHeadings as $index => $feeHeading){         
                        
                        $allData['headingWise'][$index]['heading_id'] = $feeHeading->id;
                        $allData['headingWise'][$index]['heading_name'] = $feeHeading->display_name;

<<<<<<< HEAD
                        $getFeeMasterData = $feeMasterRepository->all($idFeeCategory, $standard, $fee_type, $installment_type);
=======
                        $getFeeMasterData = $feeMasterRepository->all($idFeeCategory, $standard, $fee_type, $installment_type, $allSessions);
>>>>>>> main
                        
                        if($getFeeMasterData){

                            $feeMasterId = $getFeeMasterData->id;
                            
                            $feeAssignSettingData = $feeAssignSettingRepository->all($feeMasterId, $feeHeading->id);
                            if($feeAssignSettingData){
                                
                                $allData['headingWise'][$index]['feeAssignId'] = $feeAssignSettingData['id'];
                                $allData['headingWise'][$index]['no_of_installment'] = $feeAssignSettingData['no_of_installment'];
                                $allData['headingWise'][$index]['installment_type'] = $feeAssignSettingData['installment_type'];
                                $allData['headingWise'][$index]['amount'] = $feeAssignSettingData['amount'];

                                $feeInstallmentData = $feeInstallmentRepository->all($feeAssignSettingData['id']);
                                if($feeInstallmentData){

                                    foreach($feeInstallmentData as $key => $installmentData){

                                        $allData['headingWise'][$index][$feeHeading->id][$key]['installment_id'] = $installmentData->id;
                                        $allData['headingWise'][$index][$feeHeading->id][$key]['installment_no'] = $installmentData->installment_no;
                                        $allData['headingWise'][$index][$feeHeading->id][$key]['installment_amount'] = $installmentData->amount;
                                        $allData['headingWise'][$index][$feeHeading->id][$key]['installment_percentage'] = $installmentData->percentage;
                                        $allData['headingWise'][$index][$feeHeading->id][$key]['due_date'] = Carbon::createFromFormat('Y-m-d', $installmentData->due_date)->format('d/m/Y');

                                    }
                                }
                            }else{
                                $allData['headingWise'][$index]['feeAssignId'] = "";
                                $allData['headingWise'][$index]['no_of_installment'] = 1;
                                $allData['headingWise'][$index]['installment_type'] = "";
                                $allData['headingWise'][$index]['amount'] = "";
                                $allData['headingWise'][$index][$feeHeading->id][0]['installment_id'] = "";
                                $allData['headingWise'][$index][$feeHeading->id][0]['installment_no'] = 1;
                                $allData['headingWise'][$index][$feeHeading->id][0]['installment_amount'] = "";
                                $allData['headingWise'][$index][$feeHeading->id][0]['installment_percentage'] = "";
                                $allData['headingWise'][$index][$feeHeading->id][0]['due_date'] = "";
                            }
                        }else{
                                $allData['headingWise'][$index]['feeAssignId'] = "";
                                $allData['headingWise'][$index]['no_of_installment'] = 1;
                                $allData['headingWise'][$index]['installment_type'] = "";
                                $allData['headingWise'][$index]['amount'] = "";
                                $allData['headingWise'][$index][$feeHeading->id][0]['installment_id'] = "";
                                $allData['headingWise'][$index][$feeHeading->id][0]['installment_no'] = 1;
                                $allData['headingWise'][$index][$feeHeading->id][0]['installment_amount'] = "";
                                $allData['headingWise'][$index][$feeHeading->id][0]['installment_percentage'] = "";
                                $allData['headingWise'][$index][$feeHeading->id][0]['due_date'] = "";
                            }
                        
                    }
                }
            }else{

                foreach($allStandards as $standard){ 

<<<<<<< HEAD
                    $getFeeMasterData = $feeMasterRepository->all($idFeeCategory, $standard, $fee_type, $installment_type);
=======
                    $getFeeMasterData = $feeMasterRepository->all($idFeeCategory, $standard, $fee_type, $installment_type, $allSessions);
>>>>>>> main
                    
                    if($getFeeMasterData){

                        $feeMasterId = $getFeeMasterData->id;

                        $feeCategorySettingData = $feeCategorySettingRepository->all($feeMasterId);
                        // dd($feeCategorySettingData);
                        if($feeCategorySettingData){

                            //$feeHeadings = $feeHeadingRepository->fetchCategoryWiseHeading($idFeeCategory);
<<<<<<< HEAD
                            $feeHeadings = $feeMappingRepository->fetchCategoryHeadingFromMapping($idFeeCategory);
=======
                            $feeHeadings = $feeMappingRepository->fetchCategoryHeadingFromMapping($idFeeCategory, $allSessions);
>>>>>>> main

                            foreach($feeHeadings as $index => $feeHeading){   

                                $allData['headingData'][$index]['heading_id'] = $feeHeading->id;
                                $allData['headingData'][$index]['heading_name'] = $feeHeading->display_name;

                                $getHeadingRelatedData = $categoryFeeHeadingMasterRepository->fetch($feeCategorySettingData->id, $feeHeading->id);
                                if($getHeadingRelatedData){
                                    $allData['headingData'][$index]['heading_amount'] = $getHeadingRelatedData->heading_amount;
                                    $allData['headingData'][$index]['collection_priority'] = $getHeadingRelatedData->collection_priority;
                                }else{
                                    $allData['headingData'][$index]['heading_amount'] = "";
                                    $allData['headingData'][$index]['collection_priority'] = "";
                                }                                  

                            }

                            // dd($feeCategorySettingData->id);
                            $allData['categoryData']['feeAssignId'] = $feeCategorySettingData->id;
                            $allData['categoryData']['no_of_installment'] = $feeCategorySettingData->no_of_installment;
                            $allData['categoryData']['installment_type'] = $feeCategorySettingData->installment_type;
                            $allData['categoryData']['collection_type'] = $feeCategorySettingData->collection_type;
                            $allData['categoryData']['amount'] = $feeCategorySettingData->amount;

                            $feeInstallmentData = $feeInstallmentRepository->all($feeCategorySettingData->id);
                            // dd($feeInstallmentData);
                            if(count($feeInstallmentData) > 0){

                                foreach($feeInstallmentData as $key => $installmentData){

                                    $allData['installmentData'][$key]['installment_id'] = $installmentData->id;
                                    $allData['installmentData'][$key]['installment_no'] = $installmentData->installment_no;
                                    $allData['installmentData'][$key]['installment_amount'] = $installmentData->amount;
                                    $allData['installmentData'][$key]['installment_percentage'] = $installmentData->percentage;
                                    $allData['installmentData'][$key]['due_date'] = Carbon::createFromFormat('Y-m-d', $installmentData->due_date)->format('d/m/Y');

                                }

                            }else{
                                $allData['categoryData']['feeAssignId'] = $feeCategorySettingData->id;
                                $allData['categoryData']['no_of_installment'] = $feeCategorySettingData->no_of_installment;
                                $allData['categoryData']['installment_type'] = $feeCategorySettingData->installment_type;
                                $allData['categoryData']['collection_type'] = $feeCategorySettingData->collection_type;
                                $allData['categoryData']['amount'] = $feeCategorySettingData->amount;
                                $allData['installmentData'][0]['installment_id'] = "";
                                $allData['installmentData'][0]['installment_no'] = 1;
                                $allData['installmentData'][0]['installment_amount'] = "";
                                $allData['installmentData'][0]['installment_percentage'] = "";
                                $allData['installmentData'][0]['due_date'] = "";
                            }

                        }else{
                            $allData['categoryData']['feeAssignId'] = $feeCategorySettingData->id;
                            $allData['categoryData']['no_of_installment'] = $feeCategorySettingData->no_of_installment;
                            $allData['categoryData']['installment_type'] = $feeCategorySettingData->installment_type;
                            $allData['categoryData']['collection_type'] = $feeCategorySettingData->collection_type;
                            $allData['categoryData']['amount'] = $feeCategorySettingData->amount;
                            $allData['installmentData'][0]['installment_id'] = "";
                            $allData['installmentData'][0]['installment_no'] = 1;
                            $allData['installmentData'][0]['installment_amount'] = "";
                            $allData['installmentData'][0]['installment_percentage'] = "";
                            $allData['installmentData'][0]['due_date'] = "";
                        }
                    }else{

                        // $feeHeadings = $feeHeadingRepository->fetchCategoryWiseHeading($idFeeCategory);

<<<<<<< HEAD
                        $feeHeadings = $feeMappingRepository->fetchCategoryHeadingFromMapping($idFeeCategory);
=======
                        $feeHeadings = $feeMappingRepository->fetchCategoryHeadingFromMapping($idFeeCategory, $allSessions);
>>>>>>> main


                        foreach($feeHeadings as $index => $feeHeading){   

                            $allData['headingData'][$index]['heading_id'] = $feeHeading->id;
                            $allData['headingData'][$index]['heading_name'] = $feeHeading->display_name;
                            $allData['headingData'][$index]['heading_amount'] = "";
                            $allData['headingData'][$index]['collection_priority'] = "";
                        
                        }
                        $allData['categoryData']['feeAssignId'] = "";
                        $allData['categoryData']['no_of_installment'] = 1;
                        $allData['categoryData']['installment_type'] = "";
                        $allData['categoryData']['collection_type'] = "PROPORTIONATE";
                        $allData['categoryData']['amount'] = "";
                        $allData['installmentData'][0]['installment_id'] = "";
                        $allData['installmentData'][0]['installment_no'] = 1;
                        $allData['installmentData'][0]['installment_amount'] = "";
                        $allData['installmentData'][0]['installment_percentage'] = "";
                        $allData['installmentData'][0]['due_date'] = "";
                    }
                }
            }
            $allData['feeMasterStatus'] = $feeMasterStatus;
            // dd($allData);
            return $allData;
        }

        // Insert & Update Fee Master
<<<<<<< HEAD
        public function add($feeMasterData){
=======
        public function add($feeMasterData, $allSessions){
>>>>>>> main

            $count=0;
            $feeMasterRepository = new FeeMasterRepository();
            $feeAssignSettingRepository = new FeeAssignSettingRepository();
            $feeInstallmentRepository = new FeeInstallmentRepository();
            $feeCategorySettingRepository = new FeeCategorySettingRepository();
            $categoryFeeHeadingMasterRepository = new categoryFeeHeadingMasterRepository();
            $studentMappingRepository =  new StudentMappingRepository();
            $feeAssignService = new FeeAssignService();

            $standards = explode(",", $feeMasterData['standards']);
            //dd($feeMasterData['standards']);

            foreach($standards as $standard){

<<<<<<< HEAD
                $getFeeMasterData = $feeMasterRepository->all($feeMasterData->feeCtegory, $standard, $feeMasterData->selectedFeeType, $feeMasterData->feeInstallment);
=======
                $getFeeMasterData = $feeMasterRepository->all($feeMasterData->feeCtegory, $standard, $feeMasterData->selectedFeeType, $feeMasterData->feeInstallment, $allSessions);
>>>>>>> main

                if(!$getFeeMasterData){

                    $data = array(
                        'id_institute' => $feeMasterData->idInstitute,
                        'id_academic_year' => $feeMasterData->idAcademic,
                        'id_fee_category' => $feeMasterData->feeCtegory,
                        'id_institution_standard' => $standard,
                        'id_fee_type' => $feeMasterData->selectedFeeType,
                        'installment_type' => $feeMasterData->feeInstallment,
                        'created_by' => Session::get('userId'),
                        'created_at' => Carbon::now()
                    );

                    $storeData = $feeMasterRepository->store($data);

                    $lastMasterId = $storeData->id;
                }else{
                    $lastMasterId = $getFeeMasterData->id;
                }

                if($lastMasterId){

                    $count++;

                    $lastInsertedId = $lastMasterId;

                    if($feeMasterData->feeInstallment === "HEADING_WISE"){

                        foreach($feeMasterData['fee_heading'] as $key => $feeHeading){

                            if($feeMasterData->amount[$key] != ''){

                                if($feeMasterData->fee_assignment_id[$key] == ''){

                                    $no_of_installment = 0;

                                    $settingData = array(
                                        'id_fee_master' => $lastInsertedId,
                                        'id_fee_heading' => $feeHeading,
                                        'no_of_installment' => $feeMasterData->noOfInstalment[$key],
                                        'installment_type' => $feeMasterData->feeInstallmentType[$key],
                                        'amount' => $feeMasterData->amount[$key],
                                        'created_by' => Session::get('userId'),
                                        'created_at' => Carbon::now()
                                    );

                                    $storeFeeAssignSetting = $feeAssignSettingRepository->store($settingData);

                                    $storeFeeAssignSettingId = $storeFeeAssignSetting->id;

                                }else{

                                    $storeFeeAssignSettingId = $feeMasterData->fee_assignment_id[$key];
                                    
                                    $model = $feeAssignSettingRepository->fetch($storeFeeAssignSettingId);
                                    
                                    $model->id_fee_master = $lastInsertedId;
                                    $model->id_fee_heading = $feeHeading;
                                    $model->no_of_installment = $feeMasterData->noOfInstalment[$key];
                                    $model->installment_type = $feeMasterData->feeInstallmentType[$key];
                                    $model->amount = $feeMasterData->amount[$key];
                                    $model->modified_by = Session::get('userId');
                                    $model->updated_at = Carbon::now();                                

                                    $storeFeeAssignSetting = $feeAssignSettingRepository->update($model);
                                }
                                
                                if($storeFeeAssignSettingId){

                                    $lastSettingId = $storeFeeAssignSettingId;

                                    if(count($feeMasterData['installment_amount']) > 0){

                                        $deleteExistingData = $feeInstallmentRepository->delete($lastSettingId);
                                        $no_of_installment = 0;
                                        foreach($feeMasterData['installment_amount'][$key] as $index=> $installmentAmount){

                                            if($installmentAmount != '' && $feeMasterData['dueDate'][$key][$index]!='' && $feeMasterData['percentage'][$key][$index]!=''){
                                        
                                                $no_of_installment = $no_of_installment + 1;

                                                $dueDate = $feeMasterData['dueDate'][$key][$index];
                                                $dueDate = Carbon::createFromFormat('d/m/Y', $dueDate)->format('Y-m-d');                                            

                                                $feeInstallmentData = array(
                                                    'id_fee_assign' => $lastSettingId,
                                                    'installment_no' => $no_of_installment,
                                                    'amount' => $installmentAmount,
                                                    'percentage' => $feeMasterData['percentage'][$key][$index],
                                                    'due_date' => $dueDate,
                                                    'created_by' => Session::get('userId'),
                                                    'created_at' => Carbon::now()
                                                );
                                                
                                                $storeFeeInstallment = $feeInstallmentRepository->store($feeInstallmentData);
                                        
                                            }
                                        }
                                    }
                                    
                                }
                            }
                        }
                        
                    }else{

                        //DATA MANIPULATION FOR tbl_fee_category_setting

                        $checkCatSetting = $feeCategorySettingRepository->fetch($lastInsertedId);
                        if(!$checkCatSetting){

                            $settingData = array(
                                'id_fee_master' => $lastInsertedId,
                                'no_of_installment' => $feeMasterData->noOfInstalment,
                                'installment_type' => $feeMasterData->feeInstallmentType,
                                'collection_type' => $feeMasterData->collectionType,
                                'amount' => $feeMasterData->total_amount,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );
                            $storeFeeCategorySetting = $feeCategorySettingRepository->store($settingData);

                            $categoryFeeSettingId = $storeFeeCategorySetting->id;

                        }else{

                            $categoryFeeSettingId = $checkCatSetting->id;

                            $model = $feeCategorySettingRepository->search($categoryFeeSettingId);
                            
                            $model->no_of_installment = $feeMasterData->noOfInstalment;
                            $model->installment_type = $feeMasterData->feeInstallmentType;
                            $model->collection_type = $feeMasterData->collectionType;
                            $model->amount = $feeMasterData->total_amount;
                            $model->modified_by = Session::get('userId');
                            $model->updated_at = Carbon::now();   
                            // dd($model);     
                            $storeFeeCategorySetting = $feeCategorySettingRepository->update($model);
                        }

                        if($categoryFeeSettingId){

                            $lastSettingId = $categoryFeeSettingId;

                            // MULTIPLE HEADING INSERTION 
                            $deleteExistingHeadings = $categoryFeeHeadingMasterRepository->delete($lastSettingId);

                            foreach($feeMasterData['fee_heading'] as $index => $feeHeading){

                                if($feeMasterData['amount'][$index] != ''){

                                    if($feeMasterData->collection_priority[$index] == ''){
                                        $collection_priority = 1;
                                    }else{
                                        $collection_priority = $feeMasterData->collection_priority[$index];
                                    }

                                    $dataHeadings = array(
                                        'id_category_setting' => $lastSettingId,
                                        'id_fee_heading' => $feeHeading,
                                        'heading_amount' => $feeMasterData->amount[$index],
                                        'collection_priority' => $collection_priority,
                                        'created_by' => Session::get('userId'),
                                        'created_at' => Carbon::now()
                                    );

                                    $storeHeadings = $categoryFeeHeadingMasterRepository->store($dataHeadings);
                                }

                            }

                            //INSERT CATEGORY INSTALLMENTS                            
                            if(count($feeMasterData['installment_amount']) > 0){

                                $deleteExistingData = $feeInstallmentRepository->delete($lastSettingId);
                                
                                $no_of_installment = 0;

                                for($key= 0; $key < $feeMasterData->noOfInstalment; $key++){  
                                     
                                    foreach($feeMasterData['installment_amount'][$key] as $index =>$installmentAmount){

                                        if($installmentAmount != '' && $feeMasterData['dueDate'][$key][$index]!='' && $feeMasterData['percentage'][$key][$index]!=''){
                                    
                                            $no_of_installment = $no_of_installment + 1;

                                            $dueDate = $feeMasterData['dueDate'][$key][$index];
                                            $dueDate = Carbon::createFromFormat('d/m/Y', $dueDate)->format('Y-m-d');                                            

                                            $feeInstallmentData = array(
                                                'id_fee_assign' => $lastSettingId,
                                                'installment_no' => $no_of_installment,
                                                'amount' => $installmentAmount,
                                                'percentage' => $feeMasterData['percentage'][$key][$index],
                                                'due_date' => $dueDate,
                                                'created_by' => Session::get('userId'),
                                                'created_at' => Carbon::now()
                                            );
                                            
                                            $storeFeeInstallment = $feeInstallmentRepository->store($feeInstallmentData);
                                    
                                        }
                                    }
                                }
                            }                            
                        }
                    }
                }

<<<<<<< HEAD
                $studentDetails = $studentMappingRepository->fetchStudentByStandardFeetype($standard, $feeMasterData->selectedFeeType);
              
=======
                $studentDetails = $studentMappingRepository->fetchStudentByStandardFeetype($standard, $feeMasterData->selectedFeeType, $allSessions);
>>>>>>> main
                if(count($studentDetails) > 0){
                    foreach($studentDetails as $student){
                        $assignFee = $feeAssignService->assignFeeForStudent($standard, $feeMasterData->selectedFeeType, $student->id_student);
                    }
                }
            }
<<<<<<< HEAD
=======

>>>>>>> main
            if($count){

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

<<<<<<< HEAD
        public function allCustomFeeData($request){
=======
        public function allCustomFeeData($request, $allSessions){
>>>>>>> main

            $allData = array();
            
            $feeMappingRepository = new FeeMappingRepository();
            $feeMasterRepository = new FeeMasterRepository();
            $feeAssignSettingRepository = new FeeAssignSettingRepository();
            $feeInstallmentRepository = new FeeInstallmentRepository();
            $feeCategorySettingRepository = new FeeCategorySettingRepository();
            $categoryFeeHeadingMasterRepository = new CategoryFeeHeadingMasterRepository();

            $idFeeCategory = $request->idFeeCategory;
            $standard = $request->idStandard;
            $fee_type = $request->feeType;
            $installment_type = $request->instalmentTypeId;

<<<<<<< HEAD
            $feeHeadings = $feeMappingRepository->fetchCategoryHeadingFromMapping($idFeeCategory);
=======
            $feeHeadings = $feeMappingRepository->fetchCategoryHeadingFromMapping($idFeeCategory, $allSessions);
>>>>>>> main

            foreach($feeHeadings as $index => $feeHeading){         
                
                $allData[$index]['heading_id'] = $feeHeading->id;
                $allData[$index]['heading_name'] = $feeHeading->display_name;

<<<<<<< HEAD
                $getFeeMasterData = $feeMasterRepository->all($idFeeCategory, $standard, $fee_type, $installment_type);
=======
                $getFeeMasterData = $feeMasterRepository->all($idFeeCategory, $standard, $fee_type, $installment_type, $allSessions);
>>>>>>> main
                
                if($getFeeMasterData){

                    $feeMasterId = $getFeeMasterData->id;
                    
                    $feeAssignSettingData = $feeAssignSettingRepository->all($feeMasterId, $feeHeading->id);
                    if($feeAssignSettingData){
                        
                        $allData[$index]['feeAssignId'] = $feeAssignSettingData['id'];
                        $allData[$index]['no_of_installment'] = $feeAssignSettingData['no_of_installment'];
                        $allData[$index]['installment_type'] = $feeAssignSettingData['installment_type'];
                        $allData[$index]['amount'] = $feeAssignSettingData['amount'];

                        $feeInstallmentData = $feeInstallmentRepository->all($feeAssignSettingData['id']);
                        if($feeInstallmentData){

                            foreach($feeInstallmentData as $key => $installmentData){

                                $allData[$index][$feeHeading->id][$key]['installment_id'] = $installmentData->id;
                                $allData[$index][$feeHeading->id][$key]['installment_no'] = $installmentData->installment_no;
                                $allData[$index][$feeHeading->id][$key]['installment_amount'] = $installmentData->amount;
                                $allData[$index][$feeHeading->id][$key]['installment_percentage'] = $installmentData->percentage;
                                $allData[$index][$feeHeading->id][$key]['due_date'] = Carbon::createFromFormat('Y-m-d', $installmentData->due_date)->format('d/m/Y');

                            }
                        }
                    }else{
                        $allData[$index]['feeAssignId'] = "";
                        $allData[$index]['no_of_installment'] = 1;
                        $allData[$index]['installment_type'] = "";
                        $allData[$index]['amount'] = "";
                        $allData[$index][$feeHeading->id][0]['installment_id'] = "";
                        $allData[$index][$feeHeading->id][0]['installment_no'] = 1;
                        $allData[$index][$feeHeading->id][0]['installment_amount'] = "";
                        $allData[$index][$feeHeading->id][0]['installment_percentage'] = "";
                        $allData[$index][$feeHeading->id][0]['due_date'] = "";
                    }
                }else{
                    $allData[$index]['feeAssignId'] = "";
                    $allData[$index]['no_of_installment'] = 1;
                    $allData[$index]['installment_type'] = "";
                    $allData[$index]['amount'] = "";
                    $allData[$index][$feeHeading->id][0]['installment_id'] = "";
                    $allData[$index][$feeHeading->id][0]['installment_no'] = 1;
                    $allData[$index][$feeHeading->id][0]['installment_amount'] = "";
                    $allData[$index][$feeHeading->id][0]['installment_percentage'] = "";
                    $allData[$index][$feeHeading->id][0]['due_date'] = "";
                }
                
            }
            return $allData;
        }

        // Delete Fee Master
        public function delete($id){

            $feeMasterRepository = new FeeMasterRepository();
            $feeBulkAssignService = new FeeBulkAssignService();
            $feeMasterDetails = $feeMasterRepository->fetch($id);
            $feeAssignedDetails = $feeBulkAssignService->findAssignedData($feeMasterDetails);
            if($feeAssignedDetails){

                $signal = 'success';
                $msg = 'Data can\'t be deleted since it is already assigned for student..!';

            }else {
                $feeMaster = $feeMasterRepository->delete($id);
                if($feeMaster){
                    $signal = 'success';
                    $msg = 'Fee Master deleted successfully!';
                }else {
                    $signal = 'failure';
                    $msg = 'Error in deleting.!';
                }
            }
    
            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );
    
            return $output;
        }


    }