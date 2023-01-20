<?php 
    namespace App\Services;
    use App\Models\ComposeMessage;
    use App\Repositories\ComposeMessageRepository;
    use App\Repositories\MessageReportRepository;
    use App\Repositories\SMSTemplateRepository;
    use App\Repositories\MessageCreditRepository;
    use App\Repositories\StudentMappingRepository;
    use App\Repositories\InstitutionSMSTemplateRepository;
    use App\Repositories\StaffRepository;
    use App\Repositories\MessageSenderEntityRepository;
    use App\Repositories\StudentRepository;
    use App\Repositories\MessageGroupMembersRepository;
    use App\Repositories\StaffCategoryRepository;
    use App\Services\InstitutionStandardService;
    use App\Services\StudentDetentionService;
    use App\Services\MessageGroupNameService;
    use App\Services\InstitutionSMSTemplateService;
    use App\Repositories\InstitutionRepository;
    use Carbon\Carbon;
    use Session;
    

    class ComposeMessageService {

        public function getDetails() {

            $institutionSMSTemplateRepository = new InstitutionSMSTemplateRepository();
            $smsTemplateRepository = new SMSTemplateRepository();
            $staffCategoryRepository = new StaffCategoryRepository();
            $institutionStandardService = new InstitutionStandardService();
            $messageGroupNameService = new MessageGroupNameService();
            $messageGroupMembersRepository = new MessageGroupMembersRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $studentRepository = new StudentRepository();
            $staffRepository = new StaffRepository();
            $messageReportRepository = new MessageReportRepository(); 
            $smsTemplateDetails = array();
            $allDetails = array();
            $institutionStandardDetails = array();
            $request = '';
            $allStudentCount = $allStaffCount = $allCount = 0;

            $smsFor = 'MESSAGE_CENTER';
            $templateDetails = $institutionSMSTemplateRepository->fetchDetails($smsFor);            
            foreach($templateDetails as $smsTemplate) {
                $smsTemplate = $smsTemplateRepository->fetch($smsTemplate->sms_template_id);
                if($smsTemplate){
                    $smsTemplateDetails[] = $smsTemplate;
                }                
            }

            //STAFF DETAILS

            $staffDetails = $staffRepository->all($request);
            if($staffDetails) {
                $allStaffCount = count($staffDetails);
            }

            $staffCategoryData = $staffCategoryRepository->all();
            foreach($staffCategoryData as $index => $categoryDetails) {
                $staffCategoryDetails[$index] = $categoryDetails;
                $count = 0;
                if($categoryDetails->label == 'TEACHING'){

                    $teachingStaffDetails = $staffRepository->getTeachingStaff();
                    if($teachingStaffDetails) {
                        $count = count($teachingStaffDetails);
                    }
                }
                if($categoryDetails->label =='NONTEACHING'){

                    $nonTeachingStaffDetails = $staffRepository->getNonTeachingStaff();
                    if($nonTeachingStaffDetails) {
                        $count = count($nonTeachingStaffDetails);
                    }
                }
                $staffCategoryDetails[$index]['count'] = $count;
            }

            //MESSAGE GROUP DETAILS
            $messageGroupDetails = $messageGroupNameService->all();

            //STANDARD DETAILS
            $standardDetails = $institutionStandardService->all();
            foreach($standardDetails as $key => $standard) {
                $standardStudentCount = 0;
                $institutionStandardDetails[$key]['id'] = $standard['id'];
                $institutionStandardDetails[$key]['name'] = $institutionStandardService->fetchStandardByUsingId($standard['id']);

                $studentDetails = $studentMappingRepository->fetchInstitutionStandardStudents($standard['id']);
                if($studentDetails) {
                    $standardStudentCount = count($studentDetails);
                }

                $institutionStandardDetails[$key]['standard_student_count'] = $standardStudentCount;   
            }

            //STUDENT DETAILS
            $studentDetails = $studentRepository->all();
            if($studentDetails){
                $allStudentCount = count($studentDetails);
            }

            $allCount = (int) $allStudentCount + (int) $allStaffCount;

            $msgCreditDetails = $this->getCreditCount();

            $allDetails['smsTemplateDetails']         = $smsTemplateDetails;
            $allDetails['staffCategoryDetails']       = $staffCategoryDetails;
            $allDetails['institutionStandardDetails'] = $institutionStandardDetails;
            $allDetails['messageGroupDetails']        = $messageGroupDetails;
            $allDetails['msgCreditDetails']           = $msgCreditDetails;
            $allDetails['all_count']                  = $allCount;
            $allDetails['all_staff_count']            = $allStaffCount;
            $allDetails['all_student_count']          = $allStudentCount;
            
            // dd($allDetails);
            return $allDetails;
        }

        public function updateSentMessage() {

            $messageReportRepository = new MessageReportRepository(); 
            $sentMessages = $messageReportRepository->fetchSentMessages();
            $count = 0;
            foreach($sentMessages as $details) {
               
                $updateMessages = $this->updateMessageResponse($details->id);
                if($updateMessages == 'success') {
                    $count = $count+1;
                }
            }

            if($count > 0){
                $signal = 'success';
                $msg = 'Response Updated successfully!';
        
            }else{
                $signal = 'failure';
                $msg = 'Error in updating message!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );
       
            return $output;
        }

        public function getCreditCount(){

            $messageCreditRepository = new MessageCreditRepository();
            $messageReportRepository = new MessageReportRepository(); 

            $allSessions    = session()->all();
            $institutionId  = $allSessions['institutionId'];
            $msgCreditDetails  = array();
            $totalCredit = 0;

            $creditData     = $messageCreditRepository->fetchInstitutionCredit($institutionId);
            if($creditData) {
                $totalCredit    = $creditData->total_credit_available;
            }

            $consumedData   = $messageReportRepository->getTotalConsumedCredit();
            $consumedCredit = $consumedData->consumedCredit;

            $balanceCredit  = (int) $totalCredit - (int) $consumedCredit;

            $msgCreditDetails['total_credit']   = $totalCredit;
            $msgCreditDetails['balance_credit'] = $balanceCredit;

            return $msgCreditDetails;
        }
        
        public function getPhoneNumbers($term){
           
            $studentDetentionService = new StudentDetentionService();
            
            $details = $studentDetentionService->getStaffStudentDetails($term);
            
           foreach($details as $data){
                $values = explode('@', $data);
                $studentStaffDetails[] = array(
                    'value'=>$values[4],
                    'text'=>$values[0],
                );
           }
      
            return $studentStaffDetails;
        }

        public function alertBoxConfigDetails(){

            $configDetails = array();
            $configDetails['alert_username'] = "7406339559";        // Reseller User name 
            $configDetails['alert_password'] = "9mxqs6kk5t";      	// Reseller Account Password 
            $configDetails['api_password']   = "0b081sgm9wo858j0c";   // API Password   
            $configDetails['alert_domain']   = "sms.egenius.in";      // Domain Name
            $configDetails['alert_priority'] = "11";
            return $configDetails;
        }

        public function getEgeniusCreditCount(){
            
            //Credit count
            $configDetails = $this->alertBoxConfigDetails();
            $alertUsername = $configDetails['alert_username'] ;
            $alertPassword = $configDetails['alert_password'];
            $apiPassword   = $configDetails['api_password'];
            $alertDomain   = $configDetails['alert_domain'];
            $alertPriority = $configDetails['alert_priority'];
            
            $smsCredit     = "sms.egenius.in/balancecheck.php?username=".$alertUsername."&api_password=".$apiPassword."&priority=".$alertPriority;
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$smsCredit);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            $output = curl_exec($ch);
            curl_close($ch);
            $alertCredits = trim($output,"Your balance is ");
            return $alertCredits;
        }

        public function addMessageCenterData($messageData, $senderId, $messageTo) {

            $composeMessageRepository = new ComposeMessageRepository(); 
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $smsTemplateId = $messageData->sms_template;
            $description = $messageData->description;

            $messageDetails = array(
                'id_institute' => $institutionId,
                'id_academic' => $academicYear,
                'id_institution_sms_templates' => $smsTemplateId,
                'description' => $description,
                'message_to' => $messageTo,
                'sender_id' => $senderId,
                'message_date_time' => Carbon::now(),
                'created_by' => Session::get('userId'),
                'created_at' => Carbon::now()
            );
            $storeMessageData = $composeMessageRepository->store($messageDetails);
            return $storeMessageData;
        }

        public function addMessageReportData($reportDetails) {

            $messageReportRepository = new MessageReportRepository(); 

            $allSessions   = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear  = $allSessions['academicYear'];

            $reportData = array(

                'id_institute'     => $institutionId,
                'id_academic'      => $academicYear,
                'id_message_center'=> $reportDetails['id_message_center'],
                'message_type'     => $reportDetails['message_type'],
                'sender_id'        => $reportDetails['sender_id'],
                'recipient_type'   => $reportDetails['recipient_type'],
                'id_recipient'     => $reportDetails['id_recipient'],
                'recipient_number' => $reportDetails['recipient_number'],
                'sms_vendor'       => 'ALERT_BOX',
                'sms_description'  => $reportDetails['sms_description'],
                'sms_sent_at'      => Carbon::now(),
                'sent_status'      => 'AWAITING-DLR',
                'completed'        => 'NO',
                'created_by'       => Session::get('userId'),
                'created_at'       => Carbon::now()
            );

            $storeReportData = $messageReportRepository->store($reportData);
            return $storeReportData;
        }

        public function sendMessageToStudent($lastInsertedId, $senderId, $description, $institutionStandardIds) {

            $messageReportRepository = new MessageReportRepository(); 
            $studentRepository = new StudentRepository(); 

            $allSessions   = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear  = $allSessions['academicYear'];
            $reportDetails = array();

            if(in_array('all' , $institutionStandardIds)) {

                $studentDetails = $studentRepository->all();

            }else {

                $details[1] = $institutionStandardIds; 
                $studentDetails = $studentRepository->fetchStudentByStandard($details);
            }

            foreach($studentDetails as $student) {

                $phoneNumber = 0;
                if($student->father_mobile_number != 0 || !empty($student->father_mobile_number))
                {
                    $phoneNumber = $student->father_mobile_number;

                } else if($student->mother_mobile_number != 0 || !empty($student->mother_mobile_number))
                {
                    $phoneNumber = $student->mother_mobile_number;
                }
             
                if($phoneNumber != '0' && !empty($phoneNumber)) {

                    $reportDetails['id_message_center'] = $lastInsertedId;
                    $reportDetails['message_type'] = 'MESSAGE_CENTER';
                    $reportDetails['sender_id'] = $senderId;
                    $reportDetails['recipient_type'] = 'STUDENT';
                    $reportDetails['id_recipient'] = $student->id;
                    $reportDetails['recipient_number'] = $phoneNumber;
                    $reportDetails['sms_description'] = $description;

                    $storeReportData = $this->addMessageReportData($reportDetails);
                }
            }
        }

        public function sendMessageToStaff($lastInsertedId, $senderId, $description, $messageTo) {
            
            $messageReportRepository = new MessageReportRepository(); 
            $staffRepository = new StaffRepository();
           
            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];
            $reportDetails = array();
            $data = '';

            if($messageTo == 'ALLSTAFF' || $messageTo == 'STAFF') {

                $staffDetails = $staffRepository->all($data);

            }else if($messageTo == 'TEACHING') {

                $staffDetails = $staffRepository->getTeachingStaff();

            }else if($messageTo == 'NONTEACHING') {

                $staffDetails = $staffRepository->getNonTeachingStaff();
            }

            foreach($staffDetails as $staff) {
                $phoneNumber = 0;
                $phoneNumber = $staff->primary_contact_no;

                if($phoneNumber != '0' && !empty($phoneNumber)) {

                    $reportDetails['id_message_center'] = $lastInsertedId;
                    $reportDetails['message_type'] = 'MESSAGE_CENTER';
                    $reportDetails['sender_id'] = $senderId;
                    $reportDetails['recipient_type'] = 'STAFF';
                    $reportDetails['id_recipient'] = $staff->id;
                    $reportDetails['recipient_number'] = $phoneNumber;
                    $reportDetails['sms_description'] = $description;

                    $storeReportData = $this->addMessageReportData($reportDetails);
                }
            }
        }

        public function sendMessageToGroup($lastInsertedId, $senderId, $description, $messageTo){

            $messageGroupMembersRepository = new MessageGroupMembersRepository();
            $messageReportRepository = new MessageReportRepository(); 
           
            $allSessions   = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear  = $allSessions['academicYear'];
            $reportDetails = array();
          
            $messageGroupMemberDetails = $messageGroupMembersRepository->all($messageTo);
            foreach($messageGroupMemberDetails as $memberDetails) {
                $phoneNumber = 0;
                $phoneNumber = $memberDetails->phone_number;

                if($phoneNumber != '0' && !empty($phoneNumber)) {

                    $reportDetails['id_message_center'] = $lastInsertedId;
                    $reportDetails['message_type'] = 'MESSAGE_CENTER';
                    $reportDetails['sender_id'] = $senderId;
                    $reportDetails['recipient_type'] = 'GROUP';
                    $reportDetails['id_recipient'] = $memberDetails->id;
                    $reportDetails['recipient_number'] = $phoneNumber;
                    $reportDetails['sms_description'] = $description;

                    $storeReportData = $this->addMessageReportData($reportDetails);
                }
            }
        }

        public function add($messageData) {

            $institutionSMSTemplateService =  new InstitutionSMSTemplateService();
            $smsTemplateRepository = new SMSTemplateRepository();
            $messageReportRepository = new MessageReportRepository(); 
            $studentMappingRepository = new StudentMappingRepository(); 
            $staffRepository = new StaffRepository();

            $allSessions   = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear  = $allSessions['academicYear'];

            $phoneNumberDetails = array();

            //   dd($messageData);
            $smsTemplateId    = $messageData->sms_template;
            $description   = $messageData->description;
            $sendTo        = $messageData->send_to;
         
            $smsTemplate        = $smsTemplateRepository->fetch($smsTemplateId);
            $templateId         = $smsTemplate->template_id;

            $smsTemplateDetails = $institutionSMSTemplateService->getSenderIdForModule('MESSAGE_CENTER');
            $senderId           = $smsTemplateDetails->sender_id;
            $entityId           = $smsTemplateDetails->entity_id;

            if(strcmp($sendTo, "ALL") == 0) { 
                
                $messageType = $messageData->message_type;

                if(in_array( 'all', $messageType)) {

                    $messageTo = 'ALL';
                    
                }else if(in_array('allStudent', $messageType)) {

                    $messageTo = 'ALLSTUDENT';

                }else if(in_array('allStaff', $messageType)) {
                    $messageTo = 'ALLSTAFF';

                }

                $institutionStandardIds[] = 'all';
                //INSERT TO MESSAGE CENTER
                $storeMessageData = $this->addMessageCenterData($messageData, $senderId, $messageTo);
                if($storeMessageData)
                {   
                    //INSERT TO MESSAGE REPORT 
                    $lastInsertedId = $storeMessageData->id;
                   
                    if($messageTo == 'ALL') {
                        $sendToStudent = $this->sendMessageToStudent($lastInsertedId, $senderId, $description, $institutionStandardIds);
                        $sendToStaff = $this->sendMessageToStaff($lastInsertedId, $senderId, $description, 'ALLSTAFF');

                    } else if($messageTo == 'ALLSTUDENT') {
                        $sendToStudent = $this->sendMessageToStudent($lastInsertedId, $senderId, $description, $institutionStandardIds);

                    } else if($messageTo == 'ALLSTAFF') {

                        $sendToStaff = $this->sendMessageToStaff($lastInsertedId, $senderId, $description, $messageTo);
                    }
                }

            }else if(strcmp($sendTo, "STAFF") == 0) { 
 
                if(in_array('TEACHING', $messageData->staff_category) && in_array('NONTEACHING', $messageData->staff_category) ) {

                    $messageTo = 'STAFF';

                }else if(in_array('TEACHING', $messageData->staff_category)){

                    $messageTo = 'TEACHING';

                }else if(in_array('NONTEACHING', $messageData->staff_category)){

                    $messageTo = 'NONTEACHING';
                }
                    
                //INSERT TO MESSAGE CENTER
                $storeMessageData = $this->addMessageCenterData($messageData, $senderId, $messageTo);

                if($storeMessageData)
                {   
                    //INSERT TO MESSAGE REPORT 
                    $lastInsertedId = $storeMessageData->id;  
                    $sendToStaff = $this->sendMessageToStaff($lastInsertedId, $senderId, $description, $messageTo);
                }

            }else if(strcmp($sendTo, "STUDENT") == 0) { 

                $messageTo = 'STUDENT';
                //INSERT TO MESSAGE CENTER
                $storeMessageData = $this->addMessageCenterData($messageData, $senderId,$messageTo);
                if($storeMessageData)
                {   
                    //INSERT TO MESSAGE REPORT 
                    $lastInsertedId = $storeMessageData->id;
                    $institutionStandardIds = $messageData->institutionStandard;
                    $sendToStudent = $this->sendMessageToStudent($lastInsertedId, $senderId, $description, $institutionStandardIds);
                }

            }else if(strcmp($sendTo, "GROUP") == 0) { 

                $messageTo = 'GROUP';
                //INSERT TO MESSAGE CENTER
                $storeMessageData = $this->addMessageCenterData($messageData, $senderId, $messageTo);
                if($storeMessageData)
                {   
                    //INSERT TO MESSAGE REPORT 
                    $lastInsertedId = $storeMessageData->id;
                    foreach($messageData->groups as $groupId ){
                        $sendToGroup = $this->sendMessageToGroup($lastInsertedId, $senderId, $description, $groupId);
                    }
                }

            }else if(strcmp($sendTo, "INDIVIDUAL") == 0) { 

                $messageTo = 'INDIVIDUAL';
                $phoneNumberArray = explode(',',$messageData->individual_phone_number);
                $idStaffStudent = explode(',',$messageData->individual_id_staff_student);
           
                //INSERT TO MESSAGE CENTER
                $storeMessageData = $this->addMessageCenterData($messageData, $senderId,$messageTo);

                if($storeMessageData)
                {   
                    //INSERT TO MESSAGE REPORT 
                    $lastInsertedId = $storeMessageData->id;
    
                    foreach($phoneNumberArray as $index => $phoneNumber ) {
                       
                        $idRecipient = $idStaffStudent[$index];

                        if($idRecipient != '-') {

                            $studentDetails = $studentMappingRepository->fetchStudent($idRecipient);
                            if($studentDetails) {
                                $recipientType = 'STUDENT';
                            }else {
                                $recipientType = 'STAFF';
                            }
                        }
                        else{
                            $recipientType = '-';
                        }

                        if($phoneNumber != '') {
                            $reportDetails['id_message_center'] = $lastInsertedId;
                            $reportDetails['message_type'] = 'MESSAGE_CENTER';
                            $reportDetails['sender_id'] = $senderId;
                            $reportDetails['recipient_type'] = $recipientType;
                            $reportDetails['id_recipient'] = $idRecipient;
                            $reportDetails['recipient_number'] = $phoneNumber;
                            $reportDetails['sms_description'] = $description;
            
                            $storeReportData = $this->addMessageReportData($reportDetails);
                        }
                    }
                }


            }else if(strcmp($sendTo, "CLASSWISE") == 0) { 
                
                $messageTo = 'CLASSWISE';
               
                $studentIdDetails = explode(',',$messageData->student_id_details);
                $phoneNumberDetails = explode(',',$messageData->tag_phone);
              
                //INSERT TO MESSAGE CENTER
                $storeMessageData = $this->addMessageCenterData($messageData, $senderId, $messageTo);

                if($storeMessageData)
                {   
                    //INSERT TO MESSAGE REPORT 
                    $lastInsertedId = $storeMessageData->id;

                    foreach($studentIdDetails as $index => $studentId) {

                        $phoneNumber = $phoneNumberDetails[$index];

                        if($phoneNumber != '') {
                            $reportDetails['id_message_center'] = $lastInsertedId;
                            $reportDetails['message_type'] = 'MESSAGE_CENTER';
                            $reportDetails['sender_id'] = $senderId;
                            $reportDetails['recipient_type'] = 'STUDENT';
                            $reportDetails['id_recipient'] = $studentId;
                            $reportDetails['recipient_number'] = $phoneNumber;
                            $reportDetails['sms_description'] = $description;
        
                            $storeReportData = $this->addMessageReportData($reportDetails);
                        }
                    }
                }
            }

            $description = str_replace("&","and",$description); 

            if($lastInsertedId) {

                $output = $this->sendMessage($lastInsertedId, $templateId);
      
            }else{

                $signal = 'failure';
                $msg = 'Error in sending message!';

                $output = array(
                    'signal'=>$signal,
                    'message'=>$msg
                );
            }
            return $output;
        }

        public function sendMessage($idMessageCenter, $templateId){

            $institutionSMSTemplateService =  new InstitutionSMSTemplateService();
            $messageReportRepository = new MessageReportRepository(); 
            $messageSenderEntityRepository = new MessageSenderEntityRepository(); 

            $configDetails = $this->alertBoxConfigDetails();
            $alertUsername = $configDetails['alert_username'] ;
            $alertPassword = $configDetails['alert_password'];
            $apiPassword   = $configDetails['api_password'];
            $alertDomain   = $configDetails['alert_domain'];
            $alertPriority = $configDetails['alert_priority'];

            // $smsTemplateDetails = $institutionSMSTemplateService->getSenderIdForModule('MESSAGE_CENTER');

            // $senderId           = $smsTemplateDetails->sender_id;

            // $senderEntityDetails = $messageSenderEntityRepository->fetchDetails($senderId);
            // $entityId           = $senderEntityDetails->entity_id;

            $senderId = 'EGNIUS';
            $entityId = '1701158107050838436';


            //FETCH ALL NUMBERS TO SEND MSG AND UPDATE TRACK ID
            $msgReportDetails = $messageReportRepository->fetch($idMessageCenter);
           //  dd($msgReportDetails);
            $count = 0;
            foreach($msgReportDetails as $data)
            {
                $credits = '';
                $deliveredAt = '';
                $phoneNumber = $data->recipient_number;
                $description = $data->sms_description;

                $parameters="username=$alertUsername&api_password=$apiPassword&sender=$senderId&to=$phoneNumber&message=$description&priority=$alertPriority&e_id=$entityId&t_id=$templateId"; 
         
                $url="http://$alertDomain/pushsms.php";    
                $ch = curl_init($url);
                $message_url=$url."?".$parameters; 
            
                curl_setopt($ch, CURLOPT_POST,1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$parameters); 
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1); 
                curl_setopt($ch, CURLOPT_HEADER,0);  // DO NOT RETURN HTTP HEADERS 
                curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);  // RETURN THE CONTENTS OF THE CALL
                $returnValue = curl_exec($ch);
                curl_close($ch);
                $response  = explode('  ',$returnValue);

                if(count($response) > 0) {

                    $messageId = trim($response[0]);
                    $trackId   = trim($response[1],"Trackid=");

                    if($messageId != "Sorry, No valid numbers found!") {
                    
                        $url = "http://$alertDomain/apis/fetch_dlr.php?username=$alertUsername&msgid=$messageId";

                        $output = file_get_contents($url);
                        $result = explode("---",$output);
                        
                        $credits = $result[1];
                        $status = $result[2];
                        $deliveredAt = $result[3];
                        //$deliveredAt = date("Y-m-d H:i:s",strtotime($result[3]));

                        if($status != 'sent' && $status != 'Sent' && $status != '' && !empty($status))
                        {
                            $completed = 'YES';
                        }
                        else
                        {
                            $completed = 'NO';
                        }

                    }else{
                        $failedCount = $failedCount + 1;
                        $status = 'FAILED';
                        $completed = 'YES';
                    }
                
                    $data->sent_status      = $status;
                    $data->sms_charge       = $credits;
                    $data->sms_track_id     = $trackId;
                    $data->sms_message_id   = $messageId;
                    $data->completed        = $completed;
                    $data->sms_delivered_at = $deliveredAt;
                
                    $update = $messageReportRepository->update($data);
                
                    if($update) {
                        $count = $count + 1;
                    }
                }
            }
      
            if($count > 0){
                $signal = 'success';
                $msg = 'Message sent successfully!';
        
            }else{
                $signal = 'failure';
                $msg = 'Error in sending message!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );
       
            return $output;
        }

        public function sendOTPMessage($idMessageReport, $templateId){

            //$institutionSMSTemplateService =  new InstitutionSMSTemplateService();
            $messageReportRepository = new MessageReportRepository(); 
            $messageSenderEntityRepository = new MessageSenderEntityRepository(); 

            $configDetails = $this->alertBoxConfigDetails();
            $alertUsername = $configDetails['alert_username'] ;
            $alertPassword = $configDetails['alert_password'];
            $apiPassword   = $configDetails['api_password'];
            $alertDomain   = $configDetails['alert_domain'];
            $alertPriority = $configDetails['alert_priority'];

            // $smsTemplateDetails = $institutionSMSTemplateService->getSenderIdForModule('OTP');

            // $senderId           = $smsTemplateDetails->sender_id;

            // $senderEntityDetails = $messageSenderEntityRepository->fetchDetails($senderId);
            // $entityId           = $senderEntityDetails->entity_id;

            $senderId = 'EGNIUS';
            $entityId = '1701158107050838436';


            //FETCH ALL NUMBERS TO SEND MSG AND UPDATE TRACK ID
            $data = $messageReportRepository->find($idMessageReport);
            // dd($data);
           //  dd($msgReportDetails);
            $count = 0;
           
                $credits = '';
                $deliveredAt = '';
                $phoneNumber = $data->recipient_number;
                $description = $data->sms_description;

                $parameters="username=$alertUsername&api_password=$apiPassword&sender=$senderId&to=$phoneNumber&message=$description&priority=$alertPriority&e_id=$entityId&t_id=$templateId"; 
         
                $url="http://$alertDomain/pushsms.php";    
                $ch = curl_init($url);
                $message_url=$url."?".$parameters; 
            
                curl_setopt($ch, CURLOPT_POST,1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$parameters); 
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1); 
                curl_setopt($ch, CURLOPT_HEADER,0);  // DO NOT RETURN HTTP HEADERS 
                curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);  // RETURN THE CONTENTS OF THE CALL
                $returnValue = curl_exec($ch);
                curl_close($ch);
                $response  = explode('  ',$returnValue);

                if(count($response) > 0) {

                    $messageId = trim($response[0]);
                    $trackId   = trim($response[1],"Trackid=");

                    if($messageId != "Sorry, No valid numbers found!") {
                    
                        $url = "http://$alertDomain/apis/fetch_dlr.php?username=$alertUsername&msgid=$messageId";

                        $output = file_get_contents($url);
                        $result = explode("---",$output);
                        
                        $credits = $result[1];
                        $status = $result[2];
                        $deliveredAt = $result[3];
                        //$deliveredAt = date("Y-m-d H:i:s",strtotime($result[3]));

                        if($status != 'sent' && $status != 'Sent' && $status != '' && !empty($status))
                        {
                            $completed = 'YES';
                        }
                        else
                        {
                            $completed = 'NO';
                        }

                    }else{
                        $failedCount = $failedCount + 1;
                        $status = 'FAILED';
                        $completed = 'YES';
                    }
                
                    $data->sent_status      = $status;
                    $data->sms_charge       = $credits;
                    $data->sms_track_id     = $trackId;
                    $data->sms_message_id   = $messageId;
                    $data->completed        = $completed;
                    $data->sms_delivered_at = $deliveredAt;
                
                    $update = $messageReportRepository->update($data);
                
                    if($update) {
                        $count = $count + 1;
                    }
                }
      
            if($count > 0){
                $signal = 'success';
                $msg = 'Message sent successfully!';
        
            }else{
                $signal = 'failure';
                $msg = 'Error in sending message!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );
       
            return $output;
        }

        public function updateMessageResponse($idMessageReport){

            $messageReportRepository = new MessageReportRepository(); 

            $configDetails = $this->alertBoxConfigDetails();
            $alertUsername = $configDetails['alert_username'] ;
            $alertDomain   = $configDetails['alert_domain'];
        
            $msgReportDetails = $messageReportRepository->find($idMessageReport);
            //   dd($msgReportDetails);
            $messageId = $msgReportDetails->sms_message_id;

            $url = "http://$alertDomain/apis/fetch_dlr.php?username=$alertUsername&msgid=$messageId"; 
           
        
            $output = file_get_contents($url);
        
            $result = explode("---",$output);
          
            $status = $result[2];
            $deliveredAt = $result[3];
            //$deliveredAt = date("Y-m-d H:i:s",strtotime($result[3]));
          
            if($status != 'sent' && $status != 'Sent' && $status != '' && !empty($status))
            {
                $completed = 'YES';
            }
            else
            {
                $completed = 'NO';
            }
          
            $msgReportDetails->sent_status = $status;
            $msgReportDetails->completed = $completed;
            $msgReportDetails->sms_delivered_at = $deliveredAt;
          
            $update = $messageReportRepository->update($msgReportDetails);
            if($update){
                $output = 'success';
            }else{
                $output = 'failed';
            }

            return $output;
        }

        public function getAllMessages(){
            $composeMessageRepository =  new ComposeMessageRepository();
            $allMessagesDetails = array();
            $allMessages = $composeMessageRepository->all();
            foreach($allMessages as $index => $message) {
                $allMessagesDetails[$index] = $message;
                $allMessagesDetails[$index]['date_time'] = Carbon::createFromFormat('Y-m-d H:i:s', $message->message_date_time)->format('d-m-Y H:i:s');
            }
            return $allMessagesDetails;
        }

        public function getMessageReport($idMessageCenter) {
            $messageReportRepository = new MessageReportRepository(); 
            $studentMappingRepository = new StudentMappingRepository(); 
            $staffRepository = new StaffRepository(); 
            $institutionRepository = new InstitutionRepository();

            $allSessions   = session()->all();
            $institutionId = $allSessions['institutionId'];

            $messageReportData = array();
            $messageReportDetails = array();
            $messageCountData = array();
            $totalCreditCountConsumed = 0;
            $deliveredCount = 0;
            $sentCount = 0;
            $failedCount = 0;
            $messageReport = $messageReportRepository->fetch($idMessageCenter);
            foreach($messageReport as $index => $details) {
                $smsCharge = 0;
                if($details->recipient_type == 'STUDENT'){

                    $studentDetails = $studentMappingRepository->fetchStudent($details->id_recipient);
                    $name = $studentDetails->name;
                    $uid = $studentDetails->egenius_uid;

                }else if($details->recipient_type == 'STAFF'){

                    $staffDetails = $staffRepository->fetch($details->id_recipient);
                    $name = $staffDetails->name;
                    $uid = $staffDetails->staff_uid;

                }else{
                    $name = '-';
                    $uid = '-';
                }

                $messageReportData[$index] = $details;
                $messageReportData[$index]['name'] = $name;
                $messageReportData[$index]['uid'] = $uid;
                $messageReportData[$index]['sms_sent_at'] = Carbon::createFromFormat('Y-m-d H:i:s', $details->sms_sent_at)->format('d-m-Y H:i:s');
                if($details->sent_status == 'Delivered') {
                    $messageReportData[$index]['sms_delivered_at'] = Carbon::createFromFormat('Y-m-d H:i:s', $details->sms_delivered_at)->format('d-m-Y H:i:s');
                }else{
                    $messageReportData[$index]['sms_delivered_at'] = '-';
                }

                if(!empty($details->sms_charge)){
                    $smsCharge = $details->sms_charge;
                }

                $totalCreditCountConsumed = (int) $totalCreditCountConsumed + (int) $smsCharge;

                if($details->sent_status == 'Delivered') {
                    $deliveredCount = $deliveredCount + 1;
                }

                else if($details->sent_status == 'Sent' || $details->sent_status == 'sent') {
                    $sentCount = $sentCount + 1;
                }

                else if($details->sent_status != 'Delivered' && $details->sent_status != 'Sent' && $details->sent_status != 'sent') {
                    $failedCount = $failedCount + 1;
                }

            }
            $totalMessageCount = (int) $deliveredCount + (int) $sentCount + (int) $failedCount;
            $institute = $institutionRepository->fetch($institutionId);
            $messageReportDetails['messageReportData'] = $messageReportData;
            $messageReportDetails['totalCreditCountConsumed'] = $totalCreditCountConsumed;
            $messageReportDetails['institute'] = $institute;
            $messageReportDetails['deliveredCount'] = $deliveredCount;
            $messageReportDetails['sentCount'] = $sentCount;
            $messageReportDetails['failedCount'] = $failedCount;
            $messageReportDetails['totalMessageCount'] = $totalMessageCount;
            return $messageReportDetails;
        }

        public function addOTPMessageReportData($reportDetails) {

            $messageReportRepository = new MessageReportRepository(); 

            $reportData = array(

                'id_institute'     => $reportDetails['institution_id'],
                'id_academic'      => $reportDetails['academic_id'],
                'id_message_center'=> $reportDetails['id_message_center'],
                'message_type'     => $reportDetails['message_type'],
                'sender_id'        => $reportDetails['sender_id'],
                'recipient_type'   => $reportDetails['recipient_type'],
                'id_recipient'     => $reportDetails['id_recipient'],
                'recipient_number' => $reportDetails['recipient_number'],
                'sms_vendor'       => 'ALERT_BOX',
                'sms_description'  => $reportDetails['sms_description'],
                'sms_sent_at'      => Carbon::now(),
                'sent_status'      => 'AWAITING-DLR',
                'completed'        => 'NO',
                'created_by'       => Session::get('userId'),
                'created_at'       => Carbon::now()
            );

            $storeReportData = $messageReportRepository->store($reportData);
            return $storeReportData;
        }
    }

?>