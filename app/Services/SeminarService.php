<?php
    namespace App\Services;

    use App\Models\Seminar;
    use App\Repositories\SeminarRepository;
    use App\Repositories\StaffRepository;
    use App\Repositories\StaffCategoryRepository;
    use App\Repositories\StaffSubCategoryRepository;
    use App\Repositories\StandardSubjectRepository;
    use App\Repositories\SeminarAttachmentRepository;
    use App\Repositories\SeminarRecipientRepository;
    use App\Repositories\SeminarInvitiesRepository;
    use App\Repositories\SeminarConductedByRepository;
    use App\Repositories\StudentMappingRepository;
    use App\Repositories\SeminarMentorsRepository;
    use App\Services\SeminarService;
    use App\Services\StudentService;
    use App\Services\InstitutionStandardService;
    use App\Services\InstitutionSubjectService;
    use App\Services\StandardSubjectService;
    use App\Services\EventService;
    use Carbon\Carbon;
    use Storage;
    use Session;
    use DB;
    use ZipArchive;

    class SeminarService {

        // View seminar
        public function getAll(){

            $seminarRepository = new SeminarRepository();
            $seminarRecipientRepository = new SeminarRecipientRepository();
            $seminarAttachmentRepository = new SeminarAttachmentRepository();
            $seminarDetail = array();

            $seminarData = $seminarRepository->all();

            foreach($seminarData as $key => $seminar){

                $seminarDetail[$key] = $seminar;
                $seminarDetail[$key]['start_date'] = Carbon::createFromFormat('Y-m-d', $seminar->start_date)->format('d-m-Y');
                $seminarDetail[$key]['end_date'] = Carbon::createFromFormat('Y-m-d', $seminar->end_date)->format('d-m-Y');
                $recipientData = '';

                $recipient = $seminarRecipientRepository->seminarRecipientType($seminar->id);

                if($recipient){

                    foreach($recipient as $rec){
                        $recipientData .= $rec['recipient_type'].', ';
                    }

                    $recipientData = substr($recipientData, 0, -2);
                }

                $seminarDetail[$key]['recipient'] = $recipientData;


                $seminarImageDetail = $seminarAttachmentRepository->fetch($seminar->id);

                if($seminarImageDetail){
                    $status = 'file_found';
                }else{
                    $status = 'file_not_found';
                }

               $seminarDetail[$key]['status'] = $status;
            }

            return $seminarDetail;
        }

        // Insert seminar
        public function add($seminarData){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $seminarRepository = new SeminarRepository();
            $seminarAttachmentRepository = new SeminarAttachmentRepository();
            $seminarRecipientRepository = new SeminarRecipientRepository();
            $seminarInvitiesRepository = new SeminarInvitiesRepository();
            $seminarConductedByRepository = new SeminarConductedByRepository();
            $seminarMentorsRepository = new SeminarMentorsRepository();
            $staffSubCategoryRepository = new StaffSubCategoryRepository();
            $standardSubjectRepository = new StandardSubjectRepository();
            $uploadService = new UploadService();

            $seminarTopic = $seminarData->seminar_topic;
            $description = $seminarData->description;
            $maxMark = $seminarData->max_mark;
            $startTime = $seminarData->seminar_start_time;
            $endTime = $seminarData->seminar_end_time;
            $startDate = Carbon::createFromFormat('d/m/Y', $seminarData->seminar_start_date)->format('Y-m-d');
            $endDate = Carbon::createFromFormat('d/m/Y', $seminarData->seminar_end_date)->format('Y-m-d');
            $smsRequired = $seminarData->sms_alert;

            $check = Seminar::where('id_institute', $institutionId)
                            ->where('id_academic', $academicYear)
                            ->where('seminar_topic', $seminarTopic)
                            ->where('start_date', $startDate)
                            ->where('end_date', $endDate)->first();

            if(!$check){

                $data = array(
                    'id_institute' => $institutionId,
                    'id_academic' => $academicYear,
                    'seminar_topic' => $seminarTopic,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'max_marks' => $maxMark,
                    'description' => $description,
                    'sms_alert' => $smsRequired,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );

                $storeData = $seminarRepository->store($data);

                if($storeData){

                    $lastInsertedId = $storeData->id;

                    if($seminarData->conducted_by){

                        foreach($seminarData->conducted_by as $key => $conductedBy){

                            $type = $seminarData->conducted_by_type[$key];

                            $data = array(
                                'id_seminar' => $lastInsertedId,
                                'conducted_by' => $conductedBy,
                                'type' => $type,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );

                            $storeSeminarConductors = $seminarConductedByRepository->store($data);
                        }
                    }

                    if($seminarData->mentors){

                        foreach($seminarData->mentors as $idStaff){

                            $data = array(
                                'id_seminar' => $lastInsertedId,
                                'id_staff' => $idStaff,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );

                            $storeSeminarMentors = $seminarMentorsRepository->store($data);
                        }
                    }

                    // dd($seminarData->seminarAttachment);
                    // Insert event attachmen
                    if($seminarData->hasfile('seminarAttachment')){

                        //$path = 'Seminar';
                        foreach($seminarData->seminarAttachment as $attachment){

                            $path = 'Seminar';
                            $attachmentSeminar = $uploadService->fileUpload($attachment, $path);

                            $data = array(
                                'id_seminar' => $lastInsertedId,
                                'file_url' => $attachmentSeminar,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );

                            $storeAttachment = $seminarAttachmentRepository->store($data);
                            // dd($storeAttachment);
                        }
                    }

                    // Insert invities
                    if($seminarData->applicableTo){

                        foreach($seminarData->applicableTo as $recipientType){

                            if($recipientType == 'STAFF'){

                                // Invities
                                foreach($seminarData->staffCategory as $staffCategory){

                                    foreach($seminarData->staffSubcategory as $staffSubcategory){

                                        $data = $staffSubCategoryRepository->findSubCategory($staffCategory, $staffSubcategory);
                                        // dd($data);

                                        if($data){
                                            $applicableTo = array(
                                                'id_seminar' => $lastInsertedId,
                                                'recipient_type' => $recipientType,
                                                'id_staff_category' => $staffCategory,
                                                'id_staff_subcategory' => $staffSubcategory,
                                                'created_by' => Session::get('userId'),
                                                'created_at' => Carbon::now()
                                            );

                                            $storeSeminarInvities = $seminarInvitiesRepository->store($applicableTo);
                                        }
                                    }
                                }

                                // Recipient
                                foreach($seminarData->staff as $index => $staff){

                                    $data = array(
                                        'id_seminar' => $lastInsertedId,
                                        'recipient_type' => $recipientType,
                                        'id_recipient' => $staff,
                                        'created_by' => Session::get('userId'),
                                        'created_at' => Carbon::now()
                                    );

                                    $storeSeminarRecipient = $seminarRecipientRepository->store($data);
                                }

                            }else{

                                foreach($seminarData->standard as $standard){

                                    foreach($seminarData->subject as $subject){

                                        $data = $standardSubjectRepository->findStandardSubject($standard, $subject);

                                        if($data){
                                            $applicableTo = array(
                                                'id_seminar' => $lastInsertedId,
                                                'recipient_type' => $recipientType,
                                                'id_standard' => $standard,
                                                'id_subject' => $subject,
                                                'created_by' => Session::get('userId'),
                                                'created_at' => Carbon::now()
                                            );

                                            $storeSeminarInvities = $seminarInvitiesRepository->store($applicableTo);
                                        }
                                    }
                                }

                                foreach($seminarData->student as $index => $student){

                                    $data = array(
                                        'id_seminar' => $lastInsertedId,
                                        'recipient_type' => $recipientType,
                                        'id_recipient' => $student,
                                        'created_by' => Session::get('userId'),
                                        'created_at' => Carbon::now()
                                    );

                                    $storeSeminarRecipient = $seminarRecipientRepository->store($data);
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

        // Get particular seminar
        public function getSeminarDetails($idSeminar){

            $seminarRecipientRepository = new SeminarRecipientRepository();
            $seminarInvitiesRepository = new SeminarInvitiesRepository();
            $seminarConductedByRepository = new SeminarConductedByRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $staffRepository = new StaffRepository();
            $staffCategoryRepository = new StaffCategoryRepository();
            $staffSubCategoryRepository = new StaffSubCategoryRepository();
            $seminarRepository = new SeminarRepository();
            $seminarAttachmentRepository = new SeminarAttachmentRepository();
            $studentService = new StudentService();
            $eventService = new EventService();
            $seminarMentorsRepository = new SeminarMentorsRepository();
            $institutionStandardService = new InstitutionStandardService();
            $standardSubjectService = new StandardSubjectService();
            $institutionSubjectService = new InstitutionSubjectService();

            $selectedStaffCategoryData = array();
            $selectedStaffSubCategoryData = array();
            $selectedStaffCategory = array();
            $selectedStaffSubCategory = array();
            $selectedStandardSubject = array();
            $selectedStudentStandard = array();
            $selectedStudentData = array();
            $selectedStaffData = array();
            $recipientArray = array();
            $allStaffs = array();
            $allStudents = array();
            $studentStaffData = array();
            $mentorsData = array();
            $standardIds = array();

            $seminarMentorsDetails = array();
            $categoryDetails = array();
            $subCategoryDetails = array();
            $standardDetails = array();
            $subjectDetails = array();

            $seminarAttachment = $seminarAttachmentRepository->fetch($idSeminar);

            foreach($seminarAttachment as $key => $attachment){
                $ext = pathinfo($attachment['file_url'], PATHINFO_EXTENSION);
                $seminarAttachment[$key] = $attachment;
                $seminarAttachment[$key]['extension'] = $ext;
            }

            $seminarData = $seminarRepository->fetch($idSeminar);

            $seminarData['start_date'] = Carbon::createFromFormat('Y-m-d', $seminarData->start_date)->format('d/m/Y');
            $seminarData['end_date'] = Carbon::createFromFormat('Y-m-d', $seminarData->end_date)->format('d/m/Y');
            $recipientTypes = $seminarRecipientRepository->seminarRecipientType($idSeminar);

            foreach($recipientTypes as $recipientType){

                array_push($recipientArray, $recipientType->recipient_type);

                if($recipientType->recipient_type == "STAFF"){

                    $selectedStaffCategoryData = $seminarInvitiesRepository->allSeminarCategory($idSeminar, $recipientType->recipient_type);
                    foreach($selectedStaffCategoryData as $staffCategory){
                        array_push($selectedStaffCategory, $staffCategory['id_staff_category']);

                        $category = $staffCategoryRepository->fetch($staffCategory['id_staff_category']);
                        array_push($categoryDetails, $category->name);

                    }

                    $selectedStaffSubCategoryData = $seminarInvitiesRepository->allSeminarSubCategory($idSeminar, $recipientType->recipient_type);
                    foreach($selectedStaffSubCategoryData as $staffSubCategory){
                        array_push($selectedStaffSubCategory, $staffSubCategory['id_staff_subcategory']);

                        $subCategory = $staffSubCategoryRepository->fetch($staffSubCategory['id_staff_subcategory']);
                        array_push($subCategoryDetails, $subCategory->name);
                    }

                    $selectedStaffs = $seminarRecipientRepository->seminarRecipients($idSeminar, $recipientType->recipient_type);
                    foreach($selectedStaffs as $staffId){
                        array_push($selectedStaffData, $staffId['id_recipient']);
                    }

                    $allStaffs = $staffRepository->getStaffOnCategoryAndSubcategory($selectedStaffCategory, $selectedStaffSubCategory);

                }else{

                    $selectedStandards = $seminarInvitiesRepository->allSeminarStandards($idSeminar, $recipientType->recipient_type);
                    foreach($selectedStandards as $studentStandard){
                        array_push($selectedStudentStandard, $studentStandard['id_standard']);

                        $standard = $institutionStandardService->fetchStandardByUsingId($studentStandard['id_standard']);
                        if(!in_array($standard, $standardDetails)){
                            array_push($standardDetails, $standard);
                        }
                    }

                    $selectedStandardSubjectData = $seminarInvitiesRepository->allSeminarSubjects($idSeminar, $recipientType->recipient_type);
                    foreach($selectedStandardSubjectData as $standardSubject){
                        array_push($selectedStandardSubject, $standardSubject['id_subject']);

                        $subject = $institutionSubjectService->getSubjectName($standardSubject['id_subject']);
                        if(!in_array($subject, $subjectDetails)){
                            array_push($subjectDetails, $subject);
                        }
                    }

                    $requestData = array(
                        'subjectId' => $selectedStandardSubject,
                        'standardId' => $selectedStudentStandard
                    );

                    $allStudents = $studentService->getAllStudent($requestData);

                    $selectedStudents = $seminarRecipientRepository->seminarRecipients($idSeminar, $recipientType->recipient_type);
                    foreach($selectedStudents as $studentId){
                        array_push($selectedStudentData, $studentId['id_recipient']);
                    }
                }
            }

            $seminarConductedBy = $seminarConductedByRepository->fetch($idSeminar);

            foreach ($seminarConductedBy as $conductedBy){

                if($conductedBy->type == 'STUDENT'){

                    $data = $studentMappingRepository->fetchStudent($conductedBy->conducted_by);
                    $data['standard'] = $institutionStandardService->fetchStandardByUsingId($data->id_standard);
                    $data['id'] = $data->id_student;
                    $data['type'] = 'STUDENT';
                    $data['uid'] = $data->egenius_uid;
                    $data['contact_number'] = $data->father_mobile_number;

                }else if($conductedBy->type == 'STAFF'){

                    $data = $staffRepository->fetch($conductedBy->conducted_by);
                    $data['standard'] = '-';
                    $data['type'] = 'STAFF';
                    $data['uid'] = $data->staff_uid;
                    $data['contact_number'] = $data->primary_contact_no;
                }

                $studentStaffData[] = $data;
            }

            $seminarMentors = $seminarMentorsRepository->all($idSeminar);

            foreach($seminarMentors as $mentors){
                $mentorsData[] = $mentors->id_staff;
                //$mentorsDetail[] = $mentors;

                $staffDetails = $staffRepository->fetch($mentors->id_staff);
                array_push($seminarMentorsDetails, $staffDetails->name);
            }

            $standardSubjects = $standardSubjectService->getStandardsSubject($selectedStudentStandard);
            $details = $eventService->getEventData();

            $output = array(
                'seminarData' => $seminarData,
                'recipientTypes' => $recipientArray,
                'selectedStaffCategory' => $selectedStaffCategory,
                'selectedStaffSubCategory' => $selectedStaffSubCategory,
                'selectedStandardSubject' => $selectedStandardSubject,
                'selectedStandards' => $selectedStudentStandard,
                'selectedStaffs' => $selectedStaffData,
                'selectedStudents' => $selectedStudentData,
                'allStaffs' => $allStaffs,
                'allStudents' => $allStudents,
                'staffCategory' => $details['staffCategory'],
                'staffSubcategory' => $details['staffSubcategory'],
                'institutionStandards' => $details['institutionStandards'],
                'teachingStaffs' => $details['teachingStaffs'],
                'studentStaffData' => $studentStaffData,
                'mentorsData' => $mentorsData,
                'mentors' => $seminarMentorsDetails,
                'standardSubjects' => $standardSubjects,
                'seminarAttachment' => $seminarAttachment,
                'categoryDetails' => $categoryDetails,
                'subCategoryDetails' => $subCategoryDetails,
                'standardDetails' => $standardDetails,
                'subjectDetails' => $subjectDetails,
            );

            return $output;
        }

        // Get seminar details
        public function fetchSeminarDetails($request){

            $idSeminar = $request->seminarId;
            $seminarRecipientRepository = new SeminarRecipientRepository();
            $seminarInvitiesRepository = new SeminarInvitiesRepository();
            $seminarConductedByRepository = new SeminarConductedByRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $staffRepository = new StaffRepository();
            $seminarRepository = new SeminarRepository();
            $studentService = new StudentService();
            $eventService = new EventService();
            $seminarMentorsRepository = new SeminarMentorsRepository();
            $institutionStandardService = new InstitutionStandardService();
            $staffCategoryRepository = new StaffCategoryRepository();
            $staffSubCategoryRepository = new StaffSubCategoryRepository();
            $standardSubjectService = new StandardSubjectService();
            $institutionSubjectService = new InstitutionSubjectService();

            $seminarConductedByDetails = array();
            $seminarMentorsDetails = array();
            $categoryDetails = array();
            $subCategoryDetails = array();
            $standardDetails = array();
            $subjectDetails = array();
            $seminarRecipientDetails = array();
            $invitiesTypeDetails = array();
            $seminarData = $seminarRepository->fetch($idSeminar);
            $seminarTopic  = $seminarData->seminar_topic;
            $startDate = Carbon::createFromFormat('Y-m-d',$seminarData->start_date)->format('d/m/Y');
            $endDate = Carbon::createFromFormat('Y-m-d',$seminarData->end_date)->format('d/m/Y');
            $startTime  = $seminarData->start_time;
            $endTime  = $seminarData->end_time;
            $maxMark  = $seminarData->max_marks;
            $description  = $seminarData->description;
            $smsAlert  = $seminarData->sms_alert;

            $seminarConductedBy = $seminarConductedByRepository->fetch($idSeminar);

            foreach($seminarConductedBy as $conductors){

                if($conductors->type == "STUDENT"){
                    $details = $studentMappingRepository->fetchStudent($conductors->conducted_by);

                }else if($conductors->type == "STAFF"){
                    $details = $staffRepository->fetch($conductors->conducted_by);
                }

                array_push($seminarConductedByDetails, $details->name);
            }

            $seminarMentors = $seminarMentorsRepository->all($idSeminar);

            foreach($seminarMentors as $mentors){

                $details = $staffRepository->fetch($mentors->id_staff);
                array_push($seminarMentorsDetails, $details->name);
            }

            $seminarInvities = $seminarInvitiesRepository->all($idSeminar);

            foreach($seminarInvities as $invities){

                $standardDetails = $subjectDetails = array();

                if(!in_array($invities->recipient_type, $invitiesTypeDetails)){
                    array_push($invitiesTypeDetails, $invities->recipient_type);
                }

                if($invities->recipient_type == 'STAFF'){

                    $category = $staffCategoryRepository->fetch($invities->id_staff_category);
                    $subCategory = $staffSubCategoryRepository->fetch($invities->id_staff_subcategory);

                    array_push($categoryDetails, $category->name);
                    array_push($subCategoryDetails, $subCategory->name);

                }else if($invities->recipient_type == 'STUDENT'){

                    $standard = $institutionStandardService->fetchStandardByUsingId($invities->id_standard);
                    $subject = $institutionSubjectService->getSubjectName($invities->id_subject);

                    if(!in_array($standard, $standardDetails)){
                        array_push($standardDetails, $standard);
                    }

                    if(!in_array($subject, $subjectDetails)){
                        array_push($subjectDetails, $subject);
                    }
                }
            }

            $seminarRecipient = $seminarRecipientRepository->fetch($idSeminar);

            foreach($seminarRecipient as $recipient){

                if($recipient->type == "STUDENT"){

                    $details = $studentMappingRepository->fetchStudent($recipient->id_recipient);

                }else if($recipient->type == "STAFF"){

                    $details = $staffRepository->fetch($recipient->id_recipient);
                }

                array_push($seminarRecipientDetails, $details->name);
            }

            $subjectDetails = implode(',', $subjectDetails);
            $seminarRecipientDetails = implode(',', $seminarRecipientDetails);

            $output = array(
                'seminar_topic' => $seminarTopic,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'max_mark' => $maxMark,
                'description' => $description,
                'sms_alert' => $smsAlert,
                'conducted_by' => $seminarConductedByDetails,
                'mentors' => $seminarMentorsDetails,
                'category' => $categoryDetails,
                'sub_category' => $subCategoryDetails,
                'standard' => $standardDetails,
                'subject' => $subjectDetails,
                'recipient' => $seminarRecipientDetails,
                'invitiesType' => $invitiesTypeDetails
            );
            // dd($output);
            return $output;
        }

        // Delete Seminar
        public function delete($id){
            $seminarRepository = new SeminarRepository();

            $seminar = $seminarRepository->delete($id);

            if($seminar){
                $signal = 'success';
                $msg = 'Seminar deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Update seminar
        public function update($seminarData, $id){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $seminarRepository = new SeminarRepository();
            $seminarAttachmentRepository = new SeminarAttachmentRepository();
            $seminarRecipientRepository = new SeminarRecipientRepository();
            $seminarInvitiesRepository = new SeminarInvitiesRepository();
            $staffSubCategoryRepository = new StaffSubCategoryRepository();
            $standardSubjectRepository = new StandardSubjectRepository();
            $uploadService = new UploadService();
            $seminarConductedByRepository = new SeminarConductedByRepository();
            $seminarMentorsRepository = new SeminarMentorsRepository();

            $seminarTopic = $seminarData->seminar_topic;
            $description = $seminarData->description;
            $maxMark = $seminarData->max_mark;
            $startTime = $seminarData->seminar_start_time;
            $endTime = $seminarData->seminar_end_time;
            $startDate = Carbon::createFromFormat('d/m/Y', $seminarData->seminar_start_date)->format('Y-m-d');
            $endDate = Carbon::createFromFormat('d/m/Y', $seminarData->seminar_end_date)->format('Y-m-d');
            $smsRequired = $seminarData->sms_alert;

            // Fetch seminar data
            $seminarDetail = $seminarRepository->fetch($id);

            $seminarDetail->seminar_topic = $seminarTopic;
            $seminarDetail->start_date = $startDate;
            $seminarDetail->end_date = $endDate;
            $seminarDetail->start_time = $startTime;
            $seminarDetail->end_time = $endTime;
            $seminarDetail->max_marks = $maxMark;
            $seminarDetail->description = $description;
            $seminarDetail->sms_alert = $smsRequired;
            $seminarDetail->modified_by = Session::get('userId');
            $seminarDetail->updated_at = Carbon::now();

            $storeData = $seminarRepository->update($seminarDetail);

            if($storeData){

                if($seminarData->conducted_by){

                    $deleteSeminarConductors = $seminarConductedByRepository->delete($id);

                    foreach($seminarData->conducted_by as $key => $conductedBy){

                        $type = $seminarData->conducted_by_type[$key];

                        $data = array(
                            'id_seminar' => $id,
                            'conducted_by' => $conductedBy,
                            'type' => $type,
                            'created_by' => Session::get('userId'),
                            'created_at' => Carbon::now()
                        );

                        $storeSeminarConductors = $seminarConductedByRepository->store($data);
                    }
                }

                if($seminarData->mentors){

                    $deleteMentors = $seminarMentorsRepository->delete($id);

                    foreach($seminarData->mentors as $idStaff){

                        $data = array(
                            'id_seminar' => $id,
                            'id_staff' => $idStaff,
                            'created_by' => Session::get('userId'),
                            'created_at' => Carbon::now()
                        );

                        $storeSeminarMentors = $seminarMentorsRepository->store($data);
                    }
                }

                if($seminarData->seminarAttachment != ""){
                    //$deleteAttachment = $seminarAttachmentRepository->delete($id);
                    if($seminarData->hasfile('seminarAttachment')){

                        foreach($seminarData->seminarAttachment as $attachment){

                            $path = 'Seminar';
                            $attachmentSeminar = $uploadService->fileUpload($attachment, $path);

                            $data = array(
                                'id_seminar' => $id,
                                'file_url' => $attachmentSeminar,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );

                            $storeAttachment = $seminarAttachmentRepository->store($data);
                            // dd($storeAttachment);
                        }
                    }
                }

                // Insert event recipient
                // dd($seminarData);
                if($seminarData->applicableTo){

                    $deleteInvities = $seminarInvitiesRepository->delete($id);
                    $deleteRecepient = $seminarRecipientRepository->delete($id);

                    foreach($seminarData->applicableTo as $recipientType){

                        if($recipientType == 'STAFF'){

                            // Invities
                            foreach($seminarData->staffCategory as $staffCategory){

                                foreach($seminarData->staffSubcategory as $staffSubcategory){

                                    $data = $staffSubCategoryRepository->findSubCategory($staffCategory, $staffSubcategory);
                                    // dd($data);

                                    if($data){
                                        $applicableTo = array(
                                            'id_seminar' => $id,
                                            'recipient_type' => $recipientType,
                                            'id_staff_category' => $staffCategory,
                                            'id_staff_subcategory' => $staffSubcategory,
                                            'created_by' => Session::get('userId'),
                                            'created_at' => Carbon::now()
                                        );

                                        $storeSeminarInvities = $seminarInvitiesRepository->store($applicableTo);
                                    }
                                }
                            }

                            // Recipient
                            foreach($seminarData->staff as $index => $staff){

                                $data = array(
                                    'id_seminar' => $id,
                                    'recipient_type' => $recipientType,
                                    'id_recipient' => $staff,
                                    'created_by' => Session::get('userId'),
                                    'created_at' => Carbon::now()
                                );

                                $storeSeminarRecipient = $seminarRecipientRepository->store($data);
                            }

                        }else{

                            foreach($seminarData->standard as $standard){

                                foreach($seminarData->subject as $subject){

                                    $data = $standardSubjectRepository->findStandardSubject($standard, $subject);

                                    if($data){
                                        $applicableTo = array(
                                            'id_seminar' => $id,
                                            'recipient_type' => $recipientType,
                                            'id_standard' => $standard,
                                            'id_subject' => $subject,
                                            'created_by' => Session::get('userId'),
                                            'created_at' => Carbon::now()
                                        );

                                        $storeSeminarInvities = $seminarInvitiesRepository->store($applicableTo);
                                    }
                                }
                            }

                            foreach($seminarData->student as $index => $student){

                                $data = array(
                                    'id_seminar' => $id,
                                    'recipient_type' => $recipientType,
                                    'id_recipient' => $student,
                                    'created_by' => Session::get('userId'),
                                    'created_at' => Carbon::now()
                                );

                                $storeSeminarRecipient = $seminarRecipientRepository->store($data);
                            }
                        }
                    }
                }

                $signal = 'success';
                $msg = 'Data updated successfully!';

            }else{
                $signal = 'failure';
                $msg = 'Error updating data!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Download seminar attachment zip
        public function downloadSeminarFiles($id, $type){

            $seminarAttachmentRepository = new SeminarAttachmentRepository();

            $zip = new ZipArchive;
            $fileName = 'myNewFile_'.time().'.zip';
            $zip->open($fileName, \ZipArchive::CREATE);

            $assignmentFiles = $seminarAttachmentRepository->fetch($id);

            foreach ($assignmentFiles as $file){
                $files = explode('Seminar/', $file->file_url);
                $zip->addFromString($files[1], file_get_contents($file->file_url));
            }

            $zip->close();
            header('Content-disposition: attachment; filename='.time().'.zip');
            header('Content-type: application/zip');
            readfile($fileName);
        }

        // Deleted seminar records
        public function getDeletedRecords(){

            $seminarRecipientRepository = new SeminarRecipientRepository();
            $seminarRepository = new SeminarRepository();

            $seminarData = $seminarRepository->allDeleted();
            $seminarDetail = array();

            foreach($seminarData as $key => $seminar){

                $recepient = $seminarRecipientRepository->seminarRecipientType($seminar->id);

                $seminarDetail[$key] = $seminar;
                $recepientData = '';

                if($recepient){
                    foreach($recepient as $rec){
                        $recepientData .= $rec['recipient_type'].', ';
                    }
                    $recepientData = substr($recepientData, 0, -2);
                }

               $seminarDetail[$key]['recepient'] = $recepientData;
            }

            return $seminarDetail;
        }

        // Restore seminar records
        public function restore($id){

            $seminarRepository = new SeminarRepository();

            $seminar = $seminarRepository->restore($id);

            if($seminar){
                $signal = 'success';
                $msg = 'Data restored successfully!';

            }else{
                $signal = 'failure';
                $msg = 'Data deletion is failed!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
