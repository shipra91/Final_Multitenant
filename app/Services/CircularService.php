<?php
    namespace App\Services;
    use App\Models\Circular;
    use App\Services\CircularService;
    use App\Repositories\CircularRepository;
    use App\Repositories\StaffSubCategoryRepository;
    use App\Repositories\StandardSubjectRepository;
    use App\Repositories\CircularAttachmentRepository;
    use App\Repositories\CircularRecipientRepository;
    use App\Repositories\CircularApplicableToRepository;
    use App\Repositories\StaffCategoryRepository;
    use App\Repositories\StaffRepository;
    use App\Services\InstitutionStandardService;
    use App\Services\StandardSubjectService;
    use App\Services\StudentService;
    use Carbon\Carbon;
    use Storage;
    use Session;
    use ZipArchive;
    use DB;

    class CircularService{

        public function getCircularData($allSessions){

            $staffCategoryRepository = new StaffCategoryRepository();
            $staffSubCategoryRepository = new StaffSubCategoryRepository();
            $institutionStandardService = new InstitutionStandardService();
            $standardSubjectService = new StandardSubjectService();
            $standardIds = array();

            $staffCategory = $staffCategoryRepository->all();
            $staffSubCategory = $staffSubCategoryRepository->all();

            $institutionStandards = $institutionStandardService->fetchStandard($allSessions);

            foreach($institutionStandards as $institutionStandard){
                array_push($standardIds, $institutionStandard['institutionStandard_id']);
            }
            $standardSubjects = $standardSubjectService->getStandardsSubject($standardIds, $allSessions);

            $output = array(
                'staffCategory' => $staffCategory,
                'staffSubcategory' => $staffSubCategory,
                'institutionStandards' => $institutionStandards,
                'standardSubjects' => $standardSubjects
            );

            return $output;
        }

        // View circular
        public function getAll($allSessions){

            $circularRepository = new CircularRepository();
            $circularRecipientRepository = new CircularRecipientRepository();
            $circularAttachmentRepository = new CircularAttachmentRepository();

            $circularDetail = array();
            $circularData = $circularRepository->all($allSessions);

            foreach($circularData as $key => $circular){

                $circularDetail[$key] = $circular;
                $recepientData = '';

                $recepient = $circularRecipientRepository->circularRecepientType($circular->id);
                $circularAttachment = $circularAttachmentRepository->fetch($circular->id);

                if(count($circularAttachment) > 0){
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

               $circularDetail[$key]['recepient'] = $recepientData;
               $circularDetail[$key]['circularAttachment'] = $circularAttachment;
               $circularDetail[$key]['status'] = $status;
            }
            // dd($circularDetail);
            return $circularDetail;
        }

        // Insert circular
        public function add($circularData){

            $allSessions = session()->all();
            $institutionId = $circularData->id_institute;
            $academicYear = $circularData->id_academic;

            $circularRepository = new CircularRepository();
            $circularAttachmentRepository = new CircularAttachmentRepository();
            $circularRecipientRepository = new CircularRecipientRepository();
            $circularApplicableToRepository = new CircularApplicableToRepository();
            $staffSubCategoryRepository = new StaffSubCategoryRepository();
            $standardSubjectRepository = new StandardSubjectRepository();
            $uploadService = new UploadService();

            $name = $circularData->circular_title;
            $startDate = Carbon::createFromFormat('d/m/Y', $circularData->startDate)->format('Y-m-d');
            $endDate = Carbon::createFromFormat('d/m/Y', $circularData->endDate)->format('Y-m-d');
            $detail = $circularData->circular_details;
            $smsRequired = $circularData->sms_alert;
            $receiptRequired = $circularData->receiptRequired;

            $check = Circular::where('id_institute', $institutionId)
                            ->where('id_academic', $academicYear)
                            ->where('circular_title', $name)
                            ->where('start_date', $startDate)
                            ->where('end_date', $endDate)->first();

            if(!$check){

                $data = array(
                    'id_institute' => $institutionId,
                    'id_academic' => $academicYear,
                    'circular_title' => $name,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'description' => $detail,
                    'sms_alert' => $smsRequired,
                    'receipt_required' => $receiptRequired,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );

                $storeData = $circularRepository->store($data);

                if($storeData){

                    $lastInsertedId = $storeData->id;
                    // dd($circularData->circularAttachment);
                    // Insert event attachment
                    if($circularData->hasfile('circularAttachment')){

                        $path = 'Circular';

                        foreach($circularData->circularAttachment as $attachment){

                            $attachmentCircular = $uploadService->fileUpload($attachment, $path);

                            $data = array(
                                'id_circular' => $lastInsertedId,
                                'file_url' => $attachmentCircular,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );

                            $storeAttachment = $circularAttachmentRepository->store($data);
                            // dd($storeAttachment);
                        }
                    }

                    // Insert event recipient
                    if($circularData->applicableTo){

                        foreach($circularData->applicableTo as $recipientType){

                            if($recipientType == 'STAFF'){

                                // Applicable to
                                foreach($circularData->staffCategory as $staffCategory){

                                    foreach($circularData->staffSubcategory as $staffSubcategory){

                                        $data = $staffSubCategoryRepository->findSubCategory($staffCategory, $staffSubcategory);
                                        // dd($data);

                                        if($data){
                                            $applicableTo = array(
                                                'id_circular' => $lastInsertedId,
                                                'recipient_type' => $recipientType,
                                                'id_staff_category' => $staffCategory,
                                                'id_staff_subcategory' => $staffSubcategory,
                                                'created_by' => Session::get('userId'),
                                                'created_at' => Carbon::now()
                                            );

                                            $storeCircularApplicableTo = $circularApplicableToRepository->store($applicableTo);
                                        }
                                    }
                                }

                                // recipient
                                foreach($circularData->staff as $index => $staff){

                                    $data = array(
                                        'id_circular' => $lastInsertedId,
                                        'recipient_type' => $recipientType,
                                        'id_recipient' => $staff,
                                        'created_by' => Session::get('userId'),
                                        'created_at' => Carbon::now()
                                    );

                                    $storeCircularRecipient = $circularRecipientRepository->store($data);
                                }

                            }else{

                                foreach($circularData->standard as $standard){

                                    foreach($circularData->subject as $subject){

                                        $data = $standardSubjectRepository->findStandardSubject($standard, $subject, $allSessions);

                                        if($data){

                                            $applicableTo = array(
                                                'id_circular' => $lastInsertedId,
                                                'recipient_type' => $recipientType,
                                                'id_standard' => $standard,
                                                'id_subject' => $subject,
                                                'created_by' => Session::get('userId'),
                                                'created_at' => Carbon::now()
                                            );

                                            $storeCircularApplicableTo = $circularApplicableToRepository->store($applicableTo);
                                        }
                                    }
                                }

                                foreach($circularData->student as $index => $student){

                                    $data = array(
                                        'id_circular' => $lastInsertedId,
                                        'recipient_type' => $recipientType,
                                        'id_recipient' => $student,
                                        'created_by' => Session::get('userId'),
                                        'created_at' => Carbon::now()
                                    );

                                    $storeCircularRecipient = $circularRecipientRepository->store($data);
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

        // Get particular circular
        public function getCircularSelectedData($idCircular, $allSessions){

            $circularRecipientRepository = new CircularRecipientRepository();
            $circularApplicableToRepository = new CircularApplicableToRepository();
            $circularAttachmentRepository = new CircularAttachmentRepository();
            $staffRepository = new StaffRepository();
            $circularRepository = new CircularRepository();
            $studentService = new StudentService();

            $output = array();
            $circularAttachments = $circularAttachmentRepository->fetch($idCircular);

            foreach($circularAttachments as $key => $attachment){
                $ext = pathinfo($attachment['file_url'], PATHINFO_EXTENSION);
                $circularAttachments[$key] = $attachment;
                $circularAttachments[$key]['extension'] = $ext;
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

            $circularData = $circularRepository->fetch($idCircular);

            if($circularData){

                $circularData['startDate'] = Carbon::createFromFormat('Y-m-d', $circularData->start_date)->format('d/m/Y');
                $circularData['endDate'] = Carbon::createFromFormat('Y-m-d', $circularData->end_date)->format('d/m/Y');

                $recepientTypes = $circularRecipientRepository->circularRecepientType($idCircular);

                foreach($recepientTypes as $recepientType){

                    array_push($recepientArray, $recepientType->recipient_type);

                    if($recepientType->recipient_type == "STAFF"){

                        $selectedStaffCategoryData = $circularApplicableToRepository->allCircularCategory($idCircular, $recepientType->recipient_type);
                        foreach($selectedStaffCategoryData as $staffCategory){
                            array_push($selectedStaffCategory, $staffCategory['id_staff_category']);
                        }

                        $selectedStaffSubCategoryData = $circularApplicableToRepository->allCircularSubCategory($idCircular, $recepientType->recipient_type);
                        foreach($selectedStaffSubCategoryData as $staffSubCategory){
                            array_push($selectedStaffSubCategory, $staffSubCategory['id_staff_subcategory']);
                        }

                        $selectedStaffs = $circularRecipientRepository->circularRecepients($idCircular, $recepientType->recipient_type);
                        foreach($selectedStaffs as $staffId){
                            array_push($selectedStaffData, $staffId['id_recipient']);
                        }

                        $allStaffs = $staffRepository->getStaffOnCategoryAndSubcategory($selectedStaffCategory, $selectedStaffSubCategory, $allSessions);


                    }else{

                        $selectedSatndards = $circularApplicableToRepository->allCircularStandards($idCircular, $recepientType->recipient_type);
                        foreach($selectedSatndards as $studentStandard){
                            array_push($selectedStudentStandard, $studentStandard['id_standard']);
                        }

                        $selectedStandardSubject = $circularApplicableToRepository->allCircularSubjects($idCircular, $recepientType->recipient_type);
                        foreach($selectedStandardSubject as $standardSubject){
                            array_push($selectedSandardSubject, $standardSubject['id_subject']);
                        }

                        $requestData = array(
                            'subjectId' => $selectedSandardSubject,
                            'standardId' => $selectedStudentStandard
                        );

                        $allStudents = $studentService->getAllStudent($requestData, $allSessions);

                        $selectedStudents = $circularRecipientRepository->circularRecepients($idCircular, $recepientType->recipient_type);
                        foreach($selectedStudents as $studentId){
                            array_push($selectedStudentData, $studentId['id_recipient']);
                        }
                    }
                }
            }

            $output = array(
                'circularData' => $circularData,
                'recepientTypes' => $recepientArray,
                'selectedStaffCategory' => $selectedStaffCategory,
                'selectedStaffSubCategory' => $selectedStaffSubCategory,
                'selectedStandardSubject' => $selectedSandardSubject,
                'selectedStandards' => $selectedStudentStandard,
                'selectedStaffs' => $selectedStaffData,
                'selectedStudents' => $selectedStudentData,
                'allStaffs' => $allStaffs,
                'allStudents' => $allStudents,
                'circularAttachments' => $circularAttachments
            );

            return $output;
        }

        // Update circular
        public function update($circularData, $id, $allSessions){

            $circularRepository = new CircularRepository();
            $circularAttachmentRepository = new CircularAttachmentRepository();
            $circularRecipientRepository = new CircularRecipientRepository();
            $circularApplicableToRepository = new CircularApplicableToRepository();
            $staffSubCategoryRepository = new StaffSubCategoryRepository();
            $standardSubjectRepository = new StandardSubjectRepository();
            $uploadService = new UploadService();

            $name = $circularData->circular_title;
            $startDate = Carbon::createFromFormat('d/m/Y', $circularData->start_date)->format('Y-m-d');
            $endDate = Carbon::createFromFormat('d/m/Y', $circularData->end_date)->format('Y-m-d');
            $detail = $circularData->circular_details;
            $smsRequired = $circularData->sms_alert;
            $receiptRequired = $circularData->receiptRequired;

            // Fetch circular data
            $circularDetail = $circularRepository->fetch($id);

            $circularDetail->circular_title = $name;
            $circularDetail->start_date = $startDate;
            $circularDetail->end_date = $endDate;
            $circularDetail->description = $detail;
            $circularDetail->sms_alert = $smsRequired;
            $circularDetail->receipt_required = $receiptRequired;
            $circularDetail->modified_by = Session::get('userId');
            $circularDetail->updated_at = Carbon::now();

            $storeData = $circularRepository->update($circularDetail);

            if($storeData){

                if($circularData->circularAttachment != ""){
                    //$deleteAttachment = $circularAttachmentRepository->delete($id);
                    if($circularData->hasfile('circularAttachment')){

                        foreach($circularData->circularAttachment as $attachment){

                            $path = 'Circular';
                            $attachmentCircular = $uploadService->fileUpload($attachment, $path);

                            $data = array(
                                'id_circular' => $id,
                                'file_url' => $attachmentCircular,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );

                            $storeAttachment = $circularAttachmentRepository->store($data);
                            // dd($storeAttachment);
                        }
                    }
                }

                // Insert event recipient
                // dd($circularData);
                if($circularData->applicableTo){

                    $deleteApplicableTo = $circularApplicableToRepository->delete($id);
                    $deleteRecepient = $circularRecipientRepository->delete($id);

                    foreach($circularData->applicableTo as $recipientType){

                        if($recipientType == 'STAFF'){

                            // Applicable to
                            foreach($circularData->staffCategory as $staffCategory){

                                foreach($circularData->staffSubcategory as $staffSubcategory){

                                    $data = $staffSubCategoryRepository->findSubCategory($staffCategory, $staffSubcategory);
                                    // dd($data);

                                    if($data){
                                        $applicableTo = array(
                                            'id_circular' => $id,
                                            'recipient_type' => $recipientType,
                                            'id_staff_category' => $staffCategory,
                                            'id_staff_subcategory' => $staffSubcategory,
                                            'created_by' => Session::get('userId'),
                                            'created_at' => Carbon::now()
                                        );

                                        $storeCircularApplicableTo = $circularApplicableToRepository->store($applicableTo);
                                    }
                                }
                            }

                            // recipient
                            foreach($circularData->staff as $index => $staff){

                                $data = array(
                                    'id_circular' => $id,
                                    'recipient_type' => $recipientType,
                                    'id_recipient' => $staff,
                                    'created_by' => Session::get('userId'),
                                    'created_at' => Carbon::now()
                                );

                                $storeCircularRecipient = $circularRecipientRepository->store($data);
                            }

                        }else{

                            foreach($circularData->standard as $standard){

                                foreach($circularData->subject as $subject){

                                    $data = $standardSubjectRepository->findStandardSubject($standard, $subject, $allSessions);

                                    if($data){
                                        $applicableTo = array(
                                            'id_circular' => $id,
                                            'recipient_type' => $recipientType,
                                            'id_standard' => $standard,
                                            'id_subject' => $subject,
                                            'created_by' => Session::get('userId'),
                                            'created_at' => Carbon::now()
                                        );

                                        $storeCircularApplicableTo = $circularApplicableToRepository->store($applicableTo);
                                    }
                                }
                            }

                            foreach($circularData->student as $index => $student){

                                $data = array(
                                    'id_circular' => $id,
                                    'recipient_type' => $recipientType,
                                    'id_recipient' => $student,
                                    'created_by' => Session::get('userId'),
                                    'created_at' => Carbon::now()
                                );

                                $storeCircularRecipient = $circularRecipientRepository->store($data);
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

        // Delete circular
        public function delete($id){

            $circularRepository = new CircularRepository();

            $circular = $circularRepository->delete($id);

            if($circular){
                $signal = 'success';
                $msg = 'Circular deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Download circular attachment zip
        public function downloadCircularFiles($idCircular){

            $circularAttachmentRepository = new CircularAttachmentRepository();

            $zip = new ZipArchive;
            $fileName = 'circular_'.time().'.zip';
            $zip->open($fileName, \ZipArchive::CREATE);

            $circularFiles = $circularAttachmentRepository->fetch($idCircular);

            foreach ($circularFiles as $file){
                $files = explode('Circular/', $file->file_url);
                $zip->addFromString($files[1], file_get_contents($file->file_url));
            }

            $zip->close();
            header('Content-disposition: attachment; filename='.time().'.zip');
            header('Content-type: application/zip');
            readfile($fileName);
        }

        // Deleted circular records
        public function getDeletedRecords($allSessions){

            $circularRecipientRepository = new CircularRecipientRepository();
            $circularRepository = new CircularRepository();

            $circularData = $circularRepository->allDeleted($allSessions);
            $circularDetail = array();

            foreach($circularData as $key => $circular){

                $recepient = $circularRecipientRepository->circularRecepientType($circular->id);

                $circularDetail[$key] = $circular;
                $recepientData = '';


                if($recepient){

                    foreach($recepient as $rec){
                        $recepientData .= $rec['recipient_type'].', ';
                    }

                    $recepientData = substr($recepientData, 0, -2);
                }

               $circularDetail[$key]['recepient'] = $recepientData;
            }

            return $circularDetail;
        }

        // Restore circular records
        public function restore($id){

            $circularRepository = new CircularRepository();

            $circular = $circularRepository->restore($id);

            if($circular){
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

        //get own circulars
        public function viewOwnCirculars($allSessions){

            $circularRepository = new CircularRepository();
            $circularAttachmentRepository = new CircularAttachmentRepository();

            $circularDetail = array();
            $circularData = $circularRepository->getRecipientCirculars($allSessions['userId'], $allSessions['institutionId'], $allSessions['academicYear']);

            foreach($circularData as $key => $circular){

                $circularDetail[$key] = $circular;

                $circularAttachment = $circularAttachmentRepository->fetch($circular->id);

                if(count($circularAttachment) > 0){
                    $status = 'file_found';
                }else{
                    $status = 'file_not_found';
                }

               $circularDetail[$key]['circularAttachment'] = $circularAttachment;
               $circularDetail[$key]['status'] = $status;
            }
            // dd($circularDetail);
            return $circularDetail;
        }
    }
