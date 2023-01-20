<?php
    namespace App\Services;

    use App\Models\Holiday;
    use App\Repositories\HolidayRepository;
    use App\Repositories\StaffCategoryRepository;
    use App\Repositories\StaffSubCategoryRepository;
    use App\Repositories\HolidayAttachmentRepository;
    use App\Repositories\HolidayApplicableForRepository;
    use Carbon\Carbon;
    use Storage;
    use Session;
    use ZipArchive;
    use DB;

    class HolidayService {

        // View holiday data
        public function getHolidayData(){

            $holidayRepository = new HolidayRepository();
            $staffCategoryRepository = new StaffCategoryRepository();
            $staffSubCategoryRepository = new StaffSubCategoryRepository();
            $institutionStandardService = new InstitutionStandardService();

            $holiday = $holidayRepository->all();
            $staffCategory = $staffCategoryRepository->all();
            $staffSubCategory = $staffSubCategoryRepository->all();
            $institutionStandards = $institutionStandardService->fetchStandard();

            $output = array(
                'staffCategory' => $staffCategory,
                'staffSubcategory' => $staffSubCategory,
                'institutionStandards' => $institutionStandards
            );

            return $output;
        }

        // View holiday
        public function getAll(){

            $holidayRepository = new HolidayRepository();
            $holidayApplicableForRepository = new HolidayApplicableForRepository();
            $holidayAttachmentRepository = new HolidayAttachmentRepository();

            $holidayDetail = array();
            $holidayData = $holidayRepository->all();

            foreach($holidayData as $key => $holiday){

                $holidayDetail[$key] = $holiday;
                $recepientData = '';

                $recepient = $holidayApplicableForRepository->holidayRecepientType($holiday->id);
                $holidayAttachment = $holidayAttachmentRepository->fetch($holiday->id);

                if(count($holidayAttachment) > 0){
                    $status = 'file_found';
                }else{
                    $status = 'file_not_found';
                }

                if($recepient){
                    foreach($recepient as $rec){
                        $recepientData .= $rec['applicable_for'].', ';
                    }
                    $recepientData = substr($recepientData, 0, -2);
                }

                $holidayDetail[$key]['recepient'] = $recepientData;
                $holidayDetail[$key]['holidayAttachment'] = $holidayAttachment;
                $holidayDetail[$key]['status'] = $status;
            }

            return $holidayData;
        }

        // public function find($id){
        //     $holidayRepository = new HolidayRepository();
        //     $holiday = $holidayRepository->fetch($id);
        //     return $holiday;
        // }

        // Insert holiday
        public function add($holidayData){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicId = $allSessions['academicYear'];

            $holidayRepository = new HolidayRepository();
            $holidayAttachmentRepository = new HolidayAttachmentRepository();
            $holidayApplicableForRepository = new HolidayApplicableForRepository();
            $staffSubCategoryRepository = new StaffSubCategoryRepository();
            $uploadService = new UploadService();

            $check = Holiday::where('title', $holidayData->title)->first();

            $startDate = Carbon::createFromFormat('d/m/Y', $holidayData->start_date)->format('Y-m-d');
            $endDate = Carbon::createFromFormat('d/m/Y', $holidayData->end_date)->format('Y-m-d');

            if(!$check){

                $data = array(
                    'id_institute' => $institutionId,
                    'id_academic' => $academicId,
                    'title' => $holidayData->holiday_title,
                    'description' => $holidayData->holiday_details,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );

                $storeData = $holidayRepository->store($data);

                if($storeData){

                    $lastInsertedId = $storeData->id;

                    if($holidayData->hasfile('attachment')){

                        $path = 'Holiday';
                        foreach($holidayData->attachment as $attachment){

                            $attachmentHoliday = $uploadService->fileUpload($attachment, $path);

                            $data = array(
                                'id_holiday' => $lastInsertedId,
                                'file_url' => $attachmentHoliday,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );

                            $storeAttachment = $holidayAttachmentRepository->store($data);
                            // dd($storeAttachment);
                        }
                    }

                    // Insert event recipient
                    if($holidayData->applicableTo){

                        foreach($holidayData->applicableTo as $recipientType){

                            if($recipientType == 'STAFF'){

                                // Applicable to
                                foreach($holidayData->staffCategory as $staffCategory){

                                    foreach($holidayData->staffSubcategory as $staffSubcategory){

                                        $data = $staffSubCategoryRepository->findSubCategory($staffCategory, $staffSubcategory);
                                        // dd($data);

                                        if($data){
                                            $applicableTo = array(
                                                'id_holiday' => $lastInsertedId,
                                                'applicable_for' => $recipientType,
                                                'id_staff_category' => $staffCategory,
                                                'id_staff_subcategory' => $staffSubcategory,
                                                'created_by' => Session::get('userId'),
                                                'created_at' => Carbon::now()
                                            );

                                            $storeHolidayApplicableTo = $holidayApplicableForRepository->store($applicableTo);
                                        }
                                    }
                                }

                            }else{

                                foreach($holidayData->standard as $standard){

                                    $applicableTo = array(
                                        'id_holiday' => $lastInsertedId,
                                        'applicable_for' => $recipientType,
                                        'id_standard' => $standard,
                                        'created_by' => Session::get('userId'),
                                        'created_at' => Carbon::now()
                                    );

                                    $storeHolidayApplicableTo = $holidayApplicableForRepository->store($applicableTo);
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

        // Update holiday
        public function update($holidayData, $id){

            $allSessions = session()->all();
            $institutionId = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $holidayRepository = new HolidayRepository();
            $holidayAttachmentRepository = new HolidayAttachmentRepository();
            $holidayApplicableForRepository = new HolidayApplicableForRepository();
            $staffSubCategoryRepository = new StaffSubCategoryRepository();
            $uploadService = new UploadService();

            $startDate = Carbon::createFromFormat('d/m/Y', $holidayData->start_date)->format('Y-m-d');
            $endDate = Carbon::createFromFormat('d/m/Y', $holidayData->end_date)->format('Y-m-d');

            // Fetch holiday data
            $holidayDetail = $holidayRepository->fetch($id);

            $holidayDetail->title = $holidayData->holiday_title;
            $holidayDetail->description = $holidayData->holiday_details;
            $holidayDetail->start_date = $startDate;
            $holidayDetail->end_date = $endDate;
            $holidayDetail->modified_by = Session::get('userId');
            $holidayDetail->updated_at = Carbon::now();

            $storeData = $holidayRepository->update($holidayDetail);

            if($storeData){

                if($holidayData->attachment != ""){
                    //$deleteAttachment = $holidayAttachmentRepository->delete($id);
                    if($holidayData->hasfile('attachment')){

                        $path = 'Holiday';
                        foreach($holidayData->attachment as $attachment){

                            $attachmentHoliday = $uploadService->fileUpload($attachment, $path);

                            $data = array(
                                'id_holiday' => $id,
                                'file_url' => $attachmentHoliday,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );

                            $storeAttachment = $holidayAttachmentRepository->store($data);
                        }
                    }
                }

                // Insert event recipient
                if($holidayData->applicableTo){

                    $deleteApplicableTo = $holidayApplicableForRepository->delete($id);

                    foreach($holidayData->applicableTo as $recipientType){

                        if($recipientType == 'STAFF'){

                            // Applicable to
                            foreach($holidayData->staffCategory as $staffCategory){

                                foreach($holidayData->staffSubcategory as $staffSubcategory){

                                    $data = $staffSubCategoryRepository->findSubCategory($staffCategory, $staffSubcategory);
                                    // dd($data);

                                    if($data){
                                        $applicableTo = array(
                                            'id_holiday' => $id,
                                            'applicable_for' => $recipientType,
                                            'id_staff_category' => $staffCategory,
                                            'id_staff_subcategory' => $staffSubcategory,
                                            'created_by' => Session::get('userId'),
                                            'created_at' => Carbon::now()
                                        );

                                        $storeHolidayApplicableTo = $holidayApplicableForRepository->store($applicableTo);
                                    }
                                }
                            }

                        }else{

                            foreach($holidayData->standard as $standard){

                                $standardApplicableTo = array(
                                    'id_holiday' => $id,
                                    'applicable_for' => $recipientType,
                                    'id_standard' => $standard,
                                    'created_by' => Session::get('userId'),
                                    'created_at' => Carbon::now()
                                );

                                $storeHolidayApplicableTo = $holidayApplicableForRepository->store($standardApplicableTo);
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

        // Delete holiday
        public function delete($id){

            $holidayRepository = new HolidayRepository();
            $holidayApplicableForRepository = new HolidayApplicableForRepository();
            $holidayAttachmentRepository = new HolidayAttachmentRepository();

            $holiday = $holidayRepository->delete($id);

            if($holiday){
                $signal = 'success';
                $msg = 'Holiday deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Get particular holiday
        public function getHolidaySelectedData($idHoliday){

            $holidayApplicableForRepository = new HolidayApplicableForRepository();
            $holidayAttachmentRepository = new HolidayAttachmentRepository();
            $holidayRepository = new HolidayRepository();

            $selectedStaffCategoryData = array();
            $selectedStaffSubCategoryData = array();
            $selectedStaffCategory = array();
            $selectedStaffSubCategory = array();
            $selectedStudentStandard = array();
            $recepientArray = array();
            $holidayAttachments = array();

            $holidayData = $holidayRepository->fetch($idHoliday);
            $holidayAttachments = $holidayAttachmentRepository->fetch($idHoliday);

            foreach($holidayAttachments as $key => $attachment){
                $ext = pathinfo($attachment['file_url'], PATHINFO_EXTENSION);
                $holidayAttachments[$key] = $attachment;
                $holidayAttachments[$key]['extension'] = $ext;
            }

            $holidayData['startDate'] = Carbon::createFromFormat('Y-m-d', $holidayData->start_date)->format('d/m/Y');;
            $holidayData['endDate'] = Carbon::createFromFormat('Y-m-d', $holidayData->end_date)->format('d/m/Y');;

            $recepientTypes = $holidayApplicableForRepository->holidayRecepientType($idHoliday);
            // dd($recepientTypes);
            foreach($recepientTypes as $recepientType){

                array_push($recepientArray, $recepientType->applicable_for);

                if($recepientType->applicable_for == "STAFF"){

                    $selectedStaffCategoryData = $holidayApplicableForRepository->allHolidayCategory($idHoliday, $recepientType->applicable_for);
                    foreach($selectedStaffCategoryData as $staffCategory){
                        array_push($selectedStaffCategory, $staffCategory['id_staff_category']);
                    }

                    $selectedStaffSubCategoryData = $holidayApplicableForRepository->allHolidaySubCategory($idHoliday, $recepientType->applicable_for);
                    foreach($selectedStaffSubCategoryData as $staffSubCategory){
                        array_push($selectedStaffSubCategory, $staffSubCategory['id_staff_subcategory']);
                    }

                }else{
                    $selectedSatndards = $holidayApplicableForRepository->allHolidayStandards($idHoliday, $recepientType->applicable_for);
                    // dd($selectedSatndards);
                    foreach($selectedSatndards as $studentStandard){
                        array_push($selectedStudentStandard, $studentStandard['id_standard']);
                    }
                }
            }

            $output = array(
                'holidayData' => $holidayData,
                'recepientTypes' => $recepientArray,
                'selectedStaffCategory' => $selectedStaffCategory,
                'selectedStaffSubCategory' => $selectedStaffSubCategory,
                'selectedStandards' => $selectedStudentStandard,
                'holidayAttachments' => $holidayAttachments
            );

            return $output;
        }

        // Download holiday attachment zip
        public function downloadHolidayFiles($idHoliday){

            $holidayAttachmentRepository = new HolidayAttachmentRepository();

            $zip = new ZipArchive;
            $fileName = 'holiday_'.time().'.zip';
            $zip->open($fileName, \ZipArchive::CREATE);

            $holidayFiles = $holidayAttachmentRepository->fetch($idHoliday);

            foreach ($holidayFiles as $file){
                $files = explode('Holiday/', $file->file_url);
                $zip->addFromString($files[1], file_get_contents($file->file_url));
            }

            $zip->close();
            header('Content-disposition: attachment; filename='.time().'.zip');
            header('Content-type: application/zip');
            readfile($fileName);
        }

        // Deleted holiday records
        public function getDeletedRecords(){

            $holidayApplicableForRepository = new HolidayApplicableForRepository();
            $holidayAttachmentRepository = new HolidayAttachmentRepository();
            $holidayRepository = new HolidayRepository();

            $holidayData = $holidayRepository->allDeleted();
            $holidayDetail = array();

            foreach($holidayData as $key => $holiday){

                $recepient = $holidayApplicableForRepository->holidayRecepientType($holiday->id);

                $holidayDetail[$key] = $holiday;
                $recepientData = '';

                if($recepient){
                    foreach($recepient as $rec){
                        $recepientData .= $rec['applicable_for'].', ';
                    }
                    $recepientData = substr($recepientData, 0, -2);
                }

                $holidayDetail[$key]['recepient'] = $recepientData;
            }

            return $holidayDetail;
        }

        // Restore holiday records
        public function restore($id){

            $holidayRepository = new HolidayRepository();

            $holiday = $holidayRepository->restore($id);

            if($holiday){
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
?>
