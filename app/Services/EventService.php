<?php
    namespace App\Services;
    use App\Models\Event;
    use App\Services\EventService;
    use App\Repositories\EventRepository;
    use App\Repositories\StaffRepository;
    use App\Repositories\StaffCategoryRepository;
    use App\Repositories\StaffSubCategoryRepository;
    use App\Repositories\StandardSubjectRepository;
    use App\Repositories\StudentMappingRepository;
    use App\Repositories\SubjectTypeRepository;
    use App\Repositories\EventAttachmentRepository;
    use App\Repositories\EventRecipientRepository;
    use App\Repositories\EventApplicableToRepository;
    use App\Repositories\InstitutionSubjectRepository;
    use App\Services\SubjectService;
    use App\Services\StudentService;
    use App\Services\InstitutionStandardService;
    use App\Services\UploadService;
    use Carbon\Carbon;
    use ZipArchive;
    use Session;
    use DB;

    class EventService {

        // Get event data
        public function getEventData(){

            $staffCategoryRepository = new StaffCategoryRepository();
            $staffSubCategoryRepository = new StaffSubCategoryRepository();
            $institutionStandardService = new InstitutionStandardService();
            $standardSubjectService = new StandardSubjectService();
            $staffRepository = new StaffRepository();

            $standardIds = array();
            $staffCategory = $staffCategoryRepository->all();
            $staffSubCategory = $staffSubCategoryRepository->all();
            $institutionStandards = $institutionStandardService->fetchStandard();
            $teachingStaffs = $staffRepository->getTeachingStaff();
            //dd($teachingStaffs);

            foreach($teachingStaffs as $key => $staff){
                $allStaff[$key] = $staff;
                $allStaff[$key]['name'] = $staffRepository->getFullName($staff['name'], $staff['middle_name'], $staff['last_name']);
            }

            foreach($institutionStandards as $institutionStandard){
                array_push($standardIds, $institutionStandard['institutionStandard_id']);
            }

            $standardSubjects = $standardSubjectService->getStandardsSubject($standardIds);

            $output = array(
                'staffCategory' => $staffCategory,
                'staffSubcategory' => $staffSubCategory,
                'institutionStandards' => $institutionStandards,
                'standardSubjects' => $standardSubjects,
                'teachingStaffs' => $allStaff
            );

            return $output;
        }

        // Get subjects based on standard
        public function allSubject($idStandard){

            $eventRepository = new EventRepository();
            $allSubjects = $eventRepository->fetchStandardSubjects($idStandard);
            // dd($allSubjects);
            return $allSubjects;
        }

        // View event
        public function getAll(){

            $eventRepository = new EventRepository();
            $eventRecipientRepository = new EventRecipientRepository();
            $eventAttachmentRepository = new EventAttachmentRepository();

            $eventDetail = array();
            $eventData = $eventRepository->all();

            foreach($eventData as $key => $event){

                $eventDetail[$key] = $event;
                $recepientData = '';

                $recepient = $eventRecipientRepository->eventRecepientType($event->id);
                $eventAttachment = $eventAttachmentRepository->fetch($event->id);

                if(count($eventAttachment) > 0){
                    $status = 'file_found';
                }else{
                    $status = 'file_not_found';
                }

                if($recepient){
                    foreach($recepient as $rec){
                        $recepientData .= $rec['recipient_type'].', ';
                    }
                    $recepientData = substr($recepientData, 0, -2);
                }

                $eventDetail[$key]['recepient'] = $recepientData;
                $eventDetail[$key]['eventAttachment'] = $eventAttachment;
                $eventDetail[$key]['status'] = $status;
            }

            return $eventDetail;
        }

        // Insert event
        public function add($eventData){

            $eventRepository = new EventRepository();
            $eventAttachmentRepository = new EventAttachmentRepository();
            $eventRecipientRepository = new EventRecipientRepository();
            $eventApplicableToRepository = new EventApplicableToRepository();
            $staffSubCategoryRepository = new StaffSubCategoryRepository();
            $standardSubjectRepository = new StandardSubjectRepository();
            $uploadService = new UploadService();

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $eventName = $eventData->eventName;
            $eventStartDate = Carbon::createFromFormat('d/m/Y', $eventData->eventStartDate)->format('Y-m-d');
            $eventEndDate = Carbon::createFromFormat('d/m/Y', $eventData->eventEndDate)->format('Y-m-d');
            $eventStartTime = $eventData->eventStartTime;
            $eventEndTime = $eventData->eventEndTime;
            $eventDetail = $eventData->eventDetails;
            $eventType = $eventData->eventType;
            $eventAttendanceRequired = $eventData->attendanceRequired;
            $eventReceiptRequired = $eventData->receiptRequired;

            $check = Event::where('id_institute', $institutionId)
                            ->where('id_academic', $academicYear)
                            ->where('name', $eventName)
                            ->where('start_date', $eventStartDate)
                            ->where('end_date', $eventEndDate)
                            ->where('start_time', $eventStartTime)
                            ->where('end_time', $eventEndTime)->first();

            if(!$check){

                $data = array(
                    'id_institute' => $institutionId,
                    'id_academic' => $academicYear,
                    'name' => $eventName,
                    'start_date' => $eventStartDate,
                    'end_date' => $eventEndDate,
                    'start_time' => $eventStartTime,
                    'end_time' => $eventEndTime,
                    'event_detail' => $eventDetail,
                    'event_type' => $eventType,
                    'attendance_required' => $eventAttendanceRequired,
                    'receipt_required' => $eventReceiptRequired,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );

                $storeData = $eventRepository->store($data);

                if($storeData){

                    $lastInsertedId = $storeData->id;

                    // Insert event attachment
                    if($eventData->eventAttachment){

                        foreach($eventData->eventAttachment as $attachment){

                            $path = 'Event';
                            $attachmentEvent = $uploadService->fileUpload($attachment, $path);

                            $data = array(
                                'id_event' => $lastInsertedId,
                                'file_url' => $attachmentEvent,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );
                            $eventAttachmentRepository->store($data);
                        }
                    };

                    // Insert event applicable to
                    if($eventData->recipientType){

                        foreach($eventData->recipientType as $eventRecipient){

                            if($eventRecipient == 'STAFF'){

                                // Applicable to
                                foreach($eventData->staffCategory as $staffCategory){

                                    foreach($eventData->staffSubcategory as $staffSubcategory){

                                        $data = $staffSubCategoryRepository->findSubCategory($staffCategory, $staffSubcategory);
                                        // dd($data);

                                        if($data){
                                            $applicableTo = array(
                                                'id_event' => $lastInsertedId,
                                                'recipient_type' => $eventRecipient,
                                                'id_staff_category' => $staffCategory,
                                                'id_staff_subcategory' => $staffSubcategory,
                                                'created_by' => Session::get('userId'),
                                                'created_at' => Carbon::now()
                                            );

                                            $storeEventApplicableTo = $eventApplicableToRepository->store($applicableTo);
                                        }
                                    }
                                }

                                // Recipient
                                foreach($eventData->staff as $index => $staff){

                                    $data = array(
                                        'id_event' => $lastInsertedId,
                                        'recipient_type' => $eventRecipient,
                                        'id_recipient' => $staff,
                                        'created_by' => Session::get('userId'),
                                        'created_at' => Carbon::now()
                                    );

                                    $storeEventRecipient = $eventRecipientRepository->store($data);
                                }

                            }else{

                                // Applicable to
                                foreach($eventData->standard as $standard){

                                    foreach($eventData->subject as $subject){

                                        $data = $standardSubjectRepository->findStandardSubject($standard, $subject);

                                        if($data){
                                            $applicableTo = array(
                                                'id_event' => $lastInsertedId,
                                                'recipient_type' => $eventRecipient,
                                                'id_standard' => $standard,
                                                'id_subject' => $subject,
                                                'created_by' => Session::get('userId'),
                                                'created_at' => Carbon::now()
                                            );

                                            $storeEventApplicableTo = $eventApplicableToRepository->store($applicableTo);
                                        }
                                    }
                                }

                                // Recipient
                                foreach($eventData->student as $index => $student){

                                    $data = array(
                                        'id_event' => $lastInsertedId,
                                        'recipient_type' => $eventRecipient,
                                        'id_recipient' => $student,
                                        'created_by' => Session::get('userId'),
                                        'created_at' => Carbon::now()
                                    );

                                    $storeEventRecipient = $eventRecipientRepository->store($data);
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

        // Get particular event
        public function getEventSelectedData($idEvent){

            $eventRepository = new EventRepository();
            $eventApplicableToRepository = new EventApplicableToRepository();
            $eventRecipientRepository = new EventRecipientRepository();
            $staffRepository = new StaffRepository();
            $studentService = new StudentService();
            $eventAttachmentRepository = new EventAttachmentRepository();

            $eventAttachment = $eventAttachmentRepository->fetch($idEvent);

            foreach($eventAttachment as $key => $attachment){
                $ext = pathinfo($attachment['file_url'], PATHINFO_EXTENSION);
                $eventAttachment[$key] = $attachment;
                $eventAttachment[$key]['extension'] = $ext;
            }

            $selectedStaffCategoryData = array();
            $selectedStaffSubCategoryData = array();
            $selectedStaffCategory = array();
            $selectedStaffSubCategory = array();
            $selectedSandardSubject = array();
            $selectedStudentStandard = array();
            $selectedStudentData = array();
            $selectedStaffData = array();
            $recepientArray = array();
            $allStaffs = array();
            $allStudents = array();

            $eventData = $eventRepository->fetch($idEvent);

            if($eventData){

                $eventData['startDate'] = Carbon::createFromFormat('Y-m-d', $eventData->start_date)->format('d/m/Y');;
                $eventData['endDate'] = Carbon::createFromFormat('Y-m-d', $eventData->end_date)->format('d/m/Y');;

                $recepientTypes = $eventRecipientRepository->eventRecepientType($idEvent);

                foreach($recepientTypes as $recepientType){

                    array_push($recepientArray, $recepientType->recipient_type);

                    if($recepientType->recipient_type == "STAFF"){

                        $selectedStaffCategoryData = $eventApplicableToRepository->allEventCategory($idEvent, $recepientType->recipient_type);

                        foreach($selectedStaffCategoryData as $staffCategory){
                            array_push($selectedStaffCategory, $staffCategory['id_staff_category']);
                        }

                        $selectedStaffSubCategoryData = $eventApplicableToRepository->allEventSubCategory($idEvent, $recepientType->recipient_type);

                        foreach($selectedStaffSubCategoryData as $staffSubCategory){
                            array_push($selectedStaffSubCategory, $staffSubCategory['id_staff_subcategory']);
                        }

                        $selectedStaffs = $eventRecipientRepository->eventRecepients($idEvent, $recepientType->recipient_type);

                        foreach($selectedStaffs as $staffId){
                            array_push($selectedStaffData, $staffId['id_recipient']);
                        }

                        $allStaffs = $staffRepository->getStaffOnCategoryAndSubcategory($selectedStaffCategory, $selectedStaffSubCategory);

                    }else{

                        $selectedSatndards = $eventApplicableToRepository->allEventStandards($idEvent, $recepientType->recipient_type);

                        foreach($selectedSatndards as $studentStandard){
                            array_push($selectedStudentStandard, $studentStandard['id_standard']);
                        }

                        $selectedStandardSubject = $eventApplicableToRepository->allEventSubjects($idEvent, $recepientType->recipient_type);

                        foreach($selectedStandardSubject as $standardSubject){
                            array_push($selectedSandardSubject, $standardSubject['id_subject']);
                        }

                        $requestData = array(
                            'subjectId' => $selectedSandardSubject,
                            'standardId' => $selectedStudentStandard
                        );

                        $allStudents = $studentService->getAllStudent($requestData);

                        $selectedStudents = $eventRecipientRepository->eventRecepients($idEvent, $recepientType->recipient_type);

                        foreach($selectedStudents as $studentId){
                            array_push($selectedStudentData, $studentId['id_recipient']);
                        }
                    }
                }
            }

            $output = array(
                'eventData' => $eventData,
                'recepientTypes' => $recepientArray,
                'selectedStaffCategory' => $selectedStaffCategory,
                'selectedStaffSubCategory' => $selectedStaffSubCategory,
                'selectedStandardSubject' => $selectedSandardSubject,
                'selectedStandards' => $selectedStudentStandard,
                'selectedStaffs' => $selectedStaffData,
                'selectedStudents' => $selectedStudentData,
                'allStaffs' => $allStaffs,
                'allStudents' => $allStudents,
                'eventAttachment' => $eventAttachment
            );

            return $output;
        }

        // Update event
        public function update($eventData, $id){

            $eventRepository = new EventRepository();
            $eventAttachmentRepository = new EventAttachmentRepository();
            $eventRecipientRepository = new EventRecipientRepository();
            $eventApplicableToRepository = new EventApplicableToRepository();
            $staffSubCategoryRepository = new StaffSubCategoryRepository();
            $standardSubjectRepository = new StandardSubjectRepository();
            $uploadService = new UploadService();

            $eventName = $eventData->eventName;
            $eventStartDate = Carbon::createFromFormat('d/m/Y', $eventData->eventStartDate)->format('Y-m-d');
            $eventEndDate = Carbon::createFromFormat('d/m/Y', $eventData->eventEndDate)->format('Y-m-d');
            $eventStartTime = $eventData->eventStartTime;
            $eventEndTime = $eventData->eventEndTime;
            $eventDescription = $eventData->eventDetails;
            $eventType = $eventData->eventType;
            $eventAttendanceRequired = $eventData->attendanceRequired;
            $eventReceiptRequired = $eventData->receiptRequired;

            $eventDetail = $eventRepository->fetch($id);
            $eventDetail->name = $eventName;
            $eventDetail->start_date = $eventStartDate;
            $eventDetail->end_date = $eventEndDate;
            $eventDetail->start_time = $eventStartTime;
            $eventDetail->end_time = $eventEndTime;
            $eventDetail->event_detail = $eventDescription;
            $eventDetail->event_type = $eventType;
            $eventDetail->attendance_required = $eventAttendanceRequired;
            $eventDetail->receipt_required = $eventReceiptRequired;
            $eventDetail->modified_by = Session::get('userId');
            $eventDetail->updated_at = Carbon::now();

            $updateData = $eventRepository->update($eventDetail);

            if($updateData){

                if($eventData->eventAttachment != ""){
                    //$deleteAttachment = $eventAttachmentRepository->delete($id);
                    if($eventData->hasfile('eventAttachment')){

                        foreach($eventData->eventAttachment as $attachment){

                            $path = 'Event';
                            $attachmentCircular = $uploadService->fileUpload($attachment, $path);

                            $data = array(
                                'id_event' => $id,
                                'file_url' => $attachmentCircular,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );

                            $storeAttachment = $eventAttachmentRepository->store($data);
                            // dd($storeAttachment);
                        }
                    }
                }

                // Update event applicable to
                if($eventData->applicableTo){

                    $deleteApplicableTo = $eventApplicableToRepository->delete($id);
                    $deleteRecepient = $eventRecipientRepository->delete($id);

                    foreach($eventData->applicableTo as $recipientType){

                        if($recipientType == 'STAFF'){

                            // Applicable to
                            if(isset($eventData->staffCategory)){

                                foreach($eventData->staffCategory as $staffCategory){

                                    foreach($eventData->staffSubcategory as $staffSubcategory){

                                        $data = $staffSubCategoryRepository->findSubCategory($staffCategory, $staffSubcategory);
                                        // dd($data);

                                        if($data){
                                            $applicableTo = array(
                                                'id_event' => $id,
                                                'recipient_type' => $recipientType,
                                                'id_staff_category' => $staffCategory,
                                                'id_staff_subcategory' => $staffSubcategory,
                                                'created_by' => Session::get('userId'),
                                                'created_at' => Carbon::now()
                                            );

                                            $storeEventApplicableTo = $eventApplicableToRepository->store($applicableTo);
                                        }
                                    }
                                }

                                // Recipient
                                if(isset($eventData->staff)){

                                    foreach($eventData->staff as $index => $staff){

                                        $data = array(
                                            'id_event' => $id,
                                            'recipient_type' => $recipientType,
                                            'id_recipient' => $staff,
                                            'created_by' => Session::get('userId'),
                                            'created_at' => Carbon::now()
                                        );

                                        $storeEventRecipient = $eventRecipientRepository->store($data);
                                    }
                                }
                            }

                        }else{

                            // Applicable to
                            if(isset($eventData->standard)){

                                foreach($eventData->standard as $standard){

                                    foreach($eventData->subject as $subject){

                                        $data = $standardSubjectRepository->findStandardSubject($standard, $subject);

                                        if($data){
                                            $applicableTo = array(
                                                'id_event' => $id,
                                                'recipient_type' => $recipientType,
                                                'id_standard' => $standard,
                                                'id_subject' => $subject,
                                                'created_by' => Session::get('userId'),
                                                'created_at' => Carbon::now()
                                            );
                                            $storeEventApplicableTo = $eventApplicableToRepository->store($applicableTo);
                                        }
                                    }
                                }

                                if(isset($eventData->student)){

                                    foreach($eventData->student as $index => $student){

                                        $data = array(
                                            'id_event' => $id,
                                            'recipient_type' => $recipientType,
                                            'id_recipient' => $student,
                                            'created_by' => Session::get('userId'),
                                            'created_at' => Carbon::now()
                                        );

                                        $storeEventRecipient = $eventRecipientRepository->store($data);
                                    }
                                }
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

        // Delete event
        public function delete($id){

            $eventRepository = new EventRepository();
            $event = $eventRepository->delete($id);

            if($event){
                $signal = 'success';
                $msg = 'Event deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Download event attachment zip
        public function downloadEventFiles($id){

            $eventAttachmentRepository = new EventAttachmentRepository();

            $zip = new ZipArchive;
            $fileName = 'event_'.time().'.zip';
            $zip->open($fileName, \ZipArchive::CREATE);

            $eventAttachment = $eventAttachmentRepository->fetch($id);

            foreach ($eventAttachment as $file) {
                $files = explode('Event/', $file->file_url);
                $zip->addFromString($files[1], file_get_contents($file->file_url));
            }

            $zip->close();
            header('Content-disposition: attachment; filename='.time().'.zip');
            header('Content-type: application/zip');
            readfile($fileName);
        }

        // Deleted event records
        public function getDeletedRecords(){

            $eventRepository = new EventRepository();
            $eventRecipientRepository = new EventRecipientRepository();

            $eventData = $eventRepository->allDeleted();
            $eventDetail = array();

            foreach($eventData as $key => $event){

                $eventDetail[$key] = $event;
                $recepientData = '';

                $recepient = $eventRecipientRepository->eventRecepientType($event->id);

                if($recepient){

                    foreach($recepient as $rec){
                        $recepientData .= $rec['recipient_type'].', ';
                    }

                    $recepientData = substr($recepientData, 0, -2);
                }

                $eventDetail[$key]['recepient'] = $recepientData;
            }

            return $eventDetail;
        }

        // Restore event records
        public function restore($id){

            $eventRepository = new EventRepository();

            $event = $eventRepository->restore($id);

            if($event){

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
