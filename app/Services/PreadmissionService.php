<?php
    namespace App\Services;

    use App\Models\Preadmission;
    use App\Models\Student;
    use App\Services\InstitutionStandardService;
    use App\Repositories\PreadmissionRepository;
    use App\Repositories\GenderRepository;
    use App\Repositories\NationalityRepository;
    use App\Repositories\ReligionRepository;
    use App\Repositories\FeeTypeRepository;
    use App\Repositories\AdmissionTypeRepository;
    use App\Repositories\CategoryRepository;
    use App\Repositories\BloodGroupRepository;
    use App\Repositories\SubjectRepository;
    use App\Repositories\PreadmissionCustomRepository;
    use App\Repositories\CustomFieldRepository;
    use App\Repositories\StudentRepository;
    use App\Repositories\StudentMappingRepository;
    use App\Repositories\StudentCustomRepository;
    use App\Repositories\DivisionRepository;
    use App\Repositories\InstitutionStandardRepository;
    use App\Services\UploadService;
    use Carbon\Carbon;
    use Session;
    use DB;

    class PreadmissionService {

        public function find($id){

            $preadmissionRepository = new PreadmissionRepository();
            $institutionStandardService = new InstitutionStandardService();
            $studentMappingRepository = new StudentMappingRepository();

            $applicationDetails = $preadmissionRepository->fetch($id);
            //dd($applicationDetails);
            $standard = $institutionStandardService->fetchPreadmissionStandardByUsingId($applicationDetails->id_standard);
            $studentName = $studentMappingRepository->getFullName($applicationDetails->name, $applicationDetails->middle_name, $applicationDetails->last_name);

            $birthDate = date('d-m-Y', strtotime($applicationDetails->date_of_birth));
            $currentDate = date("d-m-Y");
            $age = date_diff(date_create($birthDate), date_create($currentDate));
            $currentAge = $age->format("%y");

            $applicationDetails ['standard'] = $standard;
            $applicationDetails ['current_age'] = $currentAge;
            $applicationDetails ['studentName'] = $studentName;
            //dd($applicationDetails);

            return $applicationDetails;
        }

        // Get field data
        public function getFieldDetails(){

            $genderRepository = new GenderRepository();
            $institutionStandardService = new InstitutionStandardService();
            $nationalityRepository = new NationalityRepository();
            $religionRepository = new ReligionRepository();
            $feeTypeRepository = new FeeTypeRepository();
            $admissionTypeRepository = new AdmissionTypeRepository();
            $categoryRepository = new CategoryRepository();
            $bloodGroupRepository = new BloodGroupRepository();

            $gender = $genderRepository->all();
            $standard = $institutionStandardService->fetchStandardGroupByCombination();

            // $standard = [{"institutionStandard_id" => 1, "class" => "1A"}];
            $nationality = $nationalityRepository->all();
            $religion = $religionRepository->all();
            $feeType = $feeTypeRepository->all();
            $admissionType =  $admissionTypeRepository->all();
            $casteCategory = $categoryRepository->all();
            $bloodGroup = $bloodGroupRepository->all();

            $fieldDetails = array(
                'standard'=> $standard,
                'gender'=> $gender,
                'nationality'=> $nationality,
                'religion'=> $religion,
                'fee_type'=> $feeType,
                'admission_type'=> $admissionType,
                'caste_category'=> $casteCategory,
                'blood_group'=>$bloodGroup
            );
            //dd($fieldDetails);
            return $fieldDetails;
        }

        // Get all preadmission data
        public function all($allSessions){

            $institutionStandardService = new InstitutionStandardService();
            $preadmissionRepository = new PreadmissionRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $institutionStandardService = new InstitutionStandardService();
            $studentRepository = new StudentRepository();

            $allApplications = array();
            $applications = $preadmissionRepository->all($allSessions);

            foreach($applications as $key => $data){

                $preadmissionStudentData = $preadmissionRepository->fetch($data['id']);
                // dd($preadmissionStudentData);
                $check = $studentRepository->checkIfPreadmissionDataExists($preadmissionStudentData->name, $preadmissionStudentData->middle_name, $preadmissionStudentData->last_name, $preadmissionStudentData->father_mobile_number);

                if($check){
                    $studentData = $studentMappingRepository->fetch($check->id);
                    $standard = $institutionStandardService->fetchStandardByUsingId($studentData->id_standard);
                }else{
                    $standard = $institutionStandardService->fetchPreadmissionStandardByUsingId($data->id_standard);
                }

                if($data->father_mobile_number != ''){
                    $mobileNumber = $data->father_mobile_number;
                }else{
                    $mobileNumber = $data->mother_mobile_number;
                }

                $studentName = $studentMappingRepository->getFullName($data->name, $data->middle_name, $data->last_name);

                $applicationDetails = array(
                    'id' => $data->id,
                    'application_number'=>$data->application_number,
                    'name'=>$studentName,
                    'class'=>$standard,
                    'father_name'=>$data->father_name,
                    'phone_number'=>$mobileNumber,
                    'admitted'=>$data->admitted,
                    'type'=>$data->type,
                    'application_status'=>$data->application_status,
                );

                $allApplications[$key]= $applicationDetails;
            }

            return $allApplications;
        }

        // Fetch custom field values
        public function fetchCustomFieldValues($id){

            $customFieldRepository = new CustomFieldRepository();
            $preadmissionCustomRepository = new PreadmissionCustomRepository();
            $customFieldValues = $preadmissionCustomRepository->fetch($id);

            $customFieldDetails = array();

            if($customFieldValues){

                foreach($customFieldValues as $index => $value){

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
            $preadmissionCustomRepository = new PreadmissionCustomRepository();
            $customFileDetails = array();

            $customFieldValues = $preadmissionCustomRepository->fetch($id);

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

        // Insert preadmission
        public function add($preadmissionData){

            $preadmissionRepository = new PreadmissionRepository();
            $customFieldRepository = new CustomFieldRepository();
            $preadmissionCustomRepository = new PreadmissionCustomRepository();
            $uploadService = new UploadService();

            $check = Preadmission::where('name', $preadmissionData->name)
                                ->where('father_mobile_number', $preadmissionData->father_mobile_number)
                                ->first();

            if(!$check){

                $studentFirstName = $preadmissionData->student_first_name;
                $studentMiddleName = $preadmissionData->student_middle_name;
                $studentlastName = $preadmissionData->student_last_name;
                $dateOfBirth = Carbon::createFromFormat('d/m/Y', $preadmissionData->date_of_birth)->format('Y-m-d');
                $gender = $preadmissionData->gender;
                $standard = $preadmissionData->standard;
                $motherTongue = $preadmissionData->mother_tongue;
                $aadhaarNumber = $preadmissionData->student_aadhaar_number;
                $nationality = $preadmissionData->nationality;
                $religion = $preadmissionData->religion;
                $caste = $preadmissionData->caste;
                $casteCategory = $preadmissionData->caste_category;
                $bloodGroup = $preadmissionData->blood_group;
                $pincode = $preadmissionData->student_pincode;
                $city = $preadmissionData->student_city;
                $state = $preadmissionData->student_state;
                $country = $preadmissionData->student_country;
                $postOffice = $preadmissionData->student_post_office;
                $taluk = $preadmissionData->student_taluk;
                $district = $preadmissionData->student_district;
                $address = $preadmissionData->student_address;
                $fatherFirstName = $preadmissionData->father_first_name;
                $fatherMiddleName = $preadmissionData->father_middle_name;
                $fatherlastName = $preadmissionData->father_last_name;
                $fatherMobileNumber = $preadmissionData->father_mobile_number;
                $fatherAadhaarNumber = $preadmissionData->father_aadhaar_number;
                $fatherEducation = $preadmissionData->father_education;
                $fatherprofession = $preadmissionData->father_profession;
                $fatherEmail = $preadmissionData->father_email_id;
                $fatherIncome = $preadmissionData->father_annual_income;
                $motherFirstName = $preadmissionData->mother_first_name;
                $motherMiddleName = $preadmissionData->mother_middle_name;
                $motherlastName = $preadmissionData->mother_last_name;
                $motherMobileNumber = $preadmissionData->mother_mobile_number;
                $motherAadhaarNumber = $preadmissionData->mother_aadhaar_number;
                $motherEducation = $preadmissionData->mother_education;
                $motherprofession = $preadmissionData->mother_profession;
                $motherEmail = $preadmissionData->mother_email_id;
                $motherIncome = $preadmissionData->mother_annual_income;
                $guardianFirstName = $preadmissionData->guardian_first_name;
                $guardianMiddleName = $preadmissionData->guardian_middle_name;
                $guardianlastName = $preadmissionData->guardian_last_name;
                $guardianMobileNumber = $preadmissionData->guardian_phone;
                $guardianAadhaarNumber = $preadmissionData->guardian_aadhaar_number;
                $guardianEmail = $preadmissionData->guardian_email_id;
                $relationWithGuardian = $preadmissionData->relation_with_guardian;
                $guardianAddresss = $preadmissionData->guardian_addresss;
                $smsSentFor = $preadmissionData->sms_sent_for;
                $type = $preadmissionData->type;

                $admitted = 'NO';
                $applicationStatus = 'PENDING';
                $remarks = '';
                $applicationNumber = $preadmissionRepository->getMaxPreadmissionId() + 1;

                // S3 file upload
                if($preadmissionData->hasfile('student_profile')){
                    $path = 'Student/Profile';
                    $studentProfile = $uploadService->resizeUpload($preadmissionData->student_profile, $path);
                }else{
                    $studentProfile = '';
                }

                if($preadmissionData->hasfile('student_aadhaar_card_attachement')){
                    $path = 'Student/Adhaar';
                    $studentAadhaarCardAttachement = $uploadService->fileUpload($preadmissionData->student_aadhaar_card_attachement, $path);
                }else{
                    $studentAadhaarCardAttachement = '';
                }

                if($preadmissionData->hasfile('father_aadhaar_card_attachment')){
                    $path = 'Student/Adhaar';
                    $fatherAadhaarardAttachment = $uploadService->fileUpload($preadmissionData->father_aadhaar_card_attachment, $path);
                }else{
                    $fatherAadhaarardAttachment = '';
                }

                if($preadmissionData->hasfile('mother_aadhaar_card_attachment')){
                    $path = 'Student/Adhaar';
                    $motherAadhaarCardAttachment = $uploadService->fileUpload($preadmissionData->mother_aadhaar_card_attachment, $path);
                }else{
                    $motherAadhaarCardAttachment = '';
                }

                if($preadmissionData->hasfile('father_pan_card_attachment')){
                    $path = 'Student/PAN';
                    $fatherPanCardAttachment = $uploadService->fileUpload($preadmissionData->father_pan_card_attachment, $path);
                }else{
                    $fatherPanCardAttachment = '';
                }

                if($preadmissionData->hasfile('mother_pan_card_attachment')){
                    $path = 'Student/PAN';
                    $motherPanCardAttachment = $uploadService->fileUpload($preadmissionData->mother_pan_card_attachment, $path);
                }else{
                    $motherPanCardAttachment = '';
                }

                if($preadmissionData->hasfile('previous_tc_attachment')){
                    $path = 'Student/Transfer_Certificates';
                    $previousTcAttachment = $uploadService->fileUpload($preadmissionData->previous_tc_attachment, $path);
                }else{
                    $previousTcAttachment = '';
                }

                if($preadmissionData->hasfile('previous_study_certificate_attachment')){
                    $path = 'Student/Study_Certificates';
                    $previousStudyCertificateAttachment = $uploadService->fileUpload($preadmissionData->previous_study_certificate_attachment, $path);
                }else{
                    $previousStudyCertificateAttachment = '';
                }

                $data = array(
                    'id_organization' => $preadmissionData->id_organization,
                    'id_institute' => $preadmissionData->id_institute,
                    'id_academic_year' => $preadmissionData->id_academic,
                    'type' => $type,
                    'application_number' => $applicationNumber,
                    'name' => $studentFirstName,
                    'middle_name' => $studentMiddleName,
                    'last_name' => $studentlastName,
                    'id_standard' => $standard,
                    'date_of_birth' => $dateOfBirth,
                    'id_gender' => $gender,
                    'student_aadhaar_number' => $aadhaarNumber,
                    'id_nationality' => $nationality,
                    'id_religion' => $religion,
                    'caste' => $caste,
                    'id_caste_category' => $casteCategory,
                    'mother_tongue' => $motherTongue,
                    'id_blood_group' => $bloodGroup,
                    'address' => $address,
                    'city' => $city,
                    'taluk' => $taluk,
                    'district' => $district,
                    'state' => $state,
                    'country' => $country,
                    'pincode' => $pincode,
                    'post_office' => $postOffice,
                    'father_name' => $fatherFirstName,
                    'father_middle_name' => $fatherMiddleName,
                    'father_last_name' => $fatherlastName,
                    'father_mobile_number' => $fatherMobileNumber,
                    'father_aadhaar_number' => $fatherAadhaarNumber,
                    'father_education' => $fatherEducation,
                    'father_profession' => $fatherprofession,
                    'father_email' => $fatherEmail,
                    'father_annual_income' => $fatherIncome,
                    'mother_name' => $motherFirstName,
                    'mother_middle_name' => $motherMiddleName,
                    'mother_last_name' => $motherlastName,
                    'mother_mobile_number' => $motherMobileNumber,
                    'mother_aadhaar_number' => $motherAadhaarNumber,
                    'mother_education' => $motherEducation,
                    'mother_profession' => $motherprofession,
                    'mother_email' => $motherEmail,
                    'mother_annual_income' => $motherIncome,
                    'guardian_name' => $guardianFirstName,
                    'guardian_middle_name' => $guardianMiddleName,
                    'guardian_last_name' => $guardianlastName,
                    'guardian_aadhaar_no' => $guardianMobileNumber,
                    'guardian_contact_no' => $guardianAadhaarNumber,
                    'guardian_email' => $guardianEmail,
                    'guardian_relation' => $relationWithGuardian,
                    'guardian_address' => $guardianAddresss,
                    'sms_for' => $smsSentFor,
                    'attachment_student_photo' => $studentProfile,
                    'attachment_student_aadhaar' => $studentAadhaarCardAttachement,
                    'attachment_father_aadhaar' => $fatherAadhaarardAttachment,
                    'attachment_mother_aadhaar' => $motherAadhaarCardAttachment,
                    'attachment_father_pancard' => $fatherPanCardAttachment,
                    'attachment_mother_pancard' => $motherPanCardAttachment,
                    'attachment_previous_tc' => $previousTcAttachment,
                    'attachment_previous_study_certificate' => $previousStudyCertificateAttachment,
                    'admitted' => $admitted,
                    'application_status' => $applicationStatus,
                    'remarks' => $remarks,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );

                $response = $preadmissionRepository->store($data);

                if($response){

                    $lastInsertedId = $response->id;

                    $preadmissionCustoms = $customFieldRepository->fetchCustomField($institutionId, 'student');

                    foreach($preadmissionCustoms as $index=> $field){

                        $customFieldId = $field->id;

                        if($field->field_type == 'file'){

                            if($preadmissionData->hasfile($customFieldId)){
                                $customFieldValue = $preadmissionRepository->upload($preadmissionData->$customFieldId);
                            }else{
                                $customFieldValue = '';
                            }

                        }else if($field->field_type == 'datepicker'){
                            $customFieldValue = Carbon::createFromFormat('d/m/Y', $preadmissionData->$customFieldId)->format('Y-m-d');

                        }else if($field->field_type == 'multiple_select'){

                            if($preadmissionData->$customFieldId != ''){
                                $customFieldValue = implode(',', $preadmissionData->$customFieldId);
                            }else{
                                $customFieldValue = '';
                            }

                        }else if($preadmissionData->$customFieldId != ''){
                            $customFieldValue = $preadmissionData->$customFieldId;
                        }else{
                            $customFieldValue = '';
                        }

                        $customData = array(
                            'id_preadmission'=>$lastInsertedId,
                            'id_custom_field'=>$customFieldId,
                            'field_value'=>$customFieldValue,
                            'created_by' => Session::get('userId'),
                            'created_at' => Carbon::now()
                        );

                        $storeCustomData = $preadmissionCustomRepository->store($customData);
                    }

                    $signal = 'success';
                    $msg = 'Data inserted successfully!';

                }else{
                    $signal = 'failure';
                    $msg = 'Error inserting data!';
                }

            }else{
                $signal = 'exist';
                $msg = 'This Data already exists!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Update preadmission
        public function update($preadmissionData, $id){

            $preadmissionRepository = new PreadmissionRepository();
            $customFieldRepository = new CustomFieldRepository();
            $preadmissionCustomRepository = new PreadmissionCustomRepository();
            $uploadService = new UploadService();

            $check = Preadmission::where('name', $preadmissionData->name)
                                ->where('father_mobile_number', $preadmissionData->father_mobile_number)
                                ->where('id', '!=', $id)
                                ->first();

            if(!$check){

                $studentFirstName = $preadmissionData->student_first_name;
                $studentMiddleName = $preadmissionData->student_middle_name;
                $studentlastName = $preadmissionData->student_last_name;
                $dateOfBirth = Carbon::createFromFormat('d/m/Y', $preadmissionData->date_of_birth)->format('Y-m-d');
                $gender = $preadmissionData->gender;
                $standard = $preadmissionData->standard;
                $motherTongue = $preadmissionData->mother_tongue;
                $aadhaarNumber = $preadmissionData->student_aadhaar_number;
                $nationality = $preadmissionData->nationality;
                $religion = $preadmissionData->religion;
                $caste = $preadmissionData->caste;
                $casteCategory = $preadmissionData->caste_category;
                $bloodGroup = $preadmissionData->blood_group;
                $pincode = $preadmissionData->student_pincode;
                $city = $preadmissionData->student_city;
                $state = $preadmissionData->student_state;
                $country = $preadmissionData->student_country;
                $postOffice = $preadmissionData->student_post_office;
                $taluk = $preadmissionData->student_taluk;
                $district = $preadmissionData->student_district;
                $address = $preadmissionData->student_address;
                $fatherFirstName = $preadmissionData->father_first_name;
                $fatherMiddleName = $preadmissionData->father_middle_name;
                $fatherlastName = $preadmissionData->father_last_name;
                $fatherMobileNumber = $preadmissionData->father_mobile_number;
                $fatherAadhaarNumber = $preadmissionData->father_aadhaar_number;
                $fatherEducation = $preadmissionData->father_education;
                $fatherprofession = $preadmissionData->father_profession;
                $fatherEmail = $preadmissionData->father_email_id;
                $fatherIncome = $preadmissionData->father_annual_income;
                $motherFirstName = $preadmissionData->mother_first_name;
                $motherMiddleName = $preadmissionData->mother_middle_name;
                $motherlastName = $preadmissionData->mother_last_name;
                $motherMobileNumber = $preadmissionData->mother_mobile_number;
                $motherAadhaarNumber = $preadmissionData->mother_aadhaar_number;
                $motherEducation = $preadmissionData->mother_education;
                $motherprofession = $preadmissionData->mother_profession;
                $motherEmail = $preadmissionData->mother_email_id;
                $motherIncome = $preadmissionData->mother_annual_income;
                $guardianFirstName = $preadmissionData->guardian_first_name;
                $guardianMiddleName = $preadmissionData->guardian_middle_name;
                $guardianlastName = $preadmissionData->guardian_last_name;
                $guardianMobileNumber = $preadmissionData->guardian_phone;
                $guardianAadhaarNumber = $preadmissionData->guardian_aadhaar_number;
                $guardianEmail = $preadmissionData->guardian_email_id;
                $relationWithGuardian = $preadmissionData->relation_with_guardian;
                $guardianAddresss = $preadmissionData->guardian_addresss;
                $smsSentFor = $preadmissionData->sms_sent_for;
                $applicationStatus = 'PENDING';

                // S3 file upload function call
                if($preadmissionData->hasfile('student_profile')){
                    $path = 'Student/Profile';
                    $studentProfile = $uploadService->resizeUpload($preadmissionData->student_profile, $path);
                }else{
                    $studentProfile = $preadmissionData->old_student_profile;
                }

                if($preadmissionData->hasfile('student_aadhaar_card_attachement')){
                    $path = 'Student/Adhaar';
                    $studentAadhaarCardAttachement = $uploadService->fileUpload($preadmissionData->student_aadhaar_card_attachement, $path);
                }else{
                    $studentAadhaarCardAttachement = $preadmissionData->old_student_aadhaar_card_attachement;
                }

                if($preadmissionData->hasfile('father_aadhaar_card_attachment')){
                    $path = 'Student/Adhaar';
                    $fatherAadhaarardAttachment = $uploadService->fileUpload($preadmissionData->father_aadhaar_card_attachment, $path);
                }else{
                    $fatherAadhaarardAttachment = $preadmissionData->old_father_aadhaar_card_attachment;
                }

                if($preadmissionData->hasfile('mother_aadhaar_card_attachment')){
                    $path = 'Student/Adhaar';
                    $motherAadhaarCardAttachment = $uploadService->fileUpload($preadmissionData->mother_aadhaar_card_attachment, $path);
                }else{
                    $motherAadhaarCardAttachment = $preadmissionData->old_mother_aadhaar_card_attachment;
                }

                if($preadmissionData->hasfile('father_pan_card_attachment')){
                    $path = 'Student/PAN';
                    $fatherPanCardAttachment = $uploadService->fileUpload($preadmissionData->father_pan_card_attachment, $path);
                }else{
                    $fatherPanCardAttachment = $preadmissionData->old_father_pan_card_attachment;
                }

                if($preadmissionData->hasfile('mother_pan_card_attachment')){
                    $path = 'Student/PAN';
                    $motherPanCardAttachment = $uploadService->fileUpload($preadmissionData->mother_pan_card_attachment, $path);
                }else{
                    $motherPanCardAttachment = $preadmissionData->old_mother_pan_card_attachment;
                }

                if($preadmissionData->hasfile('previous_tc_attachment')){
                    $path = 'Student/Transfer_Certificates';
                    $previousTcAttachment = $uploadService->fileUpload($preadmissionData->previous_tc_attachment, $path);
                }else{
                    $previousTcAttachment = $preadmissionData->old_previous_tc_attachment;
                }

                if($preadmissionData->hasfile('previous_study_certificate_attachment')){
                    $path = 'Student/Study_Certificates';
                    $previousStudyCertificateAttachment = $uploadService->fileUpload($preadmissionData->previous_study_certificate_attachment, $path);
                }else{
                    $previousStudyCertificateAttachment =  $preadmissionData->old_previous_study_certificate_attachment;
                }

                $preadmissionDetail = $preadmissionRepository->fetch($id);

                $preadmissionDetail->name = $studentFirstName;
                $preadmissionDetail->middle_name = $studentMiddleName;
                $preadmissionDetail->last_name = $studentlastName;
                $preadmissionDetail->id_standard = $standard;
                $preadmissionDetail->date_of_birth = $dateOfBirth;
                $preadmissionDetail->id_gender = $gender;
                $preadmissionDetail->student_aadhaar_number = $aadhaarNumber;
                $preadmissionDetail->id_nationality = $nationality;
                $preadmissionDetail->id_religion = $religion;
                $preadmissionDetail->caste = $caste;
                $preadmissionDetail->id_caste_category = $casteCategory;
                $preadmissionDetail->mother_tongue = $motherTongue;
                $preadmissionDetail->id_blood_group = $bloodGroup;
                $preadmissionDetail->address = $address;
                $preadmissionDetail->city = $city;
                $preadmissionDetail->taluk = $taluk;
                $preadmissionDetail->district = $district;
                $preadmissionDetail->state = $state;
                $preadmissionDetail->country = $country;
                $preadmissionDetail->pincode = $pincode;
                $preadmissionDetail->post_office = $postOffice;
                $preadmissionDetail->father_name = $fatherFirstName;
                $preadmissionDetail->father_middle_name = $fatherMiddleName;
                $preadmissionDetail->father_last_name = $fatherlastName;
                $preadmissionDetail->father_mobile_number = $fatherMobileNumber;
                $preadmissionDetail->father_aadhaar_number = $fatherAadhaarNumber;
                $preadmissionDetail->father_education = $fatherEducation;
                $preadmissionDetail->father_profession = $fatherprofession;
                $preadmissionDetail->father_email = $fatherEmail;
                $preadmissionDetail->father_annual_income = $fatherIncome;
                $preadmissionDetail->mother_name = $motherFirstName;
                $preadmissionDetail->mother_middle_name = $motherMiddleName;
                $preadmissionDetail->mother_last_name = $motherlastName;
                $preadmissionDetail->mother_mobile_number = $motherMobileNumber;
                $preadmissionDetail->mother_aadhaar_number = $motherAadhaarNumber;
                $preadmissionDetail->mother_education = $motherEducation;
                $preadmissionDetail->mother_profession = $motherprofession;
                $preadmissionDetail->mother_email = $motherEmail;
                $preadmissionDetail->mother_annual_income = $motherIncome;
                $preadmissionDetail->guardian_name = $guardianFirstName;
                $preadmissionDetail->guardian_middle_name = $guardianMiddleName;
                $preadmissionDetail->guardian_last_name = $guardianlastName;
                $preadmissionDetail->guardian_aadhaar_no = $guardianMobileNumber;
                $preadmissionDetail->guardian_contact_no = $guardianAadhaarNumber;
                $preadmissionDetail->guardian_email = $guardianEmail;
                $preadmissionDetail->guardian_relation = $relationWithGuardian;
                $preadmissionDetail->guardian_address = $guardianAddresss;
                $preadmissionDetail->sms_for = $smsSentFor;
                $preadmissionDetail->attachment_student_photo = $studentProfile;
                $preadmissionDetail->attachment_student_aadhaar = $studentAadhaarCardAttachement;
                $preadmissionDetail->attachment_father_aadhaar = $fatherAadhaarardAttachment;
                $preadmissionDetail->attachment_mother_aadhaar = $motherAadhaarCardAttachment;
                $preadmissionDetail->attachment_father_pancard = $fatherPanCardAttachment;
                $preadmissionDetail->attachment_mother_pancard = $motherPanCardAttachment;
                $preadmissionDetail->attachment_previous_tc = $previousTcAttachment;
                $preadmissionDetail->attachment_previous_study_certificate = $previousStudyCertificateAttachment;
                $preadmissionDetail->application_status = $applicationStatus;
                $preadmissionDetail->modified_by = Session::get('userId');
                $preadmissionDetail->updated_at = Carbon::now();

                $response = $preadmissionRepository->update($preadmissionDetail);

                if($response){

                    // Custom fields updating
                    $preadmissionCustoms = $customFieldRepository->fetchCustomField($institutionId, 'student');

                    foreach($preadmissionCustoms as $index => $field){

                        $customFieldId = $field->id;

                        if($field->field_type == 'file'){

                            if($preadmissionData->hasfile($customFieldId)){
                                $path = 'Student/CustomFiles';
                                $customFieldValue = $uploadService->fileUpload($preadmissionData->$customFieldId, $path);
                            }else{
                                $oldImage =  'old_'.$customFieldId;
                                $customFieldValue = $preadmissionData->$oldImage;
                            }

                        }else if($field->field_type == 'datepicker'){

                            $customFieldValue = Carbon::createFromFormat('d/m/Y', $preadmissionData->$customFieldId)->format('Y-m-d');

                        }else if($field->field_type == 'multiple_select'){

                            if(isset($preadmissionData->$customFieldId)){
                                $customFieldValue = implode(',', $preadmissionData->$customFieldId);
                            }else{
                                $customFieldValue = '';
                            }

                        }else if($preadmissionData->$customFieldId != ''){

                            $customFieldValue = $preadmissionData->$customFieldId;

                        }else{
                            $customFieldValue = '';
                        }

                        $customData = array(
                            'field_value'=>$customFieldValue,
                            'modified_by' => Session::get('userId'),
                            'updated_at' => Carbon::now()
                        );

                        $storeCustomData = $preadmissionCustomRepository->updateCustomValues($customData, $id, $customFieldId);
                    }

                    $signal = 'success';
                    $msg = 'Data Updated Successfully!';

                }else{
                    $signal = 'failure';
                    $msg = 'Error updating data!';
                }

            }else{
                $signal = 'exist';
                $msg = 'This Data already exists!';
            }

             $output = array(
                'signal'=> $signal,
                'message'=> $msg
            );

            return $output;
        }

        // Deleted preadmission
        public function delete($id){

            $preadmissionRepository = new PreadmissionRepository();

            $preadmission = $preadmissionRepository->delete($id);

            if($preadmission){
                $signal = 'exist';
                $msg = 'preadmission deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function approve($id){

            $preadmissionRepository = new PreadmissionRepository();
            $data = array(
                    'application_status' =>'APPROVED'
                    );

            $preadmission = $preadmissionRepository->update($data, $id);

            if($preadmission)
            {
                $signal = 'success';
                $msg = 'Approved Successfully!';
            }
            else
            {
                $signal = 'failure';
                $msg = 'Error In Admitting!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function reject($data, $id){

            $preadmissionRepository = new PreadmissionRepository();
            $remarks = $data->remarks;
            //dd($remarks);
            $rejectData = array(
                    'application_status' =>'REJECTED',
                    'remarks' =>$remarks
                    );

            $preadmission = $preadmissionRepository->update($rejectData, $id);

            if($preadmission)
            {
                $signal = 'exist';
                $msg = 'Rejected Successfully!';
            }
            else
            {
                $signal = 'failure';
                $msg = 'Error In Rejecting..!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function correction($data, $id){

            $preadmissionRepository = new PreadmissionRepository();
            $remarks = $data->remarks;
            //dd($remarks);
            $correctionData = array(
                    'application_status' =>'CORRECTION_REQUEST',
                    'remarks' =>$remarks
                    );

            $preadmission = $preadmissionRepository->update($correctionData, $id);
            if($preadmission)
            {
                $signal = 'success';
                $msg = 'Correction Request Sent Successfully!';
            }
            else
            {
                $signal = 'failure';
                $msg = 'Error In Sending..!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Get all student based on standard
        public function studentsBasedOnStandard($standardId){

            $institutionStandardService = new InstitutionStandardService();
            $institutionStandardRepository = new InstitutionStandardRepository();
            $preadmissionRepository = new PreadmissionRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $genderRepository = new GenderRepository();

            $allApplications = array();
            $applications = $preadmissionRepository->findStudent($standardId);
            $standardData = $institutionStandardRepository->fetch($standardId);

            if($standardData){
                $standardDivisions = $institutionStandardService->fetchStandardDivisions($standardData->id_standard, $standardData->id_year, $standardData->id_sem, $standardData->id_stream, $standardData->id_combination);
                // dd($standardDivisions);
                foreach($applications as $data){

                    $gender = $genderRepository->fetch($data->id_gender);
                    $standard = $institutionStandardService->fetchPreadmissionStandardByUsingId($data->id_standard);
                    $studentName = $studentMappingRepository->getFullName($data->name, $data->middle_name, $data->last_name);

                    $applicationDetails = array(
                        'id' => $data->id,
                        'application_number'=>$data->application_number,
                        // 'name'=>$data->name,
                        'name'=>$studentName,
                        'class'=>$standard,
                        'gender'=>$gender->name,
                        'dob'=>$data->date_of_birth,
                        'father_name'=>$data->father_name,
                        'phone_number'=>$data->father_mobile_number,
                        'admitted'=>$data->admitted,
                        'application_status'=>$data->application_status,
                        'division'=>$standardDivisions,
                    );

                    $allApplications[$data->id]= $applicationDetails;
                }
            }

            return $allApplications;
        }

        // Admit preadmission
        public function admit($request){

            $studentCustomRepository = new StudentCustomRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $studentRepository = new StudentRepository();
            $admissionTypeRepository = new AdmissionTypeRepository();
            $preadmissionRepository = new PreadmissionRepository();
            $preadmissionCustomRepository = new PreadmissionCustomRepository();
            $uploadService = new UploadService();

            $preadmissionIds = $request->preadmissionSelect;
            // dd($preadmissionIds);
            $admitCount = 0;
            foreach($preadmissionIds as $preadmissionId){

                $preadmissionStudentData = $preadmissionRepository->fetch($preadmissionId);
                // dd($preadmissionStudentData);
                $check = $studentRepository->checkIfPreadmissionDataExists($preadmissionStudentData->name, $preadmissionStudentData->middle_name, $preadmissionStudentData->last_name, $preadmissionStudentData->father_mobile_number);

                if(!$check){

                    $institutionId = $preadmissionStudentData->id_institute;
                    $academicYear = $preadmissionStudentData->id_academic_year;
                    $organizationId = $preadmissionStudentData->id_organization;

                    $studentFirstName = $preadmissionStudentData->name;
                    $studentMiddleName = $preadmissionStudentData->middle_name;
                    $studentlastName = $preadmissionStudentData->last_name;
                    $dateOfBirth = $preadmissionStudentData->date_of_birth;
                    $gender = $preadmissionStudentData->id_gender;
                    $standard = $request->division[$preadmissionId];
                    $motherTongue = $preadmissionStudentData->mother_tongue;
                    $aadhaarNumber = $preadmissionStudentData->student_aadhaar_number;
                    $nationality = $preadmissionStudentData->id_nationality;
                    $religion = $preadmissionStudentData->id_religion;
                    $caste = $preadmissionStudentData->caste;
                    $casteCategory = $preadmissionStudentData->id_caste_category;
                    $bloodGroup = $preadmissionStudentData->id_blood_group;
                    $pincode = $preadmissionStudentData->pincode;
                    $city = $preadmissionStudentData->city;
                    $state = $preadmissionStudentData->state;
                    $country = $preadmissionStudentData->country;
                    $postOffice = $preadmissionStudentData->post_office;
                    $taluk = $preadmissionStudentData->taluk;
                    $district = $preadmissionStudentData->district;
                    $address = $preadmissionStudentData->address;
                    $fatherFirstName = $preadmissionStudentData->father_name;
                    $fatherMiddleName = $preadmissionStudentData->father_middle_name;
                    $fatherlastName = $preadmissionStudentData->father_last_name;
                    $fatherMobileNumber = $preadmissionStudentData->father_mobile_number;
                    $fatherAadhaarNumber = $preadmissionStudentData->father_aadhaar_number;
                    $fatherEducation = $preadmissionStudentData->father_education;
                    $fatherprofession = $preadmissionStudentData->father_profession;
                    $fatherEmail = $preadmissionStudentData->father_email;
                    $fatherIncome = $preadmissionStudentData->father_annual_income;
                    $motherFirstName = $preadmissionStudentData->mother_name;
                    $motherMiddleName = $preadmissionStudentData->mother_middle_name;
                    $motherlastName = $preadmissionStudentData->mother_last_name;
                    $motherMobileNumber = $preadmissionStudentData->mother_mobile_number;
                    $motherAadhaarNumber = $preadmissionStudentData->mother_aadhaar_number;
                    $motherEducation = $preadmissionStudentData->mother_education;
                    $motherprofession = $preadmissionStudentData->mother_profession;
                    $motherEmail = $preadmissionStudentData->mother_email;
                    $motherIncome = $preadmissionStudentData->mother_annual_income;
                    $guardianFirstName = $preadmissionStudentData->guardian_name;
                    $guardianMiddleName = $preadmissionStudentData->guardian_middle_name;
                    $guardianlastName = $preadmissionStudentData->guardian_last_name;
                    $guardianMobileNumber = $preadmissionStudentData->guardian_contact_no;
                    $guardianAadhaarNumber = $preadmissionStudentData->guardian_aadhaar_no;
                    $guardianEmail = $preadmissionStudentData->guardian_email;
                    $relationWithGuardian = $preadmissionStudentData->guardian_relation;
                    $guardianAddresss = $preadmissionStudentData->guardian_address;
                    $smsSentFor = $preadmissionStudentData->sms_for;

                    if($preadmissionStudentData->attachment_student_photo !=''){
                        $studentProfile = $preadmissionStudentData->attachment_student_photo;
                    }else{
                        $studentProfile = '';
                    }

                    if($preadmissionStudentData->attachment_student_aadhaar !=''){
                        $studentAadhaarCardAttachement = $preadmissionStudentData->attachment_student_aadhaar;
                    }else{
                        $studentAadhaarCardAttachement = '';
                    }

                    if($preadmissionStudentData->attachment_father_aadhaar !=''){
                        $fatherAadhaarardAttachment = $preadmissionStudentData->attachment_father_aadhaar;
                    }else{
                        $fatherAadhaarardAttachment = '';
                    }

                    if($preadmissionStudentData->attachment_mother_aadhaar !=''){
                        $motherAadhaarCardAttachment = $preadmissionStudentData->attachment_mother_aadhaar;
                    }else{
                        $motherAadhaarCardAttachment = '';
                    }

                    if($preadmissionStudentData->attachment_father_pancard !=''){
                        $fatherPanCardAttachment = $preadmissionStudentData->attachment_father_pancard;
                    }else{
                        $fatherPanCardAttachment = '';
                    }

                    if($preadmissionStudentData->attachment_mother_pancard !=''){
                        $motherPanCardAttachment = $preadmissionStudentData->attachment_mother_pancard;
                    }else{
                        $motherPanCardAttachment = '';
                    }

                    if($preadmissionStudentData->attachment_previous_tc !=''){
                        $previousTcAttachment = $preadmissionStudentData->attachment_previous_tc;
                    }else{
                        $previousTcAttachment = '';
                    }

                    if($preadmissionStudentData->attachment_previous_study_certificate !=''){
                        $previousStudyCertificateAttachment = $preadmissionStudentData->attachment_previous_study_certificate;
                    }else{
                        $previousStudyCertificateAttachment = '';
                    }

                    $preadmissonId = $preadmissionStudentData->id;
                    $egeniusUid = $studentRepository->getMaxStudentId() + 1;
                    $applicationNumber = $preadmissionRepository->getMaxPreadmissionId() + 1;
                    $usn = '';
                    $registerNumber = '';
                    $rollNumber = 0;
                    $admissionDate = date('Y-m-d');
                    $admissionNumber = '';
                    $satsNumber = '';
                    $admissionType = $admissionTypeRepository->fetchType('new');
                    $firstLanguage = '';
                    $secondLanguage = '';
                    $thirdLanguage = '';
                    $feeType = '';

                    $data = array(
                        'id_preadmission' => $preadmissonId,
                        'name' => $studentFirstName,
                        'middle_name' => $studentMiddleName,
                        'last_name' => $studentlastName,
                        'date_of_birth' => $dateOfBirth,
                        'id_gender' => $gender,
                        'egenius_uid' => $egeniusUid,
                        'usn' => $usn,
                        'register_number' => $registerNumber,
                        'roll_number' => $rollNumber,
                        'admission_date' => $admissionDate,
                        'admission_number' => $admissionNumber,
                        'sats_number' => $satsNumber,
                        'student_aadhaar_number' => $aadhaarNumber,
                        'id_nationality' => $nationality,
                        'id_religion' => $religion,
                        'caste' => $caste,
                        'id_caste_category' => $casteCategory,
                        'mother_tongue' => $motherTongue,
                        'id_blood_group' => $bloodGroup,
                        'address' => $address,
                        'city' => $city,
                        'taluk' => $state,
                        'district' => $district,
                        'state' => $state,
                        'country' => $country,
                        'pincode' => $pincode,
                        'post_office' => $postOffice,
                        'father_name' => $fatherFirstName,
                        'father_middle_name' => $fatherMiddleName,
                        'father_last_name' => $fatherlastName,
                        'father_mobile_number' => $fatherMobileNumber,
                        'father_aadhaar_number' => $fatherAadhaarNumber,
                        'father_education' => $fatherEducation,
                        'father_annual_income' => $fatherIncome,
                        'mother_name' => $motherFirstName,
                        'mother_middle_name' => $motherMiddleName,
                        'mother_last_name' => $motherlastName,
                        'mother_mobile_number' => $motherMobileNumber,
                        'mother_profession' => $motherprofession,
                        'mother_email' => $motherEmail,
                        'mother_aadhaar_number' => $motherAadhaarNumber,
                        'mother_education' => $motherEducation,
                        'mother_annual_income' => $motherIncome,
                        'guardian_name' => $guardianFirstName,
                        'guardian_aadhaar_no' => $guardianAadhaarNumber,
                        'guardian_contact_no' => $guardianMobileNumber,
                        'guardian_email' => $guardianEmail,
                        'relationWithGuardian' => $relationWithGuardian,
                        'guardian_address' => $guardianAddresss,
                        'sms_for' => $smsSentFor,
                        'attachment_student_photo' => $studentProfile,
                        'attachment_student_aadhaar' => $studentAadhaarCardAttachement,
                        'attachment_father_aadhaar' => $fatherAadhaarardAttachment,
                        'attachment_mother_aadhaar' => $motherAadhaarCardAttachment,
                        'attachment_father_pancard' => $fatherPanCardAttachment,
                        'attachment_mother_pancard' => $motherPanCardAttachment,
                        'attachment_previous_tc' => $previousTcAttachment,
                        'attachment_previous_study_certificate' => $previousStudyCertificateAttachment,
                        'created_by' => Session::get('userId'),
                        'created_at' => Carbon::now(),
                    );

                    // dd($data);
                    if($standard !=''){
                        $response = $studentRepository->store($data);

                        if($response){

                            $lastInsertedId = $response->id;

                            $mappingData = array(
                                'id_organization' => $organizationId,
                                'id_student' => $lastInsertedId,
                                'id_standard' => $standard,
                                'id_institute' => $institutionId,
                                'id_academic_year' => $academicYear,
                                'id_first_language' => $firstLanguage,
                                'id_second_language' => $secondLanguage,
                                'id_third_language' => $thirdLanguage,
                                'id_fee_type' => $feeType,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );

                            $storeStudentData = $studentMappingRepository->store($mappingData);

                            if($storeStudentData){


                                $preadmissionStudentData->admitted = 'YES';

                                $preadmission = $preadmissionRepository->update($preadmissionStudentData);

                                $customFieldValues = $preadmissionCustomRepository->fetch($preadmissionId);

                                if($customFieldValues){

                                    foreach($customFieldValues as $index=> $value){

                                        $customData = array(
                                            'id_student'=>$lastInsertedId,
                                            'id_custom_field'=>$value->id_custom_field,
                                            'field_value'=>$value->field_value,
                                            'created_by' => Session::get('userId'),
                                            'created_at' => Carbon::now()
                                        );

                                        $storeCustomData = $studentCustomRepository->store($customData);
                                    }
                                }

                                $admitCount ++;

                            }else{
                                $failureCount ++;
                            }


                        }else{
                            $failureCount ++;
                        }
                    }else{
                        $failureCount ++;
                    }

                }
            }

            if($admitCount > 0){
                $signal = 'success';
                $msg = 'Admitted Successfully!';
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

        public function checkLoginCredentials($request){

            $phoneNumber = $request->get('phone_number');
            $studentFirstName = $request->get('student_first_name');

            $check = Preadmission::where('father_mobile_number', $phoneNumber)->where('name', $studentFirstName)->first();
            if(!$check){

                $response = array(
                    'status' =>'new'
                );

            }else{

                $response = array(
                    'status' =>'exist',
                    'id' => $check->id
                );
            }

            return $response;
        }
    }
