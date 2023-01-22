<?php
    namespace App\Services;
    use App\Models\Institution;
    use App\Models\InstitutionType;
    use App\Models\Designation;
    use App\Models\User;
    use App\Models\InstitutionCourseMaster;
    use App\Repositories\InstitutionRepository;
    use App\Repositories\OrganizationRepository;
    use App\Repositories\InstitutionTypeRepository;
    use App\Repositories\InstitutionModuleRepository;
    use App\Repositories\InstitutionBoardRepository;
    use App\Repositories\ModuleRepository;
    use App\Repositories\BoardRepository;
    use App\Repositories\InstitutionPocRepository;
    use App\Repositories\UniversityRepository;
    use App\Repositories\DesignationRepository;
    use App\Services\InstitutionCourseMasterService;
    use App\Repositories\CourseMasterRepository;
    use App\Services\InstitutionModuleService;
    use App\Repositories\CourseRepository;
    use App\Repositories\StreamRepository;
    use App\Repositories\CombinationRepository;
    use App\Repositories\UserRepository;
    use Carbon\Carbon;
    use Session;
    use Hash;
    use Mail;
    use DB;
    use App\Mail\SendEmail;

    class InstituteService {

        // Get All Institution
        public function getAll(){
            $institutionTypeRepository = new InstitutionTypeRepository();
            $organizationRepository = new OrganizationRepository();
            $institutionRepository = new InstitutionRepository();
            $institutes = $institutionRepository->all();
            $arrayData = array();

            foreach($institutes as $key => $institute){

                $organization = $organizationRepository->fetch($institute->id_organization);
                //dd($organization);
                $institutionType = $institutionTypeRepository->fetch($institute->id_institution_type);

                $data = array(
                    'id' => $institute->id,
                    'organization' => $organization->name,
                    'instituteName' => $institute->name,
                    'instituteCode' => $institute->institution_code,
                    'city' => $institute->city,
                    'pincode' => $institute->pincode,
                    'address' => $institute->address,
                    'post_office' => $institute->post_office,
                    'country' => $institute->country,
                    'state' => $institute->state,
                    'district' => $institute->district,
                    'taluk' => $institute->taluk,
                    'office_email' => $institute->office_email,
                    'mobile_number' => $institute->mobile_number,
                    'landline_number' => $institute->landline_number,
                );
                array_push($arrayData, $data);
            }
            return $arrayData;
        }

        // Get Particular Institution
        public function find($id){

            $designationRepository = new DesignationRepository();
            $universityRepository = new UniversityRepository();
            $institutionModuleService = new InstitutionModuleService();
            $institutionPocRepository = new InstitutionPocRepository();
            $moduleRepository = new ModuleRepository();
            $boardRepository = new BoardRepository();
            $institutionBoardRepository = new InstitutionBoardRepository();
            $organizationRepository = new OrganizationRepository();
            $institutionRepository = new InstitutionRepository();

            DB::enableQueryLog();
            $institution = array();
            $pocData = array();
            $selectedBoard='';
            // dd($id);
            $institute = $institutionRepository->fetch($id);
            $pocs = $institutionPocRepository->fetch($id);

            foreach($pocs as $index => $poc){

                $pocData[$index] = $poc;
                $pocDesignationName = $designationRepository->fetch($poc->designation);

                $pocData[$index]['poc_designation_name'] = $pocDesignationName->name;
            }

            $organization = $organizationRepository->fetch($institute->id_organization);
            $university = $universityRepository->fetch($institute->university);
            $institutionBoards = $institutionBoardRepository->all($id);

            $institutionType = InstitutionType::find($institute->id_institution_type);

            foreach($institutionBoards as $board){
                $boardData = $boardRepository->fetch($board->id_board);
                if($boardData){
                    $selectedBoard .= $boardData->name.', ';
                }
            }

            $selectedBoard = substr($selectedBoard, 0,-2);

            $moduleDetails = array();
            $institutionModule = $institutionModuleService->getAllIds($id);

            foreach($institutionModule as $module){
                $moduleName = $moduleRepository->fetch($module);
                if($moduleName){
                    array_push($moduleDetails, $moduleName->display_name);
                }                
            }

            $moduleNames = implode(' , ', $moduleDetails);

            $institution = $institute;
            $institution['poc'] = $pocData;
            $institution['organization'] = $organization;
            $institution['university'] = $university;
            $institution['selectedBoard'] = $selectedBoard;
            $institution['institution_type'] = $institutionType;
            $institution['module_names'] = $moduleNames;

            return $institution;
        }

        // Insert Institution
        public function add($instituteData){
            
            $designationRepository = new DesignationRepository();
            $userRepository = new UserRepository();
            $institutionCourseMasterService = new InstitutionCourseMasterService();
            $institutionPocRepository = new InstitutionPocRepository();
            $moduleRepository = new ModuleRepository();
            $institutionModuleRepository = new InstitutionModuleRepository();
            $institutionRepository = new InstitutionRepository();

                $check = Institution::where('id_organization', $instituteData->organizationName)
                                    ->where('name', $instituteData->institutionName)->first();

                $institutionEmail = $institutionContact = $landlineNumber = $websiteUrl = $country = $state = $city = $entityId = $logoAttachment = $favIconAttachment = '';
                if(!$check){

                    if($instituteData->institutionEmail){
                        $institutionEmail = $instituteData->institutionEmail;
                    }

                    if($instituteData->institutionContact){
                        $institutionContact = $instituteData->institutionContact;
                    }

                    if($instituteData->landlineNumber){
                        $landlineNumber = $instituteData->landlineNumber;
                    }

                    if($instituteData->websiteUrl){
                        $url = preg_replace("(^https?://)", "", $instituteData->websiteUrl);
                        $webUrl = explode("/", $url);

                        $websiteUrl = $webUrl[0];
                    }

                    if($instituteData->country){
                        $country = $instituteData->country;
                    }

                    if($instituteData->state){
                        $state = $instituteData->state;
                    }

                    if($instituteData->city){
                        $city = $instituteData->city;
                    }

                    if($instituteData->entityId){
                        $entityId = $instituteData->entityId;
                    }

                    // S3 File Upload Function Call
                    if($instituteData->hasfile('institutionLogo')){
                        $logoAttachment = $institutionRepository->upload($instituteData->institutionLogo, $instituteData->organizationName, $instituteData->institutionName);
                    }

                    if($instituteData->hasfile('favIcon')){
                        $favIconAttachment = $institutionRepository->upload($instituteData->favIcon, $instituteData->organizationName, $instituteData->institutionName);
                    }

                    $data = array(
                        'id_organization' => $instituteData->organizationName,
                        'name' => $instituteData->institutionName,
                        'address' => $instituteData->institutionAddress,
                        'pincode' => $instituteData->pincode,
                        'post_office' => $instituteData->postOffice,
                        'country' => $instituteData->country,
                        'state' => $instituteData->state,
                        'district' => $instituteData->district,
                        'taluk' => $instituteData->taluk,
                        'city' => $instituteData->city,
                        'office_email' => $institutionEmail,
                        'mobile_number' => $institutionContact,
                        'landline_number' => $landlineNumber,
                        'website_url' => $websiteUrl,
                        'institution_logo' => $logoAttachment,
                        'fav_icon' => $favIconAttachment,
                        'sender_id' => $instituteData->senderId,
                        'entity_id' => $instituteData->entityId,
                        'area_partner_name' => $instituteData->areaPartnerName,
                        'area_partner_email' => $instituteData->areaPartnerEmail,
                        'area_partner_phone' => $instituteData->areaPartnerContact,
                        'zonal_partner_name' => $instituteData->zonalPartnerName,
                        'zonal_partner_email' => $instituteData->zonalPartnerEmail,
                        'zonal_partner_phone' => $instituteData->zonalPartnerContact,
                        'created_by' => Session::get('userId')
                    );

                    $storeData = $institutionRepository->store($data);

                    if($storeData) {

                        $lastInsertedId = $storeData->id;
                    
                        // Store Management Details
                        if($instituteData->management_name[0] !=''){

                            foreach($instituteData->management_name as $key => $managementName){

                                if($instituteData->management_designation[$key] !=''){

                                    $designation = $instituteData->management_designation[$key];
                                    $phoneNumber = $instituteData->management_phoneNumber[$key];
                                    $email = $instituteData->management_email_id[$key];

                                    $check= Designation::where('name', 'LIKE', $designation)->first();

                                    if($check){

                                        $designationId = $check->id;

                                    }else{

                                        $data = array(
                                            'name' => $designation,
                                            'created_by' => Session::get('userId'),
                                            'created_at' => Carbon::now()
                                        );
                                        $storeDesignation = $designationRepository->store($data);
                                        $designationId = $storeDesignation->id;

                                    }

                                    $data = array(
                                        'id_institute' => $lastInsertedId,
                                        'name' => $managementName,
                                        'designation' => $designationId,
                                        'email' => $email,
                                        'mobile_number' => $phoneNumber,
                                        'created_by' => Session::get('userId'),
                                        'created_at' => Carbon::now()
                                    );
                                
                                    $storeManagement = $institutionPocRepository->store($data);
                                }
                            }
                        }

                        $allModules = $moduleRepository->allModules();

                        $arrayModule = array();

                        // All Modules
                        foreach($allModules as $data){
                            array_push($arrayModule, $data->id);
                        }

                        // Selected Module Insert
                        if($instituteData->modules[0] !=''){

                            $arraySelectedModules = array();

                            foreach($instituteData->modules as $module){

                                $getAllSubModules = $moduleRepository->all($module);

                                if(in_array($module, $arrayModule)){

                                    array_push($arraySelectedModules, $module);

                                    $moduleData = array(
                                        'id_institution' => $lastInsertedId,
                                        'id_module' => $module,
                                        'display_order' => 1,
                                        'created_by' => Session::get('userId'),
                                        'created_at' => Carbon::now()
                                    );
                                    $storeModule = $institutionModuleRepository->store($moduleData);

                                    if(count($getAllSubModules) > 0){
                                        foreach($getAllSubModules as $subModule){

                                            if(in_array($subModule['id'], $arrayModule)){

                                                array_push($arraySelectedModules, $subModule['id']);
                                            
                                                $moduleData = array(
                                                    'id_institution' => $lastInsertedId,
                                                    'id_module' => $subModule['id'],
                                                    'id_parent' => $module,
                                                    'display_order' => 1,
                                                    'created_by' => Session::get('userId'),
                                                    'created_at' => Carbon::now()
                                                );
                                                $storeModule = $institutionModuleRepository->store($moduleData);
                                            }
                                        }
                                    }
                                }
                            }

                            $arrayDiffResult = array_diff($arrayModule, $arraySelectedModules);

                            foreach($arrayDiffResult as $data){

                                $module = array(
                                    'id_institution' => $lastInsertedId,
                                    'id_module' => $data,
                                    'display_order' => 1,
                                    'created_by' => Session::get('userId'),
                                    'deleted_at' => Carbon::now(),
                                    'created_at' => Carbon::now()
                                );
                                $storeModule = $institutionModuleRepository->store($module);
                            }
                        }

                        // Insert Institution Course Details
                        $storeInstitutionCourseData = $institutionCourseMasterService->store($instituteData, $lastInsertedId);

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

        // Update Institution
        public function update($instituteData, $id){

            $designationRepository = new DesignationRepository();
            $institutionCourseMasterService = new InstitutionCourseMasterService();
            $institutionPocRepository = new InstitutionPocRepository();
            $moduleRepository = new ModuleRepository();
            $institutionModuleRepository = new InstitutionModuleRepository();
            $institutionRepository = new InstitutionRepository();
            DB::enableQueryLog();
            $institutionEmail = $institutionContact = $landlineNumber = $websiteUrl = '';

            $check = Institution::where('id_organization', $instituteData->organizationName)
                                ->where('name', $instituteData->institutionName)
                                ->where('id', '!=', $id)->first();

            // dd(DB::getQueryLog());
            if(!$check){

                if($instituteData->institutionEmail){
                    $institutionEmail = $instituteData->institutionEmail;
                }

                if($instituteData->institutionContact){
                    $institutionContact = $instituteData->institutionContact;
                }

                if($instituteData->landlineNumber){
                    $landlineNumber = $instituteData->landlineNumber;
                }

                if($instituteData->websiteUrl){
                    $url = preg_replace("(^https?://)", "", $instituteData->websiteUrl);
                    $webUrl = explode("/", $url);

                    $websiteUrl = $webUrl[0];
                    
                }

                // S3 File Upload Function Call
                if($instituteData->hasfile('institutionLogo')){
                    $instituteLogo = $institutionRepository->upload($instituteData->institutionLogo, $instituteData->organizationName, $instituteData->institutionName);
                }else{
                    $instituteLogo = $instituteData->oldInstitutionLogo;
                }

                if($instituteData->hasfile('favIcon')){
                    $favIconAttachment = $institutionRepository->upload($instituteData->favIcon, $instituteData->organizationName, $instituteData->institutionName);
                }else{
                    $favIconAttachment = $instituteData->oldfavIcon;
                }

                //FETCH DATA FOR ID
                $model = $institutionRepository->fetch($id);

                $model['id_organization'] = $instituteData->organizationName;
                $model['name'] = $instituteData->institutionName;
                $model['address'] = $instituteData->institutionAddress;
                $model['pincode'] = $instituteData->pincode;
                $model['post_office'] = $instituteData->postOffice;
                $model['district'] = $instituteData->district;
                $model['taluk'] = $instituteData->taluk;
                $model['office_email'] = $institutionEmail;
                $model['mobile_number'] = $institutionContact;
                $model['landline_number'] = $landlineNumber;
                $model['website_url'] = $websiteUrl;
                $model['institution_logo'] = $instituteLogo;
                $model['fav_icon'] = $favIconAttachment;
                $model['area_partner_name'] = $instituteData->areaPartnerName;
                $model['area_partner_email'] = $instituteData->areaPartnerEmail;
                $model['area_partner_phone'] = $instituteData->areaPartnerContact;
                $model['zonal_partner_name'] = $instituteData->zonalPartnerName;
                $model['zonal_partner_email'] = $instituteData->zonalPartnerEmail;
                $model['zonal_partner_phone'] = $instituteData->zonalPartnerContact;
                $model['modified_by'] = Session::get('userId');

                $updateData = $institutionRepository->update($model);

                if($updateData){

                    // Store Management Details
                    if($instituteData->management_name[0] !=''){

                        foreach($instituteData->management_name as $key => $managementName){

                            if($instituteData->management_designation[$key] !=''){

                                $designation = $instituteData->management_designation[$key];
                                $phoneNumber = $instituteData->management_phoneNumber[$key];
                                $email = $instituteData->management_email_id[$key];
                                $pocId = $instituteData->management_id[$key];

                                $check= Designation::where('name', 'LIKE', $designation)->first();

                                if($check){

                                    $designationId = $check->id;

                                }else{

                                    $data = array(
                                        'name' => $designation,
                                        'created_by' => Session::get('userId'),
                                        'created_at' => Carbon::now()
                                    );
                                    $storeDesignation = $designationRepository->store($data);
                                    $designationId = $storeDesignation->id;

                                }

                                if($pocId!=''){

                                    $model = $institutionPocRepository->fetchPoc($pocId);

                                    $model->name = $managementName;
                                    $model->designation = $designationId;
                                    $model->email = $email;
                                    $model->mobile_number = $phoneNumber;
                                    $model->modified_by = Session::get('userId');
                                    $model->updated_at = Carbon::now();

                                    $response = $institutionPocRepository->update($model);

                                }else{

                                    $data = array(
                                        'id_institute' => $id,
                                        'name' => $managementName,
                                        'designation' => $designationId,
                                        'email' => $email,
                                        'mobile_number' => $phoneNumber,
                                        'created_by' => Session::get('userId'),
                                        'created_at' => Carbon::now()
                                    );
                                    $response = $institutionPocRepository->store($data);
                                }
                            }
                        }
                    }

                    $allModules = $moduleRepository->allModules();
                    // dd($allModules);
                    $arrayModule = array();

                    // All Modules
                    foreach($allModules as $data){
                        array_push($arrayModule, $data->id);
                    }
                    // dd($arrayModule);
                    // Selected Module Insert
                    if($instituteData->modules[0] !=''){

                        $arraySelectedModules = array();

                        foreach($instituteData->modules as $module){

                            $getAllSubModules = $moduleRepository->all($module);

                            if(in_array($module, $arrayModule)){

                                array_push($arraySelectedModules, $module);

                                $institutionModuleInfo = $institutionModuleRepository->fetchData($module, $id);
                                // dd($institutionModuleInfo);
                                if($institutionModuleInfo){
                                    if($institutionModuleInfo->trashed()) {

                                        $restoreSubModule = $institutionModuleRepository->restore($institutionModuleInfo->id);
                                        
                                    }else{
                                        $institutionModuleInfo->modified_by = Session::get('userId');
                                        $institutionModuleInfo->updated_at = Carbon::now();
                                        $storeModule = $institutionModuleRepository->update($institutionModuleInfo);
                                    }

                                    if(count($getAllSubModules) > 0){

                                        foreach($getAllSubModules as $subModule){

                                            array_push($arraySelectedModules, $subModule['id']);

                                            $checkExistence = $institutionModuleRepository->fetchData($subModule['id'], $id);
                                            if($checkExistence){
                                                if($checkExistence->trashed()) {

                                                    $restoreSubModule = $institutionModuleRepository->restore($checkExistence->id);

                                                }else{
                                                    
                                                    $checkExistence->modified_by = Session::get('userId');
                                                    $checkExistence->updated_at = Carbon::now();
                                                    $storeSubModule = $institutionModuleRepository->update($checkExistence);
                                                }
                                                
                                            }else{

                                                $moduleData = array(
                                                    'id_institution' => $id,
                                                    'id_module' => $subModule['id'],
                                                    'id_parent' => $module,
                                                    'display_order' => 1,
                                                    'created_by' => Session::get('userId'),
                                                    'created_at' => Carbon::now()
                                                );
                                                $storeSubModule = $institutionModuleRepository->store($moduleData);

                                            }                                            
                                            
                                        }
                                    }

                                }else{

                                    $moduleData = array(
                                        'id_institution' => $id,
                                        'id_module' => $module,
                                        'display_order' => 1,
                                        'created_by' => Session::get('userId'),
                                        'created_at' => Carbon::now()
                                    );
                                    $storeModule = $institutionModuleRepository->store($moduleData);

                                    if(count($getAllSubModules) > 0){
                                        foreach($getAllSubModules as $subModule){

                                            if(in_array($subModule['id'], $arrayModule)){

                                                array_push($arraySelectedModules, $subModule['id']);
                                            
                                                $moduleData = array(
                                                    'id_institution' => $id,
                                                    'id_module' => $subModule['id'],
                                                    'id_parent' => $module,
                                                    'display_order' => 1,
                                                    'created_by' => Session::get('userId'),
                                                    'created_at' => Carbon::now()
                                                );
                                                $storeModule = $institutionModuleRepository->store($moduleData);
                                            }
                                        }
                                    }
                                }                                
                            }
                        }

                        $arrayDiffResult = array_diff($arrayModule, $arraySelectedModules);
                        // dd($arrayDiffResult);
                        foreach($arrayDiffResult as $data){

                            $checkExistence = $institutionModuleRepository->fetchData($data, $id);
                            if($checkExistence){

                                $deleteSubModule = $institutionModuleRepository->deleteInstituteData($data, $id);
                                
                            }else{

                                $module = array(
                                    'id_institution' => $id,
                                    'id_module' => $data,
                                    'display_order' => 1,
                                    'created_by' => Session::get('userId'),
                                    'deleted_at' => Carbon::now(),
                                    'created_at' => Carbon::now()
                                );
                                $storeModule = $institutionModuleRepository->store($module);

                            }
                            
                        }
                    }

                    $updateInstitutionCourseData = $institutionCourseMasterService->update($instituteData, $id);

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

        // Delete Institution
        public function delete($id){

            $userRepository = new UserRepository();
            $institutionRepository = new InstitutionRepository();
            $module = $institutionRepository->delete($id);

            if($module){

                $user = $userRepository->deleteAllUsers($id);

                $signal = 'success';
                $msg = 'Data deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );
            return $output;
        }

        public function getInstitutionDetails($idOrganization){

            $institutionRepository = new InstitutionRepository();
            $institutionDetails = array();
            
            $institutes = $institutionRepository->fetchInstitution($idOrganization);

            foreach($institutes as $key => $institute){

                $institutionData = array(
                    'value' => $institute['id'],
                    'label' => $institute['name']
                );
                array_push($institutionDetails, $institutionData);
            }

            return $institutionDetails;
        }

        public function getBoardDetails($idInstitution){
            $boardRepository = new BoardRepository();
            $institutionBoardRepository = new InstitutionBoardRepository();
            $boardDetails = '';
            $instituteBoard = $institutionBoardRepository->all($idInstitution);

            foreach($instituteBoard as $data=>$idBoard){
                $board = $boardRepository->fetch($idBoard->id_board);
                $boardDetails.='<option value="'.$board->id.'" >'.$board->name.'</option>';
            }

            return $boardDetails;
        }

        // Get Designation
        public function getDesignationdetails($term){

            $designationRepository = new DesignationRepository();
            $designationDetails = array();
            $instituteDesignation = $designationRepository->fetchDesignation($term);

            foreach($instituteDesignation as $des){
                $designation = $des->name.'@'.$des->id;
                array_push($designationDetails,  $designation);
            }

            return $designationDetails;
        }

        public function getInstitutionCourseData($idInstitution){
            $courseMasterRepository = new CourseMasterRepository();
            $combinationRepository = new CombinationRepository();
            $streamRepository = new StreamRepository();
            $courseRepository = new CourseRepository();
            $institutionCourseMasterService = new InstitutionCourseMasterService();
            $institutionTypeRepository = new InstitutionTypeRepository();
            $institutionCourseData = array();
            $institutionTypeDetails = array();
            $courseDetails = array();
            $streamDetails = array();
            $combinationDetails = array();

            $institutionCourseDetails = $institutionCourseMasterService->getInstitutionCourseDetails($idInstitution);

            foreach($institutionCourseDetails as $index => $details){

                $courseData = $details->course;
                $boardUniversityData = $details->board_university;
                $institutionTypeData = $details->institution_type;
                $streamData = $details->stream;

                $institutionArray = array();
                $courseArray = array();
                $streamArray = array();
                $combinationArray = array();

                $institutionType = $courseMasterRepository->fetchInstitutionType($boardUniversityData);

                foreach($institutionType as  $data){
                    $institutionTypeDetail = $institutionTypeRepository->fetch($data->institution_type);
                    array_push($institutionArray, $institutionTypeDetail);
                }

                $course = $courseMasterRepository->fetchCourse($institutionTypeData, $boardUniversityData);

                foreach($course as  $data){
                    $courseDetail = $courseRepository->fetch($data->course);
                    array_push($courseArray, $courseDetail);
                }

                $stream = $courseMasterRepository->fetchStream($institutionTypeData, $boardUniversityData, $courseData);

                foreach($stream as  $data){
                    $streamDetail = $streamRepository->fetch($data->stream);
                    array_push($streamArray, $streamDetail);
                }

                $allCombinations =$courseMasterRepository->fetchCombination($institutionTypeData, $boardUniversityData, $courseData, $streamData);

                foreach($allCombinations as $comb){
                    $allCombinations = explode(",", $comb->combination);
                }

                foreach($allCombinations as  $combinationId){
                    $combination = $combinationRepository->fetch($combinationId);
                    array_push($combinationArray, $combination);
                }

                $institutionTypeDetails[$index] = $institutionArray;
                $courseDetails[$index] =  $courseArray;
                $streamDetails[$index] =  $streamArray;
                $combinationDetails[$index] =  $combinationArray;
            }

            $institutionCourseData['institutionTypeDetails'] = $institutionTypeDetails;
            $institutionCourseData['courseDetails'] = $courseDetails;
            $institutionCourseData['streamDetails'] = $streamDetails;
            $institutionCourseData['combinationDetails'] =  $combinationDetails;

           return $institutionCourseData;
        }

        public function getDeletedRecords(){
            $institutionTypeRepository = new InstitutionTypeRepository();
            $organizationRepository = new OrganizationRepository();
            $institutionRepository = new InstitutionRepository();

            $institutes = $institutionRepository->allDeleted();
            $arrayData = array();

            foreach($institutes as $key => $institute){

                $organization = $organizationRepository->fetch($institute->id_organization);
                $institutionType = $institutionTypeRepository->fetch($institute->id_institution_type);

                $data = array(
                    'id' => $institute->id,
                    'organization' => $organization->name,
                    'instituteName' => $institute->name,
                    'instituteCode' => $institute->institution_code,
                    'city' => $institute->city,
                    'pincode' => $institute->pincode,
                    'address' => $institute->address,
                    'post_office' => $institute->post_office,
                    'country' => $institute->country,
                    'state' => $institute->state,
                    'district' => $institute->district,
                    'taluk' => $institute->taluk,
                    'office_email' => $institute->office_email,
                    'mobile_number' => $institute->mobile_number,
                    'landline_number' => $institute->landline_number,
                );
                array_push($arrayData, $data);
            }

            return $arrayData;
        }

        public function restore($id){

            $userRepository = new UserRepository();
            $institutionRepository = new InstitutionRepository();
            $organizationRepository = new OrganizationRepository();

            $deletedInstitutionData = $institutionRepository->findDeletedInstitution($id);
            $organizationData = $organizationRepository->fetch($deletedInstitutionData->id_organization);

            if($organizationData){

                $institution = $institutionRepository->restore($id);

                if($institution){

                    $user = $userRepository->restoreAllUsers($id);

                    $signal = 'success';
                    $msg = 'Data restored successfully!';

                }else{
                    $signal = 'failure';
                    $msg = 'Data deletion is failed!';
                }

            }else{
                $signal = 'invalid';
                $msg = 'Organization is not available';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function restoreAll(){

            $institutionRepository = new InstitutionRepository();
            $organization = $institutionRepository->restoreAll();

            if($organization){
                $signal = 'success';
                $msg = 'Data restored successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function fetchTableColumns(){

            $columnArray = array();
            $columnArray = ['logo'];
            $allColumns = DB::getSchemaBuilder()->getColumnListing('tbl_institution');

            $unNeededColumns = ['id', 'institution_logo', 'id_organization', 'sender_id', 'entity_id', 'area_partner_name', 'area_partner_email', 'area_partner_phone', 'zonal_partner_name', 'zonal_partner_email', 'zonal_partner_phone', 'created_by', 'modified_by', 'deleted_at', 'created_at', 'updated_at'];
            $neededColumns = array_diff($allColumns, $unNeededColumns);
            array_push($neededColumns, ...$columnArray);
            return $neededColumns;

        }

        public function findTokenData($idInstitution){

            $institutionRepository = new InstitutionRepository();
            $institution = $institutionRepository->fetch($idInstitution);
            $institution['logo'] = $institution->institution_logo;

            return $institution;
        }
    }
?>
