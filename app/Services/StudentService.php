<?php
    namespace App\Services;
    use App\Models\Student;
    use App\Repositories\StudentRepository;
    use Carbon\Carbon;
    use App\Repositories\GenderRepository;
    use App\Services\InstitutionStandardService;
    use App\Repositories\NationalityRepository;
    use App\Repositories\ReligionRepository;
    use App\Repositories\InstitutionFeeTypeMappingRepository;
    use App\Repositories\AdmissionTypeRepository;
    use App\Repositories\CategoryRepository;
    use App\Repositories\BloodGroupRepository;
    use App\Repositories\StudentMappingRepository;
    use App\Repositories\SubjectTypeRepository;
    use App\Repositories\SubjectRepository;
    use App\Repositories\StudentCustomRepository;
    use App\Repositories\CustomFieldRepository;
    use App\Repositories\InstitutionSubjectRepository;
    use App\Repositories\CustomFeeAssignHeadingRepository;
    use App\Repositories\FeeAssignRepository;
    use App\Repositories\FeeMasterRepository;
    use App\Repositories\CustomFeeAssignmentRepository;
    use App\Repositories\StudentElectivesRepository;
    use App\Repositories\FeeAssignDetailRepository;
    use App\Repositories\FeeAssignSettingRepository;
    use App\Repositories\FeeReceiptSettingRepository;
    use App\Repositories\FeeCategorySettingRepository;
    use App\Services\UploadService;
    use App\Services\StandardSubjectService;
    use App\Services\FeeAssignService;
    use Session;
    use DB;

    class StudentService {

        public function all(){

            $studentRepository = new StudentRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $studentDetails = $studentRepository->all();

            foreach($studentDetails as $index=> $studentData){

                $studentMappedDetails = $studentMappingRepository->fetchStudentMapping($studentData->id);

                foreach($studentMappedDetails as $index=>$mappedData){
                    $studentStandard = $mappedData['id_standard'];
                }

                $studentDataArray = array(
                    'student'=> $studentData,
                    'studentMappedData'=>$studentMappedDetails
                );

                $allStudentDetails[$studentData->id] = $studentDataArray;
            }

            return $allStudentDetails;
        }

        public function fetchStudents($request, $allSessions){

            $allStudent = array();

            if($request != ""){

                $institutionStandardService = new InstitutionStandardService();
                $studentMappingRepository = new StudentMappingRepository();
                $genderRepository = new GenderRepository();

                $allStudent = array();
                $fee_type = $gender = '';
                $standard = array();

                if(array_key_exists('standard', $request)){
                    $standard = $request['standard'];
                }

                if(array_key_exists('fee_type', $request)){
                    $fee_type = $request['fee_type'];
                }

                if(array_key_exists('gender', $request)){
                    $gender = $request['gender'];
                }

                $student = $studentMappingRepository->fetchInstitutionStudents($standard, $fee_type, $gender, $allSessions);

                foreach($student as $key => $data){

                    $standard = $institutionStandardService->fetchStandardByUsingId($data->id_standard);

                    if($data->father_mobile_number != ''){
                        $mobileNumber = $data->father_mobile_number;
                    }else{
                        $mobileNumber = $data->mother_mobile_number;
                    }

                    if($data->id_gender){

                        $genderData = $genderRepository->fetch($data->id_gender);

                        if($genderData){
                            $student_gender = $genderData->name;
                        }else{
                            $student_gender = '';
                        }

                    }else{
                        $student_gender = '';
                    }

                    $studentName = $studentMappingRepository->getFullName($data->name, $data->middle_name, $data->last_name);

                    $studentDetails = array(
                        'id_student'=>$data->id_student,
                        'UID'=>$data->egenius_uid,
                        'name'=>$studentName,
                        'class'=>$standard,
                        'father_name'=>$data->father_name,
                        'phone_number'=>$mobileNumber,
                        'gender'=>$student_gender
                    );

                    $allStudent[$key]= $studentDetails;
                }
            }

            return $allStudent;
        }

        public function fetchStandardStudents($idStandard, $allSessions){

            $institutionStandardService = new InstitutionStandardService();
            $studentMappingRepository = new StudentMappingRepository();
            $allStudent = array();

            $student = $studentMappingRepository->fetchInstitutionStandardStudents($idStandard, $allSessions);

            foreach($student as $key => $data){

                $standard = $institutionStandardService->fetchStandardByUsingId($data->id_standard);

                if($data->father_mobile_number != ''){
                    $mobileNumber = $data->father_mobile_number;
                }else{
                    $mobileNumber = $data->mother_mobile_number;
                }

                $studentDetails = array(
                    'id_student'=>$data->id_student,
                    'UID'=>$data->egenius_uid,
                    'name'=>$data->name,
                    'class'=>$standard,
                    'father_name'=>$data->name,
                    'phone_number'=>$mobileNumber,
                );

                $allStudent[$key]= $studentDetails;
            }

            return $allStudent;
        }

        public function fetchPromotionElligibleStudents($request, $allSessions){

            $institutionStandardService = new InstitutionStandardService();
            $studentMappingRepository = new StudentMappingRepository();
            $today = date('Y-m-d H:i:s');
            $allStudent = array();

            $student = $studentMappingRepository->fetchInstitutionPromotionElligibleStudents($request, $allSessions);

            foreach($student as $data){

                $lastUpdate = $studentMappingRepository->getLatestUpdate($data->id_student);
                $updatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $lastUpdate->updated_at)->format('Y-m-d H:i:s');
                $studentName = $studentMappingRepository->getFullName($data->name, $data->middle_name, $data->last_name);
                $standard = $institutionStandardService->fetchStandardByUsingId($data->id_standard);

                if($data->father_mobile_number != ''){
                    $mobileNumber = $data->father_mobile_number;
                }else{
                    $mobileNumber = $data->mother_mobile_number;
                }

                $diff = strtotime($today) - strtotime($updatedDate);
                $dateDiff = abs(ceil($diff / 86400) - 1);

                $studentDetails = array(
                    'id_student'=>$data->id_student,
                    'UID'=>$data->egenius_uid,
                    'name'=>$studentName,
                    'class'=>$standard,
                    'father_name'=>$data->name,
                    'phone_number'=>$mobileNumber,
                    'days_promoted_ago'=>$dateDiff
                );

                $allStudent[$data->id]= $studentDetails;
            }

            return $allStudent;
        }

        // Get particular Student
        public function find($id){

            $genderRepository = new GenderRepository();
            $institutionStandardService = new InstitutionStandardService();
            $standardSubjectService = new StandardSubjectService();
            $nationalityRepository = new NationalityRepository();
            $religionRepository = new ReligionRepository();
            $institutionFeeTypeMappingRepository = new InstitutionFeeTypeMappingRepository();
            $admissionTypeRepository = new AdmissionTypeRepository();
            $categoryRepository = new CategoryRepository();
            $bloodGroupRepository = new BloodGroupRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $subjectRepository = new SubjectRepository();
            $studentCustomRepository = new StudentCustomRepository();
            $studentElectivesRepository = new StudentElectivesRepository();

            $electiveSubjectIds = array();
            $studentDetails = $studentMappingRepository->fetchStudent($id);

            $studentName = $studentMappingRepository->getFullName($studentDetails->name, $studentDetails->middle_name, $studentDetails->last_name);
            $studentElectiveSubjects = $studentElectivesRepository->fetchStudentSubjects($id);

            foreach($studentElectiveSubjects as $subjectData){
                $electiveSubjectIds[] = $subjectData->id_elective;
            }

            $standardSubjects = $standardSubjectService->fetchSubject($studentDetails->id_standard);
            $standard = $institutionStandardService->fetchStandardByUsingId($studentDetails->id_standard);
            $firstLanguage = $subjectRepository->fetch($studentDetails->id_first_language);
            $secondLanguage = $subjectRepository->fetch($studentDetails->id_second_language);
            $thirdLanguage = $subjectRepository->fetch($studentDetails->id_third_language);
            $electiveSubject = $subjectRepository->fetch($studentDetails->id_elective);
            $feeType = $institutionFeeTypeMappingRepository->fetch($studentDetails->id_fee_type);
            $gender = $genderRepository->fetch($studentDetails->id_gender);
            $nationality = $nationalityRepository->fetch($studentDetails->id_nationality);
            $religion = $religionRepository->fetch($studentDetails->id_religion);
            $casteCategory = $categoryRepository->fetch($studentDetails->id_caste_category);
            $bloodGroup = $bloodGroupRepository->fetch($studentDetails->id_blood_group);
            $birthDate = date('d-m-Y', strtotime($studentDetails->date_of_birth));
            $currentDate = date("d-m-Y");
            $age = date_diff(date_create($birthDate), date_create($currentDate));
            $currentAge = $age->format("%y");

            $studentDetails['standard'] = $standard;

            if($firstLanguage){
                $studentDetails['first_language'] = $firstLanguage->name;
            }else{
                $studentDetails['first_language'] = '';
            }

            if($secondLanguage){
                $studentDetails['second_language'] = $secondLanguage->name;
            }else{
                $studentDetails['second_language'] = '';
            }

            if($thirdLanguage){
                $studentDetails['third_language'] = $thirdLanguage->name;
            }else{
                $studentDetails['third_language'] = '';
            }

            if($electiveSubject){
                $studentDetails['elective'] = $electiveSubject->name;
            }else{
                $studentDetails['elective'] = '';
            }

            if($feeType){
                $studentDetails['fee_type'] = $feeType->name;
            }else{
                $studentDetails['fee_type'] = '';
            }

            if($gender){
                $studentDetails['gender'] = $gender->name;
            }else{
                $studentDetails['gender'] = '';
            }

            if($nationality){
                $studentDetails['nationality'] = $nationality->name;
            }else{
                $studentDetails['nationality'] = '';
            }

            if($religion){
                $studentDetails['religion'] = $religion->name;
            }else{
                $studentDetails['religion'] = '';
            }

            if($casteCategory){
                $studentDetails['caste_category'] = $casteCategory->name;
            }else{
                $studentDetails['caste_category'] = '';
            }

            if($bloodGroup){
                $studentDetails['blood_group'] = $bloodGroup->name;
            }else{
                $studentDetails['blood_group'] = '';
            }

            $studentDetails['current_age'] = $currentAge;
            $studentDetails['standard_subjects'] = $standardSubjects;
            $studentDetails['selected_elective'] = $electiveSubjectIds;
            $studentDetails['studentName'] = $studentName;
            //dd($studentDetails);
            return $studentDetails;
        }

        // Custom field values details
        public function fetchCustomFieldValues($id){

            $studentCustomRepository = new StudentCustomRepository();
            $customFieldRepository = new CustomFieldRepository();
            $customFieldValues = $studentCustomRepository->fetch($id);

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

        // Custom file value details
        public function fetchCustomFileValues($id){

            $studentCustomRepository = new StudentCustomRepository();
            $customFieldRepository = new CustomFieldRepository();
            $customFileDetails = array();

            $customFieldValues = $studentCustomRepository->fetch($id);

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

        public function getFieldDetails($allSessions){

            $genderRepository = new GenderRepository();
            $institutionStandardService = new InstitutionStandardService();
            $nationalityRepository = new NationalityRepository();
            $religionRepository = new ReligionRepository();
            $institutionFeeTypeMappingRepository = new InstitutionFeeTypeMappingRepository();
            $admissionTypeRepository = new AdmissionTypeRepository();
            $categoryRepository = new CategoryRepository();
            $bloodGroupRepository = new BloodGroupRepository();
            $gender = $genderRepository->all();
            $standard = $institutionStandardService->fetchStandard($allSessions);

            // $standard = [{"institutionStandard_id" => 1, "class" => "1A"}];
            $nationality = $nationalityRepository->all();
            $religion = $religionRepository->all();
            $feeType = $institutionFeeTypeMappingRepository->getInstitutionFeetype($allSessions);
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
            // dd($fieldDetails);
            return $fieldDetails;
        }

        // Insert Student
        public function add($studentData){

            $institutionId = $studentData->id_institute;
            $organizationId = $studentData->organization;
            $academicYear = $studentData->id_academic;

            $studentRepository = new StudentRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $studentCustomRepository = new StudentCustomRepository();
            $customFieldRepository = new CustomFieldRepository();
            $customFeeAssignHeadingRepository = new CustomFeeAssignHeadingRepository();
            $customFeeAssignmentRepository = new CustomFeeAssignmentRepository();
            $feeAssignRepository = new FeeAssignRepository();
            $feeMasterRepository = new FeeMasterRepository();
            $studentElectivesRepository = new StudentElectivesRepository();
            $feeAssignDetailRepository = new FeeAssignDetailRepository();
            $uploadService = new UploadService();
            $feeAssignSettingRepository = new FeeAssignSettingRepository();
            $feeCategorySettingRepository = new FeeCategorySettingRepository();
            $feeAssignService = new FeeAssignService();

            $check = Student::where('name', $studentData->student_name)
                            ->where('father_mobile_number', $studentData->father_mobile_number)
                            ->first();

            if(!$check){

                $firstLanguage = $secondLanguage = $thirdLanguage = $electiveSubject ='';
                $dateOfBirth = Carbon::createFromFormat('d/m/Y', $studentData->date_of_birth)->format('Y-m-d');
                $admissionDate = Carbon::createFromFormat('d/m/Y', $studentData->admission_date)->format('Y-m-d');

                // S3 file upload
                if($studentData->hasfile('student_profile')){
                    $path = 'Student/Profile';
                    $studentProfile = $uploadService->resizeUpload($studentData->student_profile, $path);
                }else{
                    $studentProfile = '';
                }

                if($studentData->hasfile('student_aadhaar_card_attachement')){
                    $path = 'Student/Adhaar';
                    $studentAadhaarCardAttachement = $uploadService->fileUpload($studentData->student_aadhaar_card_attachement, $path);
                }else{
                    $studentAadhaarCardAttachement = '';
                }

                if($studentData->hasfile('father_aadhaar_card_attachment')){
                    $path = 'Student/Adhaar';
                    $fatherAadhaarardAttachment = $uploadService->fileUpload($studentData->father_aadhaar_card_attachment, $path);
                }else{
                    $fatherAadhaarardAttachment = '';
                }

                if($studentData->hasfile('mother_aadhaar_card_attachment')){
                    $path = 'Student/Adhaar';
                    $motherAadhaarCardAttachment = $uploadService->fileUpload($studentData->mother_aadhaar_card_attachment, $path);
                }else{
                    $motherAadhaarCardAttachment = '';
                }

                if($studentData->hasfile('father_pan_card_attachment')){
                    $path = 'Student/PAN';
                    $fatherPanCardAttachment = $uploadService->fileUpload($studentData->father_pan_card_attachment, $path);
                }else{
                    $fatherPanCardAttachment = '';
                }

                if($studentData->hasfile('mother_pan_card_attachment')){
                    $path = 'Student/PAN';
                    $motherPanCardAttachment = $uploadService->fileUpload($studentData->mother_pan_card_attachment, $path);
                }else{
                    $motherPanCardAttachment = '';
                }

                if($studentData->hasfile('previous_tc_attachment')){
                    $path = 'Student/Transfer_Certificates';
                    $previousTcAttachment = $uploadService->fileUpload($studentData->previous_tc_attachment, $path);
                }else{
                    $previousTcAttachment = '';
                }

                if($studentData->hasfile('previous_study_certificate_attachment')){
                    $path = 'Student/Study_Certificates';
                    $previousStudyCertificateAttachment = $uploadService->fileUpload($studentData->previous_study_certificate_attachment, $path);
                }else{
                    $previousStudyCertificateAttachment = '';
                }

                $preadmissonId = '';
                $egeniusUid = $studentRepository->getMaxStudentId();

                $data = array(
                    'id_preadmission' => $preadmissonId,
                    'name' => $studentData->student_first_name,
                    'middle_name' => $studentData->student_middle_name,
                    'last_name' => $studentData->student_last_name,
                    'date_of_birth' => $dateOfBirth,
                    'id_gender' => $studentData->gender,
                    'egenius_uid' => $egeniusUid,
                    'usn' => $studentData->usn,
                    'register_number' => $studentData->register_number,
                    'roll_number' => $studentData->rollnumber,
                    'admission_date' => $admissionDate,
                    'admission_number' => $studentData->admission_number,
                    'sats_number' => $studentData->sats_number,
                    'student_aadhaar_number' => $studentData->student_aadhaar_number,
                    'id_nationality' => $studentData->nationality,
                    'id_religion' => $studentData->religion,
                    'caste' => $studentData->caste,
                    'id_caste_category' => $studentData->caste_category,
                    'mother_tongue' => $studentData->mother_tongue,
                    'id_blood_group' => $studentData->blood_group,
                    'address' => $studentData->student_address,
                    'city' =>  $studentData->student_city,
                    'taluk' => $studentData->student_taluk,
                    'district' => $studentData->student_district,
                    'state' => $studentData->student_state,
                    'country' => $studentData->student_country,
                    'pincode' => $studentData->student_pincode,
                    'post_office' => $studentData->student_post_office,
                    'father_name' => $studentData->father_first_name,
                    'father_middle_name' => $studentData->father_middle_name,
                    'father_last_name' => $studentData->father_last_name,
                    'father_mobile_number' => $studentData->father_mobile_number,
                    'father_aadhaar_number' => $studentData->father_aadhaar_number,
                    'father_education' => $studentData->father_education,
                    'father_profession' => $studentData->father_profession,
                    'father_email' => $studentData->father_email_id,
                    'father_annual_income' => $studentData->father_annual_income,
                    'mother_name' => $studentData->mother_first_name,
                    'mother_middle_name' => $studentData->mother_middle_name,
                    'mother_last_name' => $studentData->mother_last_name,
                    'mother_mobile_number' => $studentData->mother_mobile_number,
                    'mother_aadhaar_number' => $studentData->mother_aadhaar_number,
                    'mother_education' => $studentData->mother_education,
                    'mother_profession' => $studentData->mother_profession,
                    'mother_email' => $studentData->mother_email_id,
                    'mother_annual_income' => $studentData->mother_annual_income,
                    'guardian_name' => $studentData->guardian_first_name,
                    'guardian_middle_name' => $studentData->guardian_middle_name,
                    'guardian_last_name' => $studentData->guardian_last_name,
                    'guardian_aadhaar_no' => $studentData->guardian_aadhaar_number,
                    'guardian_contact_no' => $studentData->guardian_phone,
                    'guardian_email' => $studentData->guardian_email_id,
                    'guardian_relation' => $studentData->relation_with_guardian,
                    'guardian_address' => $studentData->guardian_addresss,
                    'sms_for' => $studentData->sms_sent_for,
                    'attachment_student_photo' => $studentProfile,
                    'attachment_student_aadhaar' => $studentAadhaarCardAttachement,
                    'attachment_father_aadhaar' => $fatherAadhaarardAttachment,
                    'attachment_mother_aadhaar' => $motherAadhaarCardAttachment,
                    'attachment_father_pancard' => $fatherPanCardAttachment,
                    'attachment_mother_pancard' => $motherPanCardAttachment,
                    'attachment_previous_tc' => $previousTcAttachment,
                    'attachment_previous_study_certificate' => $previousStudyCertificateAttachment,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );

                $response = $studentRepository->store($data);

                if($response){

                    $lastInsertedId = $response->id;

                    if($studentData->first_language != ''){
                        $firstLanguage = $studentData->first_language;
                    }

                    if($studentData->second_language != ''){
                        $secondLanguage = $studentData->second_language;
                    }

                    if($studentData->third_language != ''){
                        $thirdLanguage = $studentData->third_language;
                    }

                    // Insert student mapping
                    if($studentData->standard !=''){

                        $data = array(
                            'id_student' => $lastInsertedId,
                            'id_standard' => $studentData->standard,
                            'id_institute' => $institutionId,
                            'id_organization' => $organizationId,
                            'id_academic_year' => $academicYear,
                            'id_first_language' => $firstLanguage,
                            'id_second_language' => $secondLanguage,
                            'id_third_language' => $thirdLanguage,
                            'id_fee_type' => $studentData->fee_type,
                            'created_by' => Session::get('userId'),
                            'created_at' => Carbon::now()
                        );

                        $storeStudentData = $studentMappingRepository->store($data);
                    }

                    // Electives
                    if($studentData->elective_subject != ''){

                        foreach($studentData->elective_subject as $electiveSubjcts){

                            $electiveSubjects = explode('||', $electiveSubjcts);

                            foreach($electiveSubjects as $elective){

                                $data = array(
                                    'id_student' => $lastInsertedId,
                                    'id_institute' => $institutionId,
                                    'id_academic_year' => $academicYear,
                                    'id_elective' => $elective,
                                    'created_by' => Session::get('userId'),
                                    'created_at' => Carbon::now()
                                );
                                $storeStudentData = $studentElectivesRepository->store($data);
                            }
                        }
                    }

                    // Insert custom field
                    $studentCustoms = $customFieldRepository->fetchCustomField($institutionId, 'student');

                    foreach($studentCustoms as $index=> $field){

                        $customFieldId = $field->id;

                        if($field->field_type == 'file'){

                            if($studentData->hasfile($customFieldId)){
                                $path = 'Student/CustomFiles';
                                $customFieldValue = $uploadService->fileUpload($studentData->$customFieldId, $path);
                            }else{
                                $customFieldValue = '';
                            }

                        }else if($field->field_type == 'datepicker'){
                            $customFieldValue = Carbon::createFromFormat('d/m/Y', $studentData->$customFieldId)->format('Y-m-d');

                        }else if($field->field_type == 'multiple_select'){
                            $customFieldValue = implode(',', $studentData->$customFieldId);

                        }else if($studentData->$customFieldId != ''){
                            $customFieldValue = $studentData->$customFieldId;

                        }else{
                            $customFieldValue = '';
                        }

                        $customData = array(
                            'id_student'=>$lastInsertedId,
                            'id_custom_field'=>$customFieldId,
                            'field_value'=>$customFieldValue,
                            'created_by' => Session::get('userId'),
                            'created_at' => Carbon::now()
                        );

                        $storeCustomData = $studentCustomRepository->store($customData);
                    }

                    // Fee assign
                    if(!empty($studentData->fee_type)){
                        $studentFeeAssign = $feeAssignService->assignFeeForStudent($studentData->standard, $studentData->fee_type, $idStudent);
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

        // Update Student
        public function update($studentData, $id){

            $institutionId = $studentData->id_institute;
            $organizationId = $studentData->organization;
            $academicYear = $studentData->id_academic;

            $studentRepository = new StudentRepository();
            $studentCustomRepository = new StudentCustomRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $customFieldRepository = new CustomFieldRepository();
            $customFeeAssignHeadingRepository = new CustomFeeAssignHeadingRepository();
            $customFeeAssignmentRepository = new CustomFeeAssignmentRepository();
            $studentElectivesRepository = new StudentElectivesRepository();
            $uploadService = new UploadService();
            $feeAssignRepository = new FeeAssignRepository();
            $feeMasterRepository = new FeeMasterRepository();
            $feeAssignDetailRepository = new FeeAssignDetailRepository();
            $feeAssignSettingRepository = new FeeAssignSettingRepository();
            $feeCategorySettingRepository = new FeeCategorySettingRepository();
            $feeAssignService = new FeeAssignService();

            $check = Student::where('name', $studentData->student_name)
                            ->where('father_mobile_number', $studentData->father_mobile_number)
                            ->where('id', '!=', $id)
                            ->first();

            if(!$check){

                $data = $studentRepository->fetch($id);

                $dateOfBirth = Carbon::createFromFormat('d/m/Y', $studentData->date_of_birth)->format('Y-m-d');
                $admissionDate = Carbon::createFromFormat('d/m/Y', $studentData->admission_date)->format('Y-m-d');

                if($studentData->usn !=''){
                    $usn = $studentData->usn;
                }else{
                    $usn = 0;
                }

                // S3 file upload function call
                if($studentData->hasfile('student_profile')){
                    $path = 'Student/Profile';
                    $studentProfile = $uploadService->resizeUpload($studentData->student_profile, $path);
                }else{
                    $studentProfile = $studentData->old_student_profile;
                }

                if($studentData->hasfile('student_aadhaar_card_attachement')){
                    $path = 'Student/Adhaar';
                    $studentAadhaarCardAttachement = $uploadService->fileUpload($studentData->student_aadhaar_card_attachement, $path);
                }else{
                    $studentAadhaarCardAttachement = $studentData->old_student_aadhaar_card_attachement;
                }

                if($studentData->hasfile('father_aadhaar_card_attachment')){
                    $path = 'Student/Adhaar';
                    $fatherAadhaarardAttachment = $uploadService->fileUpload($studentData->father_aadhaar_card_attachment, $path);
                }else{
                    $fatherAadhaarardAttachment = $studentData->old_father_aadhaar_card_attachment;
                }

                if($studentData->hasfile('mother_aadhaar_card_attachment')){
                    $path = 'Student/Adhaar';
                    $motherAadhaarCardAttachment = $uploadService->fileUpload($studentData->mother_aadhaar_card_attachment, $path);
                }else{
                    $motherAadhaarCardAttachment = $studentData->old_mother_aadhaar_card_attachment;
                }

                if($studentData->hasfile('father_pan_card_attachment')){
                    $path = 'Student/PAN';
                    $fatherPanCardAttachment = $uploadService->fileUpload($studentData->father_pan_card_attachment, $path);
                }else{
                    $fatherPanCardAttachment = $studentData->old_father_pan_card_attachment;
                }

                if($studentData->hasfile('mother_pan_card_attachment')){
                    $path = 'Student/PAN';
                    $motherPanCardAttachment = $uploadService->fileUpload($studentData->mother_pan_card_attachment, $path);
                }else{
                    $motherPanCardAttachment = $studentData->old_mother_pan_card_attachment;
                }

                if($studentData->hasfile('previous_tc_attachment')){
                    $path = 'Student/Transfer_Certificates';
                    $previousTcAttachment = $uploadService->fileUpload($studentData->previous_tc_attachment, $path);
                }else{
                    $previousTcAttachment = $studentData->old_previous_tc_attachment;
                }

                if($studentData->hasfile('previous_study_certificate_attachment')){
                    $path = 'Student/Study_Certificates';
                    $previousStudyCertificateAttachment = $uploadService->fileUpload($studentData->previous_study_certificate_attachment, $path);
                }else{
                    $previousStudyCertificateAttachment =  $studentData->old_previous_study_certificate_attachment;
                }

                $preadmissonId = '';

                $data->id_preadmission = $preadmissonId;
                $data->name = $studentData->student_first_name;
                $data->middle_name = $studentData->student_middle_name;
                $data->last_name = $studentData->student_last_name;
                $data->date_of_birth = $dateOfBirth;
                $data->id_gender = $studentData->gender;
                $data->usn = $usn;
                $data->register_number = $studentData->register_number;
                $data->roll_number = $studentData->rollnumber;
                $data->admission_date = $admissionDate;
                $data->admission_number = $studentData->admission_number;
                $data->sats_number = $studentData->sats_number;
                $data->student_aadhaar_number = $studentData->student_aadhaar_number;
                $data->id_nationality = $studentData->nationality;
                $data->id_religion = $studentData->religion;
                $data->caste = $studentData->caste;
                $data->id_caste_category = $studentData->caste_category;
                $data->mother_tongue = $studentData->mother_tongue;
                $data->id_blood_group = $studentData->blood_group;
                $data->address = $studentData->student_address;
                $data->city = $studentData->student_city;
                $data->taluk = $studentData->student_taluk;
                $data->state = $studentData->student_state;
                $data->district = $studentData->student_district;
                $data->country = $studentData->student_country;
                $data->pincode = $studentData->student_pincode;
                $data->father_name = $studentData->father_first_name;
                $data->father_middle_name = $studentData->father_middle_name;
                $data->father_last_name = $studentData->father_last_name;
                $data->father_mobile_number = $studentData->father_mobile_number;
                $data->father_aadhaar_number = $studentData->father_aadhaar_number;
                $data->father_education = $studentData->father_education;
                $data->father_profession = $studentData->father_profession;
                $data->father_email = $studentData->father_email_id;
                $data->father_annual_income = $studentData->father_annual_income;
                $data->mother_name = $studentData->mother_first_name;
                $data->mother_middle_name = $studentData->mother_middle_name;
                $data->mother_last_name = $studentData->mother_last_name;
                $data->mother_mobile_number = $studentData->mother_mobile_number;
                $data->mother_aadhaar_number = $studentData->mother_aadhaar_number;
                $data->mother_education = $studentData->mother_education;
                $data->mother_profession = $studentData->mother_profession;
                $data->mother_email = $studentData->mother_email_id;
                $data->mother_annual_income = $studentData->mother_annual_income;
                $data->guardian_name = $studentData->guardian_first_name;
                $data->guardian_middle_name = $studentData->guardian_middle_name;
                $data->guardian_last_name = $studentData->guardian_last_name;
                $data->guardian_aadhaar_no = $studentData->guardian_aadhaar_number;
                $data->guardian_contact_no = $studentData->guardian_phone;
                $data->guardian_email = $studentData->guardian_email_id;
                $data->guardian_relation = $studentData->relation_with_guardian;
                $data->guardian_address = $studentData->guardian_addresss;
                $data->sms_for = $studentData->sms_sent_for;
                $data->attachment_student_photo = $studentProfile;
                $data->attachment_student_aadhaar = $studentAadhaarCardAttachement;
                $data->attachment_father_aadhaar = $fatherAadhaarardAttachment;
                $data->attachment_mother_aadhaar = $motherAadhaarCardAttachment;
                $data->attachment_father_pancard = $fatherPanCardAttachment;
                $data->attachment_mother_pancard = $motherPanCardAttachment;
                $data->attachment_previous_tc = $previousTcAttachment;
                $data->attachment_previous_study_certificate = $previousStudyCertificateAttachment;
                $data->modified_by = Session::get('userId');
                $data->updated_at = Carbon::now();

                $response = $studentRepository->update($data);

                if($response){

                    if($studentData->standard !=''){

                        $studentMappingData = $studentMappingRepository->fetch($id);

                        $studentMappingData->id_organization = $organizationId;
                        $studentMappingData->id_standard = $studentData->standard;
                        $studentMappingData->id_first_language = $studentData->first_language;
                        $studentMappingData->id_second_language = $studentData->second_language;
                        $studentMappingData->id_third_language = $studentData->third_language;
                        $studentMappingData->id_fee_type = $studentData->fee_type;
                        $studentMappingData->modified_by = Session::get('userId');
                        $studentMappingData->updated_at = Carbon::now();

                        $mappingResponse = $studentMappingRepository->updateStudentMapping($studentMappingData);

                        if($mappingResponse){

                            // Electives
                            $deleteExistingElectives = $studentElectivesRepository->delete($id);

                            if($studentData->elective_subject != ''){

                                foreach($studentData->elective_subject as $electiveSubjcts){

                                    $electiveSubjects = explode('||', $electiveSubjcts);

                                    foreach($electiveSubjects as $elective){

                                        $data = array(
                                            'id_student' => $id,
                                            'id_institute' => $institutionId,
                                            'id_academic_year' => $academicYear,
                                            'id_elective' => $elective,
                                            'created_by' => Session::get('userId'),
                                            'created_at' => Carbon::now()
                                        );
                                        $storeStudentData = $studentElectivesRepository->store($data);
                                    }
                                }
                            }

                            // Custom fields updating
                            $preadmissionCustoms = $customFieldRepository->fetchCustomField($institutionId, 'student');
                            // dd($preadmissionCustoms);
                            foreach($preadmissionCustoms as $index => $field){

                                $customFieldId = $field->id;

                                if($field->field_type == 'file'){

                                    if($studentData->hasfile($customFieldId)){
                                        $path = 'Student/CustomFiles';
                                        $customFieldValue = $uploadService->fileUpload($studentData->$customFieldId, $path);
                                    }else{
                                        $oldImage =  'old_'.$customFieldId;
                                        $customFieldValue = $studentData->$oldImage;
                                    }

                                }else if($field->field_type == 'datepicker'){

                                    $customFieldValue = Carbon::createFromFormat('d/m/Y', $studentData->$customFieldId)->format('Y-m-d');

                                }else if($field->field_type == 'multiple_select'){

                                    if(isset($studentData->$customFieldId)){
                                        $customFieldValue = implode(',', $studentData->$customFieldId);
                                    }else{
                                        $customFieldValue = '';
                                    }

                                }else if($studentData->$customFieldId != ''){

                                    $customFieldValue = $studentData->$customFieldId;

                                }else{
                                    $customFieldValue = '';
                                }

                                // Custom fields update
                                $getCustomData = $studentCustomRepository->fetchExistingData($id, $field->id);

                                if($getCustomData){

                                    $getCustomData->field_value = $customFieldValue;
                                    $getCustomData->modified_by = Session::get('userId');
                                    $getCustomData->updated_at = Carbon::now();

                                    $storeCustomData = $studentCustomRepository->update($getCustomData);

                                }else{

                                    $customData = array(
                                        'id_student' => $id,
                                        'id_custom_field' => $field->id,
                                        'field_value' => $customFieldValue,
                                        'created_by' => Session::get('userId'),
                                        'created_at' => Carbon::now()
                                    );

                                    $storeCustomData = $studentCustomRepository->store($customData);
                                }
                            }

                            if(!empty($studentData->fee_type)){
                                $studentFeeAssign = $feeAssignService->assignFeeForStudent($studentData->standard, $studentData->fee_type, $id);
                                //dd($studentFeeAssign);
                            }

                            $signal = 'success';
                            $msg = 'Data Updated Successfully!';

                        }else{
                            $signal = 'failure';
                            $msg = 'Error updating data!';
                        }
                    }
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

        // Delete student
        public function delete($id){

            $studentMappingRepository = new StudentMappingRepository();
            $allSessions = session()->all();
            $student = $studentMappingRepository->fetchStudent($id, $allSessions);

            $idStudentMapping = $student->id;
            $studentMappingDeletion = $studentMappingRepository->delete($idStudentMapping);

            if($studentMappingDeletion){
                $signal = 'success';
                $msg = 'Data deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function getTableColumns(){

            $columnArray = ['gender', 'blood_group', 'caste_category', 'nationality', 'religion'];
            $allColumns = DB::getSchemaBuilder()->getColumnListing('tbl_student');

            $unNeededColumns = ['id', 'id_preadmission', 'id_gender', 'egenius_uid', 'id_blood_group', 'id_caste_category', 'id_nationality', 'id_religion', 'sms_for', 'attachment_student_photo', 'attachment_student_aadhaar', 'attachment_father_aadhaar', 'attachment_mother_aadhaar', 'attachment_father_pancard', 'attachment_mother_pancard', 'attachment_previous_tc', 'attachment_previous_study_certificate', 'created_by', 'modified_by', 'deleted_at', 'created_at', 'updated_at'];
            $neededColumns = array_diff($allColumns, $unNeededColumns);
            array_push($neededColumns, ...$columnArray);

            return $neededColumns;
        }

        public function fetchTableColumns(){

            //tobe added
            // , 'date_of_birth_in_words'
            $columnArray = ['salutation', 'son/daughter', 'student_name', 'student_standard', 'student_optional/elective', 'student_languages', 'uid', 'father_name', 'mother_name', 'gender', 'blood_group', 'caste_category', 'nationality', 'religion'];
            $allColumns = DB::getSchemaBuilder()->getColumnListing('tbl_student');

            $unNeededColumns = ['id', 'name', 'middle_name', 'last_name', 'father_name', 'father_middle_name', 'father_last_name', 'mother_name', 'mother_middle_name', 'mother_last_name', 'father_aadhaar_number', 'father_education', 'father_profession', 'father_annual_income', 'mother_aadhaar_number', 'mother_education', 'mother_profession', 'mother_annual_income', 'guardian_name', 'guardian_aadhaar_no', 'guardian_contact_no', 'guardian_email', 'guardian_relation', 'guardian_address', 'id_preadmission', 'id_gender', 'egenius_uid', 'id_blood_group', 'id_caste_category', 'id_nationality', 'id_religion', 'sms_for', 'attachment_student_photo', 'attachment_student_aadhaar', 'attachment_father_aadhaar', 'attachment_mother_aadhaar', 'attachment_father_pancard', 'attachment_mother_pancard', 'attachment_previous_tc', 'attachment_previous_study_certificate', 'created_by', 'modified_by', 'deleted_at', 'created_at', 'updated_at'];
            $neededColumns = array_diff($allColumns, $unNeededColumns);
            array_push($neededColumns, ...$columnArray);

            return $neededColumns;
        }

        public function getDeletedRecords($allSessions){

            $studentMappingRepository = new StudentMappingRepository();
            $institutionStandardService = new InstitutionStandardService();
            $genderRepository = new GenderRepository();
            $allStudent = array();
            $allDeletedStudents = $studentMappingRepository->allDeleted($allSessions);
            // dd($allDeletedStudents);
            if(count($allDeletedStudents) > 0){
                foreach($allDeletedStudents as $key => $data){

                    $standard = $institutionStandardService->fetchStandardByUsingId($data->id_standard);

                    if($data->father_mobile_number != ''){
                        $mobileNumber = $data->father_mobile_number;
                    }else{
                        $mobileNumber = $data->mother_mobile_number;
                    }

                    if($data->id_gender){

                        $genderData = $genderRepository->fetch($data->id_gender);

                        if($genderData){
                            $student_gender = $genderData->name;
                        }else{
                            $student_gender = '';
                        }

                    }else{
                        $student_gender = '';
                    }

                    $studentName = $studentMappingRepository->getFullName($data->name, $data->middle_name, $data->last_name);

                    $studentDetails = array(
                        'id'=>$data->id,
                        'UID'=>$data->egenius_uid,
                        'name'=>$studentName,
                        'class'=>$standard,
                        'father_name'=>$data->father_name,
                        'phone_number'=>$mobileNumber,
                        'gender'=>$student_gender
                    );

                    $allStudent[$key]= $studentDetails;
                }
            }
            //dd($allStudent);
            return $allStudent;
        }

        // Restore student records
        public function restore($id){

            $studentMappingRepository = new StudentMappingRepository();

            $students = $studentMappingRepository->restore($id);

            if($students){
                $signal = 'success';
                $msg = 'Data restored successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function restoreAll($allSessions){

            $studentMappingRepository = new StudentMappingRepository();
            $students = $studentMappingRepository->restoreAll($allSessions);

            if($students){
                $signal = 'success';
                $msg = 'Data restored successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function fetchStudentDetails($request, $allSessions){

            $institutionSubjectRepository = new InstitutionSubjectRepository();
            $subjectTypeRepository = new SubjectTypeRepository();
            $studentMappingRepository = new StudentMappingRepository();

            $allStudent = array();
            $subjectId = $request['subjectId'];
            $subjectData = $institutionSubjectRepository->find($subjectId);
            $subjectType = $subjectTypeRepository->fetchSubjectDetails($subjectData->id_subject);

            if($subjectType->label !='common'){
                $student = $studentMappingRepository->fetchStudentUsingSubject($request, $allSessions);
            }else{
                $student = $studentMappingRepository->fetchStudentUsingStandard($request['standardId'], $allSessions);
            }

            foreach($student as $data){

                $studentDetails = array(
                    'id_student'=>$data->id_student,
                    'name'=>$data->name,
                );

                $allStudent[]= $studentDetails;
            }

            return $allStudent;
        }

        // Get student based on standard and subject
        public function getAllStudent($request, $allSessions){

            $subjectIds = $request['subjectId'];
            $standardIds = $request['standardId'];

            $subjectService = new SubjectService();
            $subjectTypeRepository = new SubjectTypeRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $institutionSubjectRepository = new InstitutionSubjectRepository();
            $institutionSubjectService = new InstitutionSubjectService();
            $data['standardIds'] = $standardIds;
            $studentDetails = array();
            $studentId = array();
            $index = 0;

            foreach($subjectIds as $key => $subjectId){

                $data['subjectId'] = $subjectId;

                $subjectType = $institutionSubjectService->getSubjectLabel($subjectId, $allSessions);

                if($subjectType->label == 'common'){
                    $students = $studentMappingRepository->getStudentOnStandard($data, $allSessions);
                }else{
                    $students = $studentMappingRepository->getStudentOnSubject($data, $allSessions);
                }
                // dd($students);
                foreach($students as $details) {

                    if(!in_array($details->id_student, $studentId)){
                        $studentId[] = $details->id_student;
                        $studentDetails[$index]['id_student'] = $details->id_student;
                        $studentDetails[$index]['name'] = $studentName;
                    }

                    $index++;
                }
            }

            return $studentDetails;
        }

        // Convert to words
        function translateToWords($num){

            $ones = array(
                0 =>"ZERO",
                1 => "ONE",
                2 => "TWO",
                3 => "THREE",
                4 => "FOUR",
                5 => "FIVE",
                6 => "SIX",
                7 => "SEVEN",
                8 => "EIGHT",
                9 => "NINE",
                10 => "TEN",
                11 => "ELEVEN",
                12 => "TWELVE",
                13 => "THIRTEEN",
                14 => "FOURTEEN",
                15 => "FIFTEEN",
                16 => "SIXTEEN",
                17 => "SEVENTEEN",
                18 => "EIGHTEEN",
                19 => "NINETEEN",
                "014" => "FOURTEEN"
            );
            $tens = array(
                0 => "ZERO",
                1 => "TEN",
                2 => "TWENTY",
                3 => "THIRTY",
                4 => "FORTY",
                5 => "FIFTY",
                6 => "SIXTY",
                7 => "SEVENTY",
                8 => "EIGHTY",
                9 => "NINETY"
            );
            $hundreds = array(
                "HUNDRED",
                "THOUSAND",
                "MILLION",
                "BILLION",
                "TRILLION",
                "QUARDRILLION"
            ); /* limit t quadrillion */
            $num = number_format($num,2,".",",");
            $num_arr = explode(".",$num);
            $wholenum = $num_arr[0];
            $no_of_dordr = $num_arr[1];
            $whole_arr = array_reverse(explode(",",$wholenum));
            krsort($whole_arr,1);
            $response_txt = "";
            foreach($whole_arr as $key => $i){

                while(substr($i,0,1)=="0")
                    $i=substr($i,1,5);

                if($i < 20){
                /* echo "getting:".$i; */
                $response_txt .= $ones[$i];
                }elseif($i < 100){
                    if(substr($i,0,1)!="0")  $response_txt .= $tens[substr($i,0,1)];
                    if(substr($i,1,1)!="0") $response_txt .= " ".$ones[substr($i,1,1)];
                }else{
                    if(substr($i,0,1)!="0") $response_txt .= $ones[substr($i,0,1)]." ".$hundreds[0];
                    if(substr($i,1,1)!="0")$response_txt .= " ".$tens[substr($i,1,1)];
                    if(substr($i,2,1)!="0")$response_txt .= " ".$ones[substr($i,2,1)];
                }

                if($key > 0){
                    $response_txt .= " ".$hundreds[$key]." ";
                }
            }
            if($no_of_dordr > 0){
                $response_txt .= " and ";
                if($no_of_dordr < 20){
                    $response_txt .= $ones[$no_of_dordr];
                }elseif($no_of_dordr < 100){
                    $response_txt .= $tens[substr($no_of_dordr,0,1)];
                    $response_txt .= " ".$ones[substr($no_of_dordr,1,1)];
                }
            }
            return $response_txt;
        }

        public function findTokenData($idStudent){

            $genderRepository = new GenderRepository();
            $institutionStandardService = new InstitutionStandardService();
            $standardSubjectService = new StandardSubjectService();
            $nationalityRepository = new NationalityRepository();
            $religionRepository = new ReligionRepository();
            $institutionFeeTypeMappingRepository = new InstitutionFeeTypeMappingRepository();
            $admissionTypeRepository = new AdmissionTypeRepository();
            $categoryRepository = new CategoryRepository();
            $bloodGroupRepository = new BloodGroupRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $subjectRepository = new SubjectRepository();
            $studentCustomRepository = new StudentCustomRepository();

            $studentDetails = $studentMappingRepository->fetchStudent($idStudent);
            $standardSubjects = $standardSubjectService->fetchSubject($studentDetails->id_standard);
            $standard = $institutionStandardService->fetchStandardByUsingId($studentDetails->id_standard);

            $firstLanguage = $subjectRepository->fetch($studentDetails->id_first_language);
            $secondLanguage = $subjectRepository->fetch($studentDetails->id_second_language);
            $thirdLanguage = $subjectRepository->fetch($studentDetails->id_third_language);
            $feeType = $institutionFeeTypeMappingRepository->fetch($studentDetails->id_fee_type);
            $gender = $genderRepository->fetch($studentDetails->id_gender);
            $nationality = $nationalityRepository->fetch($studentDetails->id_nationality);
            $religion = $religionRepository->fetch($studentDetails->id_religion);
            $casteCategory = $categoryRepository->fetch($studentDetails->id_caste_category);
            $bloodGroup = $bloodGroupRepository->fetch($studentDetails->id_blood_group);
            $birthDate = date('d-m-Y', strtotime($studentDetails->date_of_birth));
            $currentDate = date("d-m-Y");
            $age = date_diff(date_create($birthDate), date_create($currentDate));
            $currentAge = $age->format("%y");

            $birth_date = $studentDetails->date_of_birth;

            // $new_birth_date = explode('-', $birth_date);
            // // dd($new_birth_date);
            // $year = $new_birth_date[0];

            // $month = $new_birth_date[1];
            // $day  = $new_birth_date[2];
            // $birth_day = $this->translateToWords($day);
            // // $birth_year = $this->translateToWords($year);
            // $monthNum = $month;
            // $dateObj = DateTime::createFromFormat('!m', $monthNum);//Convert the number into month name
            // $monthName = strtoupper($dateObj->format('F'));

            $studentDetails['first_language'] = $studentDetails['second_language'] = $studentDetails['third_language'] = $studentDetails['fee_type'] = $studentDetails['admission_type'] = $studentDetails['gender'] = $studentDetails['nationality'] = $studentDetails['religion'] = $studentDetails['caste_category'] = $studentDetails['blood_group'] = $studentDetails['salutation'] = $studentDetails['son/daughter'] = $studentDetails['student_standard'] = $studentDetails['student_optional/elective'] = $studentDetails['student_languages'] = $electives = $language = '';

            $studentDetails['student_standard'] = $standard;

            // Electives
            foreach($standardSubjects['all_elective_subject'] as $elective){
                $electives .= $elective['name'].', ';
            }

            $studentDetails['student_optional/elective']= substr($electives, 0, -2);

            if($firstLanguage){
                $studentDetails['first_language'] = $firstLanguage->name.', ';
            }

            if($secondLanguage){
                $studentDetails['second_language'] = $secondLanguage->name.', ';
            }

            if($thirdLanguage){
                $studentDetails['third_language'] = $thirdLanguage->name;
            }

            $studentDetails['student_languages']= $studentDetails['first_language'].$studentDetails['second_language'].$studentDetails['third_language'];

            if($feeType){
                $studentDetails['fee_type'] = $feeType->name;
            }

            if($gender){
                $studentDetails['gender'] = $gender->name;
            }

            if($gender->name === "Female"){
                $studentDetails['salutation'] = "Miss/Mrs.";
                $studentDetails['son/daughter'] = "Daughter";

            }else if($gender->name === "Male"){
                $studentDetails['salutation'] = "Mr.";
                $studentDetails['son/daughter'] = "Son";

            }else{
                $studentDetails['salutation'] = "";
                $studentDetails['son/daughter'] = "";
            }

            if($nationality){
                $studentDetails['nationality'] = $nationality->name;
            }

            if($religion){
                $studentDetails['religion'] = $religion->name;
            }

            if($casteCategory){
                $studentDetails['caste_category'] = $casteCategory->name;
            }

            if($bloodGroup){
                $studentDetails['blood_group'] = $bloodGroup->name;
            }

            if($studentDetails->middle_name != ''){
                $middleName = ' '.$studentDetails->middle_name;
            }else{
                $middleName = '';
            }

            if($studentDetails->father_middle_name != ''){
                $fatherMiddleName = ' '.$studentDetails->father_middle_name;
            }else{
                $fatherMiddleName = '';
            }

            if($studentDetails->mother_middle_name != ''){
                $motherMiddleName = ' '.$studentDetails->mother_middle_name;
            }else{
                $motherMiddleName = '';
            }

            // $studentDetails['date_of_birth_in_words'] = $birth_day.$monthName.$birth_year;

            $studentDetails['current_age'] = $currentAge;
            $studentDetails['date_of_birth'] = date('d/m/Y', strtotime($studentDetails->date_of_birth));
            $studentDetails['admission_date'] = date('d/m/Y', strtotime($studentDetails->admission_date));
            $studentDetails['uid'] = $studentDetails->egenius_uid;
            $studentDetails['student_name'] = $studentDetails->name.$middleName.' '.$studentDetails->last_name;
            $studentDetails['father_name'] = $studentDetails->father_name.$fatherMiddleName.' '.$studentDetails->father_last_name;
            $studentDetails['mother_name'] = $studentDetails->mother_name.$motherMiddleName.' '.$studentDetails->mother_last_name;
            $studentDetails['standard_subjects'] = $standardSubjects;

            return $studentDetails;
        }
    }
?>
