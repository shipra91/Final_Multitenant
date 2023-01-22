<?php
    namespace App\Services;
    use App\Models\Staff;
    use App\Repositories\StaffRepository;
    use App\Repositories\BloodGroupRepository;
    use App\Repositories\GenderRepository;
    use App\Repositories\DepartmentRepository;
    use App\Repositories\DesignationRepository;
    use App\Repositories\RoleRepository;
    use App\Repositories\StaffCategoryRepository;
    use App\Repositories\StaffSubCategoryRepository;
    use App\Repositories\NationalityRepository;
    use App\Repositories\ReligionRepository;
    use App\Repositories\CategoryRepository;
    use App\Repositories\StaffCustomDetailsRepository;
    use App\Repositories\CustomFieldRepository;
    use App\Repositories\StaffSubjectMappingRepository;
    use App\Repositories\StaffBoardRepository;
    use App\Repositories\StaffFamilyDetailRepository;
    use App\Repositories\StandardSubjectStaffMappingRepository;
    use App\Repositories\InstitutionSubjectRepository;
    use App\Repositories\BoardRepository;
    use App\Repositories\SubjectRepository;
    use App\Repositories\LoginOtpRepository;
    use App\Repositories\OrganizationRepository;
    use App\Services\UploadService;
    use Carbon\Carbon;
    use Session;
    use DB;

    class StaffService {

        // Get all staff
        public function getAll($request, $allSessions){

            $categoryRepository = new CategoryRepository();
            $religionRepository = new ReligionRepository();
            $nationalityRepository = new NationalityRepository();
            $staffSubCategoryRepository = new StaffSubCategoryRepository();
            $staffCategoryRepository = new StaffCategoryRepository();
            $roleRepository = new RoleRepository();
            $designationRepository = new DesignationRepository();
            $departmentRepository = new DepartmentRepository();
            $genderRepository = new GenderRepository();
            $bloodGroupRepository = new BloodGroupRepository();
            $staffRepository = new StaffRepository();
            $staff = $staffRepository->all($request, $allSessions);
            $arrayData = array();

            foreach($staff as $key => $staffData){

                $arrayData[$key] = $staffData;
                $arrayData[$key]['name'] = $staffRepository->getFullName($staffData['name'], $staffData['middle_name'], $staffData['last_name']);

                $bloodGroup = $gender = $designation = $department = $role = $staffCategory = $staffSubCategory = $nationality = $religion = $category = '';

                if($staffData->id_blood_group){
                    $bloodGroupData = $bloodGroupRepository->fetch($staffData->id_blood_group);
                    if($bloodGroupData){
                        $bloodGroup = $bloodGroupData->name;
                    }
                }

                if($staffData->id_gender){
                    $genderData = $genderRepository->fetch($staffData->id_gender);
                    if($genderData){
                        $gender = $genderData->name;
                    }
                }

                if($staffData->id_department){
                    $departmentData = $departmentRepository->fetch($staffData->id_department);
                    if($departmentData){
                        $department = $departmentData->name;
                    }
                }

                if($staffData->id_designation){
                    $designationData = $designationRepository->fetch($staffData->id_designation);
                    if($designationData){
                        $designation = $designationData->name;
                    }
                }

                if($staffData->id_role){
                    $roleData = $roleRepository->fetch($staffData->id_role);
                    if($roleData){
                        $role = $roleData->display_name;
                    }
                }

                if($staffData->id_staff_category){
                    $staffCategoryData = $staffCategoryRepository->fetch($staffData->id_staff_category);
                    if($staffCategoryData){
                        $staffCategory = $staffCategoryData->name;
                    }
                }

                if($staffData->id_staff_subcategory){
                    $staffSubCategoryData = $staffSubCategoryRepository->fetch($staffData->id_staff_subcategory);
                    if($staffSubCategoryData){
                        $staffSubCategory = $staffSubCategoryData->name;
                    }
                }

                if($staffData->id_nationality){
                    $nationalityData = $nationalityRepository->fetch($staffData->id_nationality);
                    if($nationalityData){
                        $nationality = $nationalityData->name;
                    }
                }

                if($staffData->id_religion){
                    $religionData = $religionRepository->fetch($staffData->id_religion);
                    if($religionData){
                        $religion = $religionData->name;
                    }
                }

                if($staffData->id_caste_category){
                    $categoryData = $categoryRepository->fetch($staffData->id_caste_category);
                    if($categoryData){
                        $category = $categoryData->name;
                    }
                }

                $arrayData[$key]['department'] = $department;
                $arrayData[$key]['designation'] = $designation;
                $arrayData[$key]['bloodGroup'] = $bloodGroup;
                $arrayData[$key]['gender'] = $gender;
                $arrayData[$key]['role'] = $role;
                $arrayData[$key]['staffCategory'] = $staffCategory;
                $arrayData[$key]['staffSubCategory'] = $staffSubCategory;
                $arrayData[$key]['nationality'] = $nationality;
                $arrayData[$key]['religion'] = $religion;
                $arrayData[$key]['category'] = $category;
            }
            // dd($arrayData);
            return $arrayData;
        }

        // Get super admin data by service
        public function getAllSuperAdmin($idService){

            $roleRepository = new RoleRepository();
            $staffRepository = new StaffRepository();
            $genderRepository = new GenderRepository();
            $loginOtpRepository = new LoginOtpRepository();
            $organizationRepository = new OrganizationRepository();

            $allStaff = Staff::where('created_by', $idService)->get();
            $arrayData = array();

            foreach($allStaff as $key => $staffData){

                $organizationData = $organizationRepository->fetch($staffData->id_organization);
                $organizationName = $organizationData->name;

                $existingUser = $loginOtpRepository->existingUser($staffData->primary_contact_no);
                if($existingUser){
                    $editElligibility = 'NO';
                }else{
                    $editElligibility = 'YES';
                }
                $arrayData[$key] = $staffData;
                $role = '';

                if($staffData->id_gender){

                    $genderData = $genderRepository->fetch($staffData->id_gender);

                    if($genderData){
                        $gender = $genderData->name;
                    }
                }

                if($staffData->id_role){

                    $roleData = $roleRepository->fetch($staffData->id_role);

                    if($roleData){
                        $role = $roleData->display_name;
                    }
                }

                $arrayData[$key]['role'] = $role;
                $arrayData[$key]['organization_name'] = $organizationName;
                $arrayData[$key]['gender'] = $gender;
                $arrayData[$key]['editElligibility'] = $editElligibility;
            }
            // dd($arrayData);
            return $arrayData;
        }

        // Get particular staff
        public function find($id, $allSessions){

            $institutionSubjectRepository = new InstitutionSubjectRepository();
            $subjectRepository = new SubjectRepository();
            $staffFamilyDetailRepository = new StaffFamilyDetailRepository();
            $staffBoardRepository = new StaffBoardRepository();
            $staffSubjectMappingRepository = new StaffSubjectMappingRepository();
            $categoryRepository = new CategoryRepository();
            $religionRepository = new ReligionRepository();
            $nationalityRepository = new NationalityRepository();
            $staffSubCategoryRepository = new StaffSubCategoryRepository();
            $staffCategoryRepository = new StaffCategoryRepository();
            $roleRepository = new RoleRepository();
            $designationRepository = new DesignationRepository();
            $departmentRepository = new DepartmentRepository();
            $genderRepository = new GenderRepository();
            $bloodGroupRepository = new BloodGroupRepository();
            $staffRepository = new StaffRepository();
            $boardRepository = new BoardRepository();
            $staffData = array();
            $staffFamilyData = array();
            $selectedBoard = "";
            $selectedSubject = "";

            $bloodGroup = $gender = $department = $designation = $role = $staffCategory = $staffSubCategory = $nationality = $religion = $castCategory ='';

            $staffFamilyDetails = $staffFamilyDetailRepository->all($id);

            foreach($staffFamilyDetails as $index => $staffFamilyDetail){
                $staffFamilyData[$index] = $staffFamilyDetail;
            }

            $staff = $staffRepository->fetch($id);

            if($staff){

                $fullname = $staffRepository->getFullName($staff['name'], $staff['middle_name'], $staff['last_name']);
                $bloodGroup = $bloodGroupRepository->fetch($staff->id_blood_group);
                $gender = $genderRepository->fetch($staff->id_gender);
                $department = $departmentRepository->fetch($staff->id_department);
                $designation = $designationRepository->fetch($staff->id_designation);
                $role = $roleRepository->fetch($staff->id_role);
                $staffCategory = $staffCategoryRepository->fetch($staff->id_staff_category);
                $staffSubCategory = $staffSubCategoryRepository->fetch($staff->id_staff_subcategory);
                $nationality = $nationalityRepository->fetch($staff->id_nationality);
                $religion = $religionRepository->fetch($staff->id_religion);
                $cast = $categoryRepository->fetch($staff->id_caste_category);

                $staffBoards = $staffBoardRepository->all($id);

                foreach($staffBoards as $staffBoard){
                    //$selectedBoard = $staffBoard->board;
                    $selectedBoards = explode(",", $staffBoard->board);

                    $selectedBoard = '';

                    foreach($selectedBoards as $board){
                        $boardDetails = $boardRepository->fetch($board);
                        $selectedBoard .= $boardDetails->name.', ';
                    }

                    $selectedBoard = substr($selectedBoard, 0,-2);
                }

                if($bloodGroup){
                    $bloodGroup= $bloodGroup->name;
                }

                if($gender){
                    $gender= $gender->name;
                }

                if($department){
                    $department= $department->name;
                }

                if($designation){
                    $designation= $designation->name;
                }

                if($role){
                    $role= $role->display_name;
                }

                if($staffCategory){
                    $staffCategory= $staffCategory->name;
                }

                if($staffSubCategory){
                    $staffSubCategory= $staffSubCategory->name;
                }

                if($nationality){
                    $nationality= $nationality->name;
                }

                if($religion){
                    $religion= $religion->name;
                }

                if($cast){
                    $castCategory= $cast->name;
                }

                $subjectMappings = $staffSubjectMappingRepository->all($id);

                $selectedSubject = array();

                foreach($subjectMappings as $index => $subjectMapping){

                    $subjectId = $subjectMapping->id_subject;
                    $subject = $institutionSubjectRepository->find($subjectId);
                    $subjectCount =  $institutionSubjectRepository->findCount($subject->id_subject, $allSessions);

                    if($subject){

                        if(sizeof($subjectCount) == 2){
                            $display_name = $subject['display_name'].'-'.$subject['subject_type'];
                        }else{
                            $display_name = $subject['display_name'];
                        }

                        $selectedSubject[$index] = $display_name;

                    }else{
                        $selectedSubject[$index] = '';
                    }
                }

                $selectedSubject = implode(', ', $selectedSubject);

                $staffData = $staff;
                $staffData['bloodGroup'] = $bloodGroup;
                $staffData['gender'] = $gender;
                $staffData['department'] = $department;
                $staffData['designation'] = $designation;
                $staffData['role'] = $role;
                $staffData['staffCategory'] = $staffCategory;
                $staffData['staffSubcategory'] = $staffSubCategory;
                $staffData['nationality'] = $nationality;
                $staffData['religion'] = $religion;
                $staffData['cast'] = $castCategory;
                $staffData['familyDetails'] = $staffFamilyData;
                $staffData['selectedBoard'] = $selectedBoard;
                $staffData['selectedSubject'] = $selectedSubject;
                $staffData['fullname'] = $fullname;
            }
            //dd($staffData);
            return $staffData;
        }

        // Staff data
        public function getStaffData(){

            $categoryRepository = new CategoryRepository();
            $religionRepository = new ReligionRepository();
            $nationalityRepository = new NationalityRepository();
            $staffSubCategoryRepository = new StaffSubCategoryRepository();
            $staffCategoryRepository = new StaffCategoryRepository();
            $roleRepository = new RoleRepository();
            $designationRepository = new DesignationRepository();
            $departmentRepository = new DepartmentRepository();
            $genderRepository = new GenderRepository();
            $bloodGroupRepository = new BloodGroupRepository();
            
            $bloodGroup = $bloodGroupRepository->all();
            $gender = $genderRepository->all();
            $department = $departmentRepository->all();
            $designation = $designationRepository->all();
            $role = $roleRepository->institutionRoles();
            $staffCategory = $staffCategoryRepository->all();
            $staffSubCategory = $staffSubCategoryRepository->all();
            $nationality = $nationalityRepository->all();
            $religion = $religionRepository->all();
            $category = $categoryRepository->all();

            $output = array(
                'bloodGroup' => $bloodGroup,
                'gender' => $gender,
                'department' => $department,
                'designation' => $designation,
                'role' => $role,
                'staffCategory' => $staffCategory,
                'staffSubcategory' => $staffSubCategory,
                'nationality' => $nationality,
                'religion' => $religion,
                'category' => $category,
            );

            return $output;
        }

        // Fetch custom field values
        public function fetchCustomFieldValues($id){

            $customFieldRepository = new CustomFieldRepository();
            $staffCustomDetailsRepository = new StaffCustomDetailsRepository();
            $customFieldDetails = array();

            $customFieldValues = $staffCustomDetailsRepository->fetch($id);

            if($customFieldValues){

                foreach($customFieldValues as $index=> $value){

                    $customDetails = $customFieldRepository->fetch($value->id_custom_field);

                    if($customDetails->field_type == 'datepicker' || $customDetails->field_type != 'file'){

                        if($customDetails->field_type == 'datepicker'){
                            $customFieldValue = Carbon::createFromFormat('Y-m-d', $value->field_value)->format('d-m-Y');
                        }else if($customDetails->field_type != 'file'){
                            $customFieldValue =  $value->field_value;
                        }

                        $customFieldDetails[$index] = $value;
                        $customFieldDetails[$index]['field_value'] = $customFieldValue;
                        $customFieldDetails[$index]['custom_field_name'] = $customDetails->field_name;
                    }
                }
            }

            return $customFieldDetails;
        }

        // Fetch custom file values
        public function fetchCustomFileValues($id){

            $customFieldRepository = new CustomFieldRepository();
            $staffCustomDetailsRepository = new StaffCustomDetailsRepository();
            $customFileDetails = array();

            $customFieldValues = $staffCustomDetailsRepository->fetch($id);

            if($customFieldValues){

                foreach($customFieldValues as $index=> $value){

                    $customDetails = $customFieldRepository->fetch($value->id_custom_field);

                    if($customDetails->field_type == 'file'){
                        $customFieldValue = $value->field_value;
                        $customFileDetails[$index] = $value;
                        $customFileDetails[$index]['field_value'] = $customFieldValue;
                        $customFileDetails[$index]['custom_field_name'] = $customDetails->field_name;
                    }
                }
            }

            return $customFileDetails;
        }

        // Insert staff
        public function add($staffData){

            $uploadService = new UploadService();
            $staffFamilyDetailRepository = new StaffFamilyDetailRepository();
            $staffBoardRepository = new StaffBoardRepository();
            $staffSubjectMappingRepository = new StaffSubjectMappingRepository();
            $customFieldRepository = new CustomFieldRepository();
            $staffCustomDetailsRepository = new StaffCustomDetailsRepository();
            $staffRepository = new StaffRepository();

            $check = Staff::where('name', $staffData->staffName)
                            ->where('primary_contact_no', $staffData->staffPhone)
                            ->where('id_institute', $staffData->id_institute)
                            ->where('id_academic_year', $staffData->id_academic)
                            ->first();

            if(!$check){

                // Get max staff id
                $staffUid = $staffRepository->getMaxStaffId();

                $staffImage = $attachmentAadhaar = $attachmentPancard = '';

                $dob = Carbon::createFromFormat('d/m/Y', $staffData->staffDob)->format('Y-m-d');
                $joiningDate = Carbon::createFromFormat('d/m/Y', $staffData->joiningDate)->format('Y-m-d');

                // S3 file upload function call
                if($staffData->hasfile('staffImage')){
                    $path = 'Staff/Profile';
                    $staffImage = $uploadService->resizeUpload($staffData->staffImage, $path);
                }

                if($staffData->hasfile('attachmentAadhaar')){
                    $path = 'Staff/Adhaar';
                    $attachmentAadhaar = $uploadService->fileUpload($staffData->attachmentAadhaar, $path);
                }

                if($staffData->hasfile('attachmentPancard')){
                    $path = 'Staff/PAN';
                    $attachmentPancard = $uploadService->fileUpload($staffData->attachmentPancard, $path);
                }

                $data = array(
                    'id_organization' => $staffData->organization,
                    'id_academic_year' => $staffData->id_academic,
                    'id_institute' => $staffData->id_institute,
                    'name' => $staffData->staffName,
                    'middle_name' => $staffData->staffMiddleName,
                    'last_name' => $staffData->staffLastName,
                    'date_of_birth' => $dob,
                    'employee_id' => $staffData->employeeId,
                    'staff_uid' => $staffUid,
                    'id_gender' => $staffData->gender,
                    'id_blood_group' => $staffData->bloodGroup,
                    'id_designation' => $staffData->designation,
                    'id_department' => $staffData->department,
                    'id_role' => $staffData->staffRoll,
                    'id_staff_category' => $staffData->staffCategory,
                    'id_staff_subcategory' => $staffData->staffSubcategory,
                    'primary_contact_no' => $staffData->staffPhone,
                    'email_id' => $staffData->staffEmail,
                    'joining_date' => $joiningDate,
                    'duration_employment' => $staffData->employmentDuration,
                    'id_nationality' => $staffData->nationality,
                    'id_religion' => $staffData->religion,
                    'id_caste_category' => $staffData->cast,
                    'aadhaar_no' => $staffData->aadhaarNumber,
                    'pancard_no' => $staffData->panNumber,
                    'pf_uan_no' => $staffData->uanNumber,
                    'address' => $staffData->address,
                    'city' => $staffData->city,
                    'state' => $staffData->state,
                    'district' => $staffData->district,
                    'taluk' => $staffData->taluk,
                    'pincode' => $staffData->pincode,
                    'post_office' => $staffData->post_office,
                    'country' => $staffData->country,
                    'secondary_contact_no' => $staffData->emergencyContact,
                    'staff_image' => $staffImage,
                    'sms_for' => $staffData->smsFor,
                    'attachment_aadhaar' => $attachmentAadhaar,
                    'attachment_pancard' => $attachmentPancard,
                    'head_teacher' => $staffData->head_teacher,
                    'working_hours' => $staffData->working_hour,
                    'created_by' => Session::get('userId')
                );

                $storeData = $staffRepository->store($data);

                if($storeData){

                    $lastInsertedId = $storeData->id;

                    if($staffData->subject_specialization){

                        // Insert staff subjects mapping
                        foreach($staffData->subject_specialization as $subjectId){

                            $subjectMappingData = array(
                                'id_academic_year' => $staffData->id_academic,
                                'id_staff' => $lastInsertedId,
                                'id_subject' => $subjectId,
                                'created_by' => Session::get('userId'),
                                'modified_by' => ''
                            );

                            $storesubjectMapping = $staffSubjectMappingRepository->store($subjectMappingData);
                        }
                    }

                    // Insert staff board
                    if($staffData->board > 0){

                        $boardselection = implode(',', $staffData->board);

                        $boardselectionData = array(
                            'id_academic_year' => $staffData->id_academic,
                            'id_staff' => $lastInsertedId,
                            'board' => $boardselection,
                            'created_by' => Session::get('userId'),
                            'modified_by' => ''
                        );

                        $storeboardselection = $staffBoardRepository->store($boardselectionData);
                    }

                    // Store staff family details
                    if(isset($staffData->familyName)){
                        if($staffData->familyName[0] != ''){

                            foreach($staffData->familyName as $key => $familyName){

                                $familyPhone = $staffData->familyPhone[$key];
                                $familyRelation = $staffData->familyRelation[$key];

                                $data = array(
                                    'id_staff' => $lastInsertedId,
                                    'name' => $familyName,
                                    'phone' => $familyPhone,
                                    'relation' => $familyRelation,
                                    'created_by' => Session::get('userId'),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                );

                                $storeFamilyDetails = $staffFamilyDetailRepository->store($data);
                            }
                        }
                    }

                    // Insert custom fields
                    $customFields = $customFieldRepository->fetchCustomField($staffData->id_institute, 'staff');

                    foreach($customFields as $customField){

                            $customFieldId = $customField->id;

                            $customFieldValue = $staffData->$customFieldId;

                            if(is_array($staffData->$customFieldId)){
                                $customFieldValue = implode(",", $staffData->$customFieldId);
                            }

                            if($customField->field_type == 'file'){

                                if($staffData->hasfile($customFieldId)){
                                    $path = 'Staff/CustomFiles';
                                    $customFieldValue = $uploadService->fileUpload($staffData->$customFieldId, $path);

                                }else{
                                    $customFieldValue = '';
                                }

                            }else if($customField->field_type == 'datepicker'){
                                $customFieldValue = Carbon::createFromFormat('d/m/Y', $staffData->$customFieldId)->format('Y-m-d');
                            }

                            if($customFieldValue !=''){

                                $customFieldData = array(
                                    'id_staff' => $lastInsertedId,
                                    'id_custom_field' => $customFieldId,
                                    'field_value' => $customFieldValue,
                                    'created_by' => Session::get('userId'),
                                    'modified_by' => '',
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                );

                                $storecustomFields = $staffCustomDetailsRepository->store($customFieldData);
                            }
                    }

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

        // Update staff
        public function update($staffData, $id){

            $uploadService = new UploadService();
            $staffFamilyDetailRepository = new StaffFamilyDetailRepository();
            $staffBoardRepository = new StaffBoardRepository();
            $staffSubjectMappingRepository = new StaffSubjectMappingRepository();
            $customFieldRepository = new CustomFieldRepository();
            $staffCustomDetailsRepository = new StaffCustomDetailsRepository();
            $staffRepository = new StaffRepository();

            $check = Staff::where('name', $staffData->staffName)
                            ->where('primary_contact_no', $staffData->staffPhone)
                            ->where('id_institute', $staffData->id_institute)
                            ->where('id_academic_year', $staffData->id_academic)
                            ->where('id', '!=', $id)
                            ->first();

            if(!$check){

                $dob = Carbon::createFromFormat('d/m/Y', $staffData->staffDob)->format('Y-m-d');
                $joiningDate = Carbon::createFromFormat('d/m/Y', $staffData->joiningDate)->format('Y-m-d');

                // S3 file upload
                if($staffData->hasfile('staffImage')){
                    $path = 'Staff/Profile';
                    $staffImage = $uploadService->resizeUpload($staffData->staffImage, $path);
                }else{
                    $staffImage = $staffData->oldstaffImage;
                }

                if($staffData->hasfile('attachmentAadhaar')){
                    $path = 'Staff/Adhaar';
                    $attachmentAadhaar = $uploadService->fileUpload($staffData->attachmentAadhaar, $path);
                }else{
                    $attachmentAadhaar = $staffData->oldattachmentAadhaar;
                }

                if($staffData->hasfile('attachmentPancard')){
                    $path = 'Staff/PAN';
                    $attachmentPancard = $uploadService->fileUpload($staffData->attachmentPancard, $path);
                }else{
                    $attachmentPancard = $staffData->oldattachmentPancard;
                }

                $data = $staffRepository->fetch($id);

                $data->name = $staffData->staffName;
                $data->middle_name = $staffData->staffMiddleName;
                $data->last_name = $staffData->staffLastName;
                $data->date_of_birth = $dob;
                $data->employee_id = $staffData->employeeId;
                $data->id_gender = $staffData->gender;
                $data->id_blood_group = $staffData->bloodGroup;
                $data->id_designation = $staffData->designation;
                $data->id_department = $staffData->department;
                $data->id_role = $staffData->staffRoll;
                $data->id_staff_category = $staffData->staffCategory;
                $data->id_staff_subcategory = $staffData->staffSubcategory;
                $data->primary_contact_no = $staffData->staffPhone;
                $data->email_id = $staffData->staffEmail;
                $data->joining_date = $joiningDate;
                $data->duration_employment = $staffData->employmentDuration;
                $data->id_nationality = $staffData->nationality;
                $data->id_religion = $staffData->religion;
                $data->id_caste_category = $staffData->cast;
                $data->aadhaar_no = $staffData->aadhaarNumber;
                $data->pancard_no = $staffData->panNumber;
                $data->pf_uan_no = $staffData->uanNumber;
                $data->address = $staffData->address;
                $data->city = $staffData->city;
                $data->state = $staffData->state;
                $data->district = $staffData->district;
                $data->taluk = $staffData->taluk;
                $data->pincode = $staffData->pincode;
                $data->post_office = $staffData->post_office;
                $data->country = $staffData->country;
                $data->secondary_contact_no = $staffData->emergencyContact;
                $data->staff_image = $staffImage;
                $data->attachment_aadhaar = $attachmentAadhaar;
                $data->attachment_pancard = $attachmentPancard;
                $data->head_teacher = $staffData->head_teacher;
                $data->working_hours = $staffData->working_hour;
                $data->modified_by = Session::get('userId');

                $storeData = $staffRepository->update($data);

                if($storeData){

                    $deleteStaffSubject = $staffSubjectMappingRepository->delete($id);

                    // Update staff subjects mapping
                    if(isset($staffData->subject_specialization)){

                        if(count($staffData->subject_specialization) > 0){

                            foreach($staffData->subject_specialization as $subjectId){

                                $subjectMappingData = array(
                                    'id_academic_year' => $staffData->id_academic,
                                    'id_staff' => $id,
                                    'id_subject' => $subjectId,
                                    'created_by' => Session::get('userId')
                                );

                                $storesubjectMapping = $staffSubjectMappingRepository->store($subjectMappingData);
                            }
                        }
                    }

                    // Update staff board
                    if(isset($staffData->board)){

                        if(count($staffData->board) > 0){

                            $boardselection = implode(',', $staffData->board);

                            if($staffData->selectedBoardId != ''){

                                $boardselectionData = array(
                                    'id_academic_year' => $staffData->id_academic,
                                    'id_staff' => $id,
                                    'board' => $boardselection,
                                    'modified_by' => Session::get('userId')
                                );

                                $storeboardselection = $staffBoardRepository->update($boardselectionData, $staffData->selectedBoardId);

                            }else{

                                $boardselectionData = array(
                                    'id_academic_year' => $staffData->id_academic,
                                    'id_staff' => $id,
                                    'board' => $boardselection,
                                    'created_by' => Session::get('userId')
                                );

                                $storeboardselection = $staffBoardRepository->store($boardselectionData);
                            }
                        }
                    }

                    // Update staff family details
                    if(isset($staffData->familyName)){

                        if($staffData->familyName[0] != ''){

                            foreach($staffData->familyName as $key => $familyName){
                                // dd($familyName);
                                $familyDetailsId = $staffData->familyMemberId[$key];
                                $familyPhone = $staffData->familyPhone[$key];
                                $familyRelation = $staffData->familyRelation[$key];

                                if($familyDetailsId!=''){

                                    $familyDetail = $staffFamilyDetailRepository->fetch($familyDetailsId);

                                    $familyDetail->name = $familyName;
                                    $familyDetail->phone = $familyPhone;
                                    $familyDetail->relation = $familyRelation;
                                    $familyDetail->modified_by = Session::get('userId');
                                    $familyDetail->updated_at = Carbon::now();

                                    $response = $staffFamilyDetailRepository->update($familyDetail);

                                }else{

                                    $data = array(
                                        'id_staff' => $id,
                                        'name' => $familyName,
                                        'phone' => $familyPhone,
                                        'relation' => $familyRelation,
                                        'modified_by' => Session::get('userId'),
                                        'created_at' => Carbon::now(),
                                    );

                                    $response = $staffFamilyDetailRepository->store($data);
                                }
                            }
                        }
                    }

                    // Update custom fields
                    $customFields = $customFieldRepository->fetchCustomField($staffData->id_institute, 'staff');

                    foreach($customFields as $customField){

                        $customFieldId = $customField->id;
                        $customFieldValue = $staffData->$customFieldId;

                        if(is_array($staffData->$customFieldId)){
                            $customFieldValue = implode(",", $staffData->$customFieldId);
                        }

                        if($customField->field_type == 'file'){

                            $var = "old_";

                            if($staffData->hasfile($customFieldId)){
                                $path = 'Staff/CustomFiles';
                                $customFieldValue = $uploadService->fileUpload($staffData->$customFieldId, $path);
                            }else{
                                $oldImage = $var.$customFieldId;
                                $customFieldValue = $staffData->$oldImage;
                            }

                        }else if($customField->field_type == 'datepicker'){
                            $customFieldValue = Carbon::createFromFormat('d/m/Y', $staffData->$customFieldId)->format('Y-m-d');
                        }

                        $checkifExists = $staffCustomDetailsRepository->checkFieldExistence($id, $customFieldId);

                        if($checkifExists){

                            $fieldId = $checkifExists->id;

                            $customFieldData = array(
                                'field_value' => $customFieldValue,
                                'modified_by' => Session::get('userId'),
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            );

                            $storecustomFields = $staffCustomDetailsRepository->update($customFieldData, $fieldId);

                        }else{

                            if($customFieldValue!=''){
                                $customFieldData = array(
                                    'id_staff' => $id,
                                    'id_custom_field' => $customFieldId,
                                    'field_value' => $customFieldValue,
                                    'created_by' => Session::get('userId'),
                                    'modified_by' => '',
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                );

                                $storecustomFields = $staffCustomDetailsRepository->store($customFieldData);
                            }
                        }
                    }

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

        // Delete staff
        public function delete($id){

            $staffRepository = new StaffRepository();
            $staff = $staffRepository->delete($id);

            if($staff){
                $signal = 'success';
                $msg = 'Staff deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function getTableColumns(){

            $columnArray = ['gender', 'blood_group', 'designation', 'department', 'role', 'staff_category', 'staff_subcategory', 'nationality', 'religion', 'caste_category'];
            $allColumns = DB::getSchemaBuilder()->getColumnListing('tbl_staff');

            $unNeededColumns = ['id', 'id_academic_year', 'id_institute', 'id_gender', 'id_blood_group', 'id_designation', 'id_department', 'id_role', 'id_staff_category', 'id_staff_subcategory', 'id_nationality', 'id_religion', 'id_caste_category', 'attachment_aadhaar', 'attachment_pancard', 'staff_image', 'sms_for', 'created_by', 'modified_by', 'deleted_at', 'created_at', 'updated_at'];
            $neededColumns = array_diff($allColumns, $unNeededColumns);
            array_push($neededColumns, ...$columnArray);
            return $neededColumns;

        }

        public function fetchTableColumns(){

            $columnArray = ['name','gender', 'blood_group', 'designation', 'department', 'role', 'staff_category', 'staff_subcategory', 'nationality', 'religion', 'caste_category'];
            $allColumns = DB::getSchemaBuilder()->getColumnListing('tbl_staff');

            $unNeededColumns = ['id', 'name', 'id_academic_year', 'id_institute', 'id_gender', 'id_blood_group', 'id_designation', 'id_department', 'id_role', 'id_staff_category', 'id_staff_subcategory', 'id_nationality', 'id_religion', 'id_caste_category', 'attachment_aadhaar', 'attachment_pancard', 'staff_image', 'sms_for', 'created_by', 'modified_by', 'deleted_at', 'created_at', 'updated_at'];
            $neededColumns = array_diff($allColumns, $unNeededColumns);
            array_push($neededColumns, ...$columnArray);
            return $neededColumns;
        }

        // Deleted staff records
        public function getDeletedRecords($allSessions){

            $categoryRepository = new CategoryRepository();
            $religionRepository = new ReligionRepository();
            $nationalityRepository = new NationalityRepository();
            $staffSubCategoryRepository = new StaffSubCategoryRepository();
            $staffCategoryRepository = new StaffCategoryRepository();
            $roleRepository = new RoleRepository();
            $designationRepository = new DesignationRepository();
            $genderRepository = new GenderRepository();
            $bloodGroupRepository = new BloodGroupRepository();
            $staffRepository = new StaffRepository();
            $allDeletedStaffs = $staffRepository->allDeleted($allSessions);
            $arrayData = array();

            foreach($allDeletedStaffs as $key => $staffData){

                $arrayData[$key] = $staffData;
                $bloodGroup = $gender = $designation = $department = $role = $staffCategory = $staffSubCategory = $nationality = $religion = $category = '';

                if($staffData->id_blood_group){
                    $bloodGroupData = $bloodGroupRepository->fetch($staffData->id_blood_group);
                    if($bloodGroupData){
                        $bloodGroup = $bloodGroupData->name;
                    }
                }

                if($staffData->id_gender){
                    $genderData = $genderRepository->fetch($staffData->id_gender);
                    if($genderData){
                        $gender = $genderData->name;
                    }
                }

                if($staffData->id_department){
                    $departmentData = $departmentRepository->fetch($staffData->id_department);
                    if($departmentData){
                        $department = $departmentData->name;
                    }
                }

                if($staffData->id_designation){
                    $designationData = $designationRepository->fetch($staffData->id_designation);
                    if($designationData){
                        $designation = $designationData->name;
                    }
                }

                if($staffData->id_role){
                    $roleData = $roleRepository->fetch($staffData->id_role);
                    if($roleData){
                        $role = $roleData->name;
                    }
                }

                if($staffData->id_staff_category){
                    $staffCategoryData = $staffCategoryRepository->fetch($staffData->id_staff_category);
                    if($staffCategoryData){
                        $staffCategory = $staffCategoryData->name;
                    }
                }

                if($staffData->id_staff_subcategory){
                    $staffSubCategoryData = $staffSubCategoryRepository->fetch($staffData->id_staff_subcategory);
                    if($staffSubCategoryData){
                        $staffSubCategory = $staffSubCategoryData->name;
                    }
                }

                if($staffData->id_nationality){
                    $nationalityData = $nationalityRepository->fetch($staffData->id_nationality);
                    if($nationalityData){
                        $nationality = $nationalityData->name;
                    }
                }

                if($staffData->id_religion){
                    $religionData = $religionRepository->fetch($staffData->id_religion);
                    if($religionData){
                        $religion = $religionData->name;
                    }
                }

                if($staffData->id_caste_category){
                    $categoryData = $categoryRepository->fetch($staffData->id_caste_category);
                    if($categoryData){
                        $category = $categoryData->name;
                    }
                }

                $arrayData[$key]['department'] = $department;
                $arrayData[$key]['designation'] = $designation;
                $arrayData[$key]['bloodGroup'] = $bloodGroup;
                $arrayData[$key]['gender'] = $gender;
                $arrayData[$key]['role'] = $role;
                $arrayData[$key]['staffCategory'] = $staffCategory;
                $arrayData[$key]['staffSubCategory'] = $staffSubCategory;
                $arrayData[$key]['nationality'] = $nationality;
                $arrayData[$key]['religion'] = $religion;
                $arrayData[$key]['category'] = $category;
            }

            return $arrayData;
        }

        // Restore staff records
        public function restore($id){

            $staffRepository = new StaffRepository();

            $staffs = $staffRepository->restore($id);

            if($staffs){
                $signal = 'success';
                $msg = 'Data restored successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Restore all staff records
        public function restoreAll($allSessions){

            $staffRepository = new StaffRepository();
            $staffs = $staffRepository->restoreAll($allSessions);

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

        // Get staff based on staffcategory and staffsubcategory
        public function getAllStaff($StaffCategory, $staffSubcategory, $allSessions){

            $staffRepository = new StaffRepository();

            $staffData = $staffRepository->getStaffOnCategoryAndSubcategory($StaffCategory, $staffSubcategory, $allSessions);
            return $staffData;
        }

        // Get staff based on standard and subject
        public function getStaffByStandardAndSubject($standardId, $subjectid, $allSessions){

            $standardSubjectStaffMappingRepository = new StandardSubjectStaffMappingRepository();
            $staffdetails = $standardSubjectStaffMappingRepository->getStaffOnStandardAndSubject($standardId, $subjectid, $allSessions);
          
            return $staffdetails;
        }
    }
?>
