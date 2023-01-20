<?php
    namespace App\Services;
    use App\Models\LoginOtp;
    use App\Repositories\StudentRepository;
    use App\Repositories\StaffRepository;
    use App\Repositories\MobileLoginRepository;
    use App\Repositories\UserRepository;
    use App\Repositories\OrganizationRepository;
    use App\Services\SMSTemplateService;
    use App\Repositories\InstitutionSMSTemplateRepository;
    use App\Repositories\LoginDeviceTokenRepository;
    use App\Repositories\AcademicYearMappingRepository;
    use App\Repositories\InstitutionRepository;
    use App\Services\ComposeMessageService;
    use Carbon\Carbon;
    use Helper;
    use Hash;
    use DB;

    class MobileLoginService {

        public function createMobileOTP($request){

            $studentRepository = new StudentRepository();
            $staffRepository = new StaffRepository();
            $mobileLoginRepository = new MobileLoginRepository();
            $userRepository = new UserRepository();
            $smsTemplateService = new SMSTemplateService();
            $institutionSMSTemplateRepository = new InstitutionSMSTemplateRepository();
            $composeMessageService = new ComposeMessageService();
            $academicYearMappingRepository = new AcademicYearMappingRepository();
            $institutionRepository = new InstitutionRepository();
            $organizationRepository = new OrganizationRepository();

            $signal = $msg = $otp = $OTP_Message = $primaryNumber = $secondaryNumber = '';

            if(isset($request->institutionId) && isset($request->mobile)){

                $institutionId = $request->institutionId;
                $mobileNumber = $request->mobile;
                
                $organizationData = $organizationRepository->fetch($institutionId);
                if($organizationData){
                    $institutionName = $organizationData->name;
                }else{
                    $institutionData = $institutionRepository->fetch($institutionId);
                    $institutionName = $institutionData->name;
                }
                
                $staffData = $staffRepository->userExist($mobileNumber);
                if($staffData){

                    $primaryNumber = $staffData->primary_contact_no;
                    $secondaryNumber = $staffData->secondary_contact_no;

                }else{
                    $studentData = $studentRepository->userExist($mobileNumber);
                    if($studentData){

                        $primaryNumber = $studentData->father_mobile_number;
                        $secondaryNumber = $studentData->mother_mobile_number;

                    }
                }

                if($primaryNumber === $mobileNumber || $secondaryNumber === $mobileNumber){

                    $checkUserExistence = $userRepository->fetch($mobileNumber);
                    if($checkUserExistence){

                        $signal = 'already_loggedin';
                        $msg = "mPIN already created";

                    }else{

                        $getLoginOtpStatus = $mobileLoginRepository->getLoginStatus($request);
                        if($getLoginOtpStatus){

                            if($getLoginOtpStatus->otp_used_status === 'YES'){

                                $otp = rand(100000, 999999);

                                $getLoginOtpStatus->otp = $otp;
                                $getLoginOtpStatus->otp_used_status = 'NO';

                                $loginOtpStatus = $mobileLoginRepository->update($getLoginOtpStatus);

                            }else{
                                $otp = $getLoginOtpStatus->otp;
                            }

                            $OTP_Message = $otp;

                        }else{
                            $otp = rand(100000, 999999);

                            $data = array(
                                'id_institute' => $institutionId,
                                'mobile_number' => $mobileNumber,
                                'otp' => $otp,
                                'otp_used_status' => 'NO'
                            );
                            $loginOtpStatus = $mobileLoginRepository->store($data);

                        }

                        $signal = "success";
                        $msg = "The OTP is sent to your number";
                        $OTP_Message = $otp;

                        if($signal == 'success'){
                            $reportDetails = array();
                            $smsTemplateDetails = $institutionSMSTemplateRepository->getData('OTP', $institutionId);
                            $academicYearMappingDetails = $academicYearMappingRepository->getInstitutionDefaultAcademics($institutionId);

                            if($smsTemplateDetails){
                                $senderId           = $smsTemplateDetails->sender_id;
                                $smsTemplateId      = $smsTemplateDetails->sms_template_id;

                                $smsDetails = $smsTemplateService->find($smsTemplateId);

                                $description = $smsDetails->template_detail;
                                $templateId  = $smsDetails->template_id;
                            }else{
                                $senderId    = 'EGNIUS';
                                $templateId  = '1707161950720971743';
                                $description = "Dear User, OTP for Mobile App login is ".$otp.".".$institutionName."(by eGenius)";
                            }

                            $reportDetails['institution_id'] = $institutionId;
                            $reportDetails['academic_id'] = $academicYearMappingDetails->idAcademicMapping;
                            $reportDetails['id_message_center'] = 0;
                            $reportDetails['message_type'] = 'OTP';
                            $reportDetails['sender_id'] = $senderId;
                            $reportDetails['recipient_type'] = 'MOBILE_LOGIN_OTP';
                            $reportDetails['id_recipient'] = '-';
                            $reportDetails['recipient_number'] = $mobileNumber;
                            $reportDetails['sms_description'] = $description;

                            $storeReportData = $composeMessageService->addOTPMessageReportData($reportDetails);
                            
                            if($storeReportData){
                                $sendMessage =  $composeMessageService->sendOTPMessage($storeReportData->id, $templateId);
                            }
                        }
                    }
                }else{
                    $signal = "invalid_number";
                    $msg = "This number is not registered with us";
                }
            }else{
                $signal = 'failure';
                $msg = 'Incorrect parameter';
            }

            $output = array(
                'signal' => $signal,
                'msg' => $msg,
                'otp' => $OTP_Message
            );

            return $output;
        }

        public function createWebOTP($mobile){

            $studentRepository = new StudentRepository();
            $staffRepository = new StaffRepository();
            $mobileLoginRepository = new MobileLoginRepository();
            $userRepository = new UserRepository();
            $organizationRepository = new OrganizationRepository();
            $smsTemplateService = new SMSTemplateService();
            $institutionSMSTemplateRepository = new InstitutionSMSTemplateRepository();
            $composeMessageService = new ComposeMessageService();
            $academicYearMappingRepository = new AcademicYearMappingRepository();

            $output = $otp = $OTP_Message = $signal = '';

            $checkUserExistence = $userRepository->fetch($mobile);
            // dd($checkUserExistence);
            if($checkUserExistence){
                $signal = 'already_loggedin';
            }else{

                $staffCheckData = $staffRepository->userExist($mobile);
                $studentCheckData = $studentRepository->userExist($mobile);

                if($staffCheckData){
                    $idOrganization = $staffCheckData->id_organization;
                    $idInstitution = $staffCheckData->id_institute;
                }else if($studentCheckData){
                    $idOrganization = $studentCheckData->id_organization;
                    $idInstitution = $studentCheckData->id_institute;
                }else{
                    $idOrganization = "";
                    $idInstitution = "";
                }

                if($staffCheckData || $studentCheckData){

                    if($idOrganization != ''){

                        $domainDetail = $organizationRepository->fetch($idOrganization);
                        // dd($domainDetail);
                        if($domainDetail->type === 'SINGLE'){

                            if($domainDetail->website_url === $_SERVER['HTTP_HOST']){

                                $getLoginOtpStatus = $mobileLoginRepository->getLoginStatus($mobile);
                                if($getLoginOtpStatus){

                                    if($getLoginOtpStatus->otp_used_status === 'YES'){

                                        $checkUserData = $userRepository->fetch($mobile);
                                        if($checkUserData){

                                            $signal = 'data_exist';

                                        }else{
                                            $otp = rand(100000, 999999);

                                            $getLoginOtpStatus->otp = $otp;
                                            $getLoginOtpStatus->otp_used_status = 'NO';

                                            $loginOtpStatus = $mobileLoginRepository->update($getLoginOtpStatus);
                                            if($loginOtpStatus){
                                                $OTP_Message = $otp;
                                                $signal = 'success';
                                            }else{
                                                $signal = 'failure';
                                            }
                                        }

                                    }else{
                                        $otp = $getLoginOtpStatus->otp;
                                    }

                                    $OTP_Message = $otp;
                                    $signal = 'success';

                                }else{

                                    $otp = rand(100000, 999999);

                                    $data = array(
                                        'mobile_number' => $mobile,
                                        'otp' => $otp,
                                        'otp_used_status' => 'NO'
                                    );
                                    $loginOtpStatus = $mobileLoginRepository->store($data);
                                    if($loginOtpStatus){
                                        $OTP_Message = $otp;
                                        $signal = 'success';
                                    }else{
                                        $signal = 'failure';
                                    }
                                }

                            }else{
                                $signal = 'invalid_user';
                            }
                        }else{

                            if($idInstitution != ''){
                                //staff or student
                                $domainDetail = $institutionRepository->fetch($idInstitution);
                                if($domainDetail->website_url === $_SERVER['HTTP_HOST']){

                                    $getLoginOtpStatus = $mobileLoginRepository->getLoginStatus($mobile);
                                    if($getLoginOtpStatus){

                                        if($getLoginOtpStatus->otp_used_status === 'YES'){

                                            $checkUserData = $userRepository->fetch($mobile);
                                            if($checkUserData){
                                                $signal = 'data_exist';
                                            }else{
                                                $otp = rand(100000, 999999);

                                                $getLoginOtpStatus->otp = $otp;
                                                $getLoginOtpStatus->otp_used_status = 'NO';

                                                $loginOtpStatus = $mobileLoginRepository->update($getLoginOtpStatus);
                                                if($loginOtpStatus){
                                                    $OTP_Message = $otp;
                                                    $signal = 'success';
                                                }else{
                                                    $signal = 'failure';
                                                }
                                            }

                                        }else{
                                            $otp = $getLoginOtpStatus->otp;
                                        }

                                        $OTP_Message = $otp;
                                        $signal = 'success';

                                    }else{

                                        $otp = rand(100000, 999999);

                                        $data = array(
                                            'mobile_number' => $mobile,
                                            'otp' => $otp,
                                            'otp_used_status' => 'NO'
                                        );
                                        $loginOtpStatus = $mobileLoginRepository->store($data);
                                        if($loginOtpStatus){
                                            $OTP_Message = $otp;
                                            $signal = 'success';
                                        }else{
                                            $signal = 'failure';
                                        }
                                    }

                                }else{
                                    $signal = 'invalid_user';
                                }
                            }else{
                                $signal = 'invalid_user';
                            }
                        }
                    }else{
                        $signal = 'invalid_user';
                    }

                }else{
                    $signal = 'invalid_user';
                }
            }
            if($signal == 'success'){
                $reportDetails = array();
                $smsTemplateDetails = $institutionSMSTemplateRepository->getData('OTP', $idInstitution);
                $academicYearMappingDetails = $academicYearMappingRepository->getInstitutionDefaultAcademics($idInstitution);
                if($smsTemplateDetails){

                    $senderId           = $smsTemplateDetails->sender_id;
                    $smsTemplateId      = $smsTemplateDetails->sms_template_id;

                    $smsDetails = $smsTemplateService->find($smsTemplateId);

                    $description = $smsDetails->template_detail;
                    $templateId  = $smsDetails->template_id;

                }else{

                    $senderId    = 'EGNIUS';
                    $templateId  = '1707161950720971743';
                    $description = "Dear User, OTP for Mobile App login is ".$otp.".".$domainDetail->name."(by eGenius)";
                }

                $reportDetails['institution_id'] = $idInstitution;
                $reportDetails['academic_id'] = $academicYearMappingDetails->idAcademicMapping;
                $reportDetails['id_message_center'] = 0;
                $reportDetails['message_type'] = 'OTP';
                $reportDetails['sender_id'] = $senderId;
                $reportDetails['recipient_type'] = 'REGISTRATION';
                $reportDetails['id_recipient'] = '-';
                $reportDetails['recipient_number'] = $mobile;
                $reportDetails['sms_description'] = $description;

                $storeReportData = $composeMessageService->addOTPMessageReportData($reportDetails);
                
                if($storeReportData){
                    $sendMessage =  $composeMessageService->sendOTPMessage($storeReportData->id, $templateId);
                }
            }

            $output = array(
                'signal' => $signal,
                'otp' => $OTP_Message
            );

            // dd($output);
            return $output;
        }

        public function loginWithOTP($request){

            $mobileLoginRepository = new MobileLoginRepository();
            $mobile = $request->mobile;
            $otp = $request->otp;
            $output = '';

            $checkData = $mobileLoginRepository->checkValidLogin($mobile, $otp);
            if($checkData){
                $getLoginOtpStatus = $mobileLoginRepository->getLoginStatus($mobile);

                $getLoginOtpStatus->otp_used_status = 'YES';
                $loginOtpStatus = $mobileLoginRepository->update($getLoginOtpStatus);

                $output = array(
                    'signal' => "success",
                    'msg' => "Please set your four digit mPIN"
                );

            }else{

                $output = array(
                    'signal' => "invalid_otp",
                    'msg' => "Please enter valid OTP"
                );

            }
            return $output;
        }

        public function createmPIN($request){
            // dd($request->phone);
            $userRepository = new UserRepository();
            $output = '';

            $data = array(
                'username' => $request->username,
                'password' => Hash::make($request->password)
            );

            $storeData = $userRepository->store($data);

            if($storeData) {

                $signal = 'success';
                $msg = 'mPIN set successfully!';

            }else{

                $signal = 'failure';
                $msg = 'Error inserting data!';

            }

            $output = array(
                'signal' => $signal,
                'msg' => $msg
            );

            return $output;
        }

        public function mobileLogin($request){

            $mobileLoginRepository = new MobileLoginRepository();
            $mobile = $request->mobile;
            $otp = $request->otp;
            $output = '';

            $checkData = $mobileLoginRepository->checkValidLogin($mobile, $otp);
            if($checkData){

                $output = array(
                    'signal' => "success",
                    'msg' => "Please set your four digit mPIN"
                );

            }else{

                $output = array(
                    'signal' => "invalid_otp",
                    'msg' => "Please enter valid OTP"
                );

            }
            return $output;
        }

        public function loginWithmPIN($request){

            $mobileLoginRepository = new MobileLoginRepository();
            $menuPermissionService = new MenuPermissionService();
            $userRepository = new UserRepository();
            $staffRepository = new StaffRepository();
            $studentRepository = new StudentRepository();
            $staffService = new StaffService();
            $studentService = new StudentService();
            $roleRepository = new RoleRepository();
            $loginDeviceTokenRepository = new LoginDeviceTokenRepository();

            $mobile = $request->username;
            $mPIN = Hash::make($request->password);
            $deviceToken = $request->deviceToken;

            $userList = array();
            $output = '';

            $staffData = $staffRepository->userExist($mobile);
            $studentData = $studentRepository->userExist($mobile);
            if($staffData || $studentData){
                $checkUserExistence = $userRepository->fetch($mobile);
                if($checkUserExistence){
                    $checkLogin = $userRepository->checkMobileLoginData($mobile, $mPIN);
                    if($checkLogin){

                        //INSERT DEVICE TOKEN
                        $deviceData = array(
                            'mobile' => $mobile,
                            'device_token' => $deviceToken
                        );
                        $storeDeviceToken = $loginDeviceTokenRepository->store($deviceData);
                        
                        //STAFF DATA
                        $staffData = $staffRepository->allStaffUser($mobile);
                        if($staffData){
                            foreach($staffData as $staff){
                                $staffDetail = $staffService->find($staff['id']);
                                $menuData = $menuPermissionService->roleMenuPermission($staff['id_role'], $staff['id_institute']);

                                array_push($userList, $staffDetail);
                                array_push($userList['menu'], $menuData);
                            }
                        }                        

                        // STUDENT DATA
                        $studentData = $studentRepository->allStudentUser($mobile);
                        if($studentData){
                            foreach($studentData as $student){

                                $roleData = $roleRepository->getRoleID('student');
                                $studentDetail = $studentService->find($student['id_student']);
                                $menuData = $menuPermissionService->roleMenuPermission($roleData['id'], $student['id_institute']);

                                array_push($userList, $studentDetail);
                                array_push($userList['menu'], $menuData);
                            }
                        }  

                        $signal = "success";
                        $msg = "Login successful!";

                    }else{
                        $signal = "failure";
                        $msg = "Please set mPIN first";
                    }
                }else{
                    $signal = "failure";
                    $msg = "Please set mPIN first";
                }
            }else{
                $signal = "failure";
                $msg = "This number is not registered with us";
            }

            $output = array(
                'signal' => $signal,
                'msg' => $msg,
                'userList' => $userList
            );

            return $output;
        }

        public function mobileLogout($request){

            $loginDeviceTokenRepository = new LoginDeviceTokenRepository();

            $mobile = $request->username;
            $deviceToken = $request->deviceToken;

            $deleteDeviceToken = $loginDeviceTokenRepository->delete($mobile, $deviceToken);
            if($deleteDeviceToken){
                $output = array(
                    'signal' => 'success',
                    'msg' => 'Logged out successfully !'
                );
            }else{
                $output = array(
                    'signal' => 'failure',
                    'msg' => 'some error occured !'
                );
            }
            return $output;
        }

        public function refreshLogin($request){
            $mobileLoginRepository = new MobileLoginRepository();
            $menuPermissionService = new MenuPermissionService();
            $userRepository = new UserRepository();
            $staffRepository = new StaffRepository();
            $studentRepository = new StudentRepository();
            $staffService = new StaffService();
            $studentService = new StudentService();
            $roleRepository = new RoleRepository();
            $loginDeviceTokenRepository = new LoginDeviceTokenRepository();

            $mobile = $request->username;
            $deviceToken = $request->deviceToken;

            $userList = array();
            $output = '';

            $checkLogin = $loginDeviceTokenRepository->checkifDeviceExist($mobile, $deviceToken);
            if(!$checkLogin){

                //INSERT DEVICE TOKEN
                $deviceData = array(
                    'mobile' => $mobile,
                    'device_token' => $deviceToken
                );
                $storeDeviceToken = $loginDeviceTokenRepository->store($deviceData);
                        
            }else{
                $checkData = $loginDeviceTokenRepository->fetch($checkLogin->id);
                $checkData->device_token = $deviceToken;
                $storeDeviceToken = $loginDeviceTokenRepository->update($checkData);
            }
            if($storeDeviceToken){   
                //STAFF DATA
                $staffData = $staffRepository->allStaffUser($mobile);
                if($staffData){
                    foreach($staffData as $staff){
                        $staffDetail = $staffService->find($staff['id']);
                        $menuData = $menuPermissionService->roleMenuPermission($staff['id_role'], $staff['id_institute']);

                        array_push($userList, $staffDetail);
                        array_push($userList['menu'], $menuData);
                    }
                }                        

                // STUDENT DATA
                $studentData = $studentRepository->allStudentUser($mobile);
                if($studentData){
                    foreach($studentData as $student){

                        $roleData = $roleRepository->getRoleID('student');
                        $studentDetail = $studentService->find($student['id_student']);
                        $menuData = $menuPermissionService->roleMenuPermission($roleData['id'], $student['id_institute']);

                        array_push($userList, $studentDetail);
                        array_push($userList['menu'], $menuData);
                    }
                }  

                $signal = "success";
                $msg = "Login successful!";

            }else{
                $signal = "failure";
                $msg = "error in processing data";
            }

            $output = array(
                'signal' => $signal,
                'msg' => $msg,
                'userList' => $userList
            );

            return $output;
        }
    }

?>
