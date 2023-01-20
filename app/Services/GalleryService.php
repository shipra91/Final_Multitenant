<?php
    namespace App\Services;
    use App\Models\Gallery;
    use App\Repositories\GalleryRepository;
    use App\Repositories\GalleryAttachmentRepository;
    use App\Repositories\GalleryAudienceRepository;
    use App\Repositories\StaffCategoryRepository;
    use App\Repositories\StaffSubCategoryRepository;
    use App\Services\InstitutionStandardService;
    use App\Services\UploadService;
    use Carbon\Carbon;
    use ZipArchive;
    use Session;
    use DB;

    class GalleryService {

        // Get gallery data
        public function getGalleryData($allSessions){

            $staffCategoryRepository = new StaffCategoryRepository();
            $staffSubCategoryRepository = new StaffSubCategoryRepository();
            $institutionStandardService = new InstitutionStandardService();

            $staffCategory = $staffCategoryRepository->all();
            $staffSubCategory = $staffSubCategoryRepository->all();
            $institutionStandards = $institutionStandardService->fetchStandard($allSessions);

            $output = array(
                'staffCategory' => $staffCategory,
                'staffSubcategory' => $staffSubCategory,
                'institutionStandards' => $institutionStandards,
            );

            return $output;
        }

        // View gallery
        public function getAll($allSessions){

            $galleryRepository = new GalleryRepository();
            $galleryAudienceRepository = new GalleryAudienceRepository();

            $galleryDetail = array();

            $galleryData = $galleryRepository->all($allSessions);

            foreach($galleryData as $key => $gallery){

                $galleryDetail[$key] = $gallery;
                $galleryData = '';

                $audience = $galleryAudienceRepository->galleryAudienceType($gallery->id);

                if($audience){

                    foreach($audience as $audienceType){
                        $galleryData .= $audienceType['audience_type'].', ';
                    }

                    $galleryData = substr($galleryData, 0, -2);
                }

                if($gallery->cover_image == ''){

                    $coverImage = "https://cdn.egenius.in/img/placeholder.jpg";

                }else {

                    $coverImage = $gallery->cover_image;
                }

                $galleryDetail[$key]['audienceType'] = $galleryData;
                $galleryDetail[$key]['coverImage'] = $coverImage;
            }

            return $galleryDetail;
        }

        // Get particular gallery
        public function getGallerySelectedData($idGallery){

            $galleryRepository = new GalleryRepository();
            $galleryAttachmentRepository = new GalleryAttachmentRepository();
            $galleryAudienceRepository = new GalleryAudienceRepository();

            $galleryAttachment = $galleryAttachmentRepository->fetch($idGallery);
            $galleryData = $galleryRepository->fetch($idGallery);

            $galleryData['date'] = Carbon::createFromFormat('Y-m-d', $galleryData->date)->format('d/m/Y');

            $audience = $galleryAudienceRepository->galleryAudienceType($idGallery);

            $selectedStaffCategoryData = array();
            $selectedStaffSubCategoryData = array();
            $selectedStaffCategory = array();
            $selectedStaffSubCategory = array();
            $selectedStudentStandard = array();
            $audienceArray = array();

            foreach($audience as $audienceType){

                array_push($audienceArray, $audienceType->audience_type);

                if($audienceType->audience_type == "STAFF"){

                    $selectedStaffCategoryData = $galleryAudienceRepository->allGalleryCategory($idGallery, $audienceType->audience_type);

                    foreach($selectedStaffCategoryData as $staffCategory){
                        array_push($selectedStaffCategory, $staffCategory['id_staff_category']);
                    }

                    $selectedStaffSubCategoryData = $galleryAudienceRepository->allGallerySubCategory($idGallery, $audienceType->audience_type);

                    foreach($selectedStaffSubCategoryData as $staffSubCategory){
                        array_push($selectedStaffSubCategory, $staffSubCategory['id_staff_subcategory']);
                    }

                }else{

                    $selectedSatndards = $galleryAudienceRepository->allGalleryStandards($idGallery, $audienceType->audience_type);

                    foreach($selectedSatndards as $studentStandard){
                        array_push($selectedStudentStandard, $studentStandard['id_standard']);
                    }
                }
            }

            $output = array(
                'galleryData' => $galleryData,
                'audienceType' => $audienceArray,
                'selectedStaffCategory' => $selectedStaffCategory,
                'selectedStaffSubCategory' => $selectedStaffSubCategory,
                'selectedStandards' => $selectedStudentStandard,
                'galleryAttachment' => $galleryAttachment
            );
            //dd($output);
            return $output;
        }

        // Insert gallery
        public function add($galleryData){

            $galleryRepository = new GalleryRepository();
            $galleryAttachmentRepository = new GalleryAttachmentRepository();
            $galleryAudienceRepository = new GalleryAudienceRepository();
            $staffSubCategoryRepository = new StaffSubCategoryRepository();
            $uploadService = new UploadService();

            $institutionId = $galleryData->id_institute;
            $academicYear = $galleryData->id_academic;

            $galleryName = $galleryData->galleryName;
            $date = Carbon::createFromFormat('d/m/Y', $galleryData->galleryDate)->format('Y-m-d');
            $galleryDetail = $galleryData->galleryDetails;

            // S3 File Upload Function Call
            if($galleryData->hasfile('coverImage')){
                $path = 'Gallery/Cover';
                $coverImage = $uploadService->fileUpload($galleryData->coverImage, $path);
            }

            $check = Gallery::where('id_institution', $institutionId)
                            ->where('id_academic_year', $academicYear)
                            ->where('title', $galleryName)
                            ->where('date', $date)->first();

            if(!$check){

                $data = array(
                    'id_institution' => $institutionId,
                    'id_academic_year' => $academicYear,
                    'title' => $galleryName,
                    'date' => $date,
                    'description' => $galleryDetail,
                    'cover_image' => $coverImage,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );

                $storeData = $galleryRepository->store($data);

                if($storeData){

                    $lastInsertedId = $storeData->id;

                    // Insert gallery attachment
                    if($galleryData->galleryImg){

                        foreach($galleryData->galleryImg as $galleryImage){

                            $path = 'Gallery';
                            $attachmentGallery = $uploadService->fileUpload($galleryImage, $path);

                            $data = array(
                                'id_gallery' => $lastInsertedId,
                                'file_url' => $attachmentGallery,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );

                            $galleryAttachmentRepository->store($data);
                        }
                    };

                    // Insert gallery audience
                    if($galleryData->audienceType){

                        foreach($galleryData->audienceType as $galleryAudience){

                            if($galleryAudience == 'STAFF'){

                                foreach($galleryData->staffCategory as $staffCategory){

                                    foreach($galleryData->staffSubcategory as $staffSubcategory){

                                        $data = $staffSubCategoryRepository->findSubCategory($staffCategory, $staffSubcategory);
                                        // dd($data);

                                        if($data){
                                            $audience = array(
                                                'id_gallery' => $lastInsertedId,
                                                'audience_type' => $galleryAudience,
                                                'id_staff_category' => $staffCategory,
                                                'id_staff_subcategory' => $staffSubcategory,
                                                'created_by' => Session::get('userId'),
                                                'created_at' => Carbon::now()
                                            );

                                            $storeAudience = $galleryAudienceRepository->store($audience);
                                        }
                                    }
                                }

                            }else{

                                foreach($galleryData->standard as $standard){

                                    $audience = array(
                                        'id_gallery' => $lastInsertedId,
                                        'audience_type' => $galleryAudience,
                                        'id_standard' => $standard,
                                        'created_by' => Session::get('userId'),
                                        'created_at' => Carbon::now()
                                    );

                                    $storeAudience = $galleryAudienceRepository->store($audience);
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

        // Update gallery
        public function update($galleryData, $id){

            $galleryRepository = new GalleryRepository();
            $galleryAttachmentRepository = new GalleryAttachmentRepository();
            $galleryAudienceRepository = new GalleryAudienceRepository();
            $staffSubCategoryRepository = new StaffSubCategoryRepository();
            $uploadService = new UploadService();

            $galleryName = $galleryData->galleryName;
            $date = Carbon::createFromFormat('d/m/Y', $galleryData->galleryDate)->format('Y-m-d');
            $galleryDetail = $galleryData->galleryDetails;

            // S3 File Upload Function Call
            if($galleryData->hasfile('coverImage')){
                $path = 'Gallery/Cover';
                $coverImage = $uploadService->fileUpload($galleryData->coverImage, $path);
            }else{
                $coverImage = $galleryData->oldCoverImage;
            }

            $galleryDetails = $galleryRepository->fetch($id);

            $galleryDetails->title = $galleryName;
            $galleryDetails->date = $date;
            $galleryDetails->description = $galleryDetail;
            $galleryDetails->cover_image = $coverImage;
            $galleryDetails->modified_by = Session::get('userId');
            $galleryDetails->updated_at = Carbon::now();

            $updateData = $galleryRepository->update($galleryDetails);

            if($updateData){

                // Update gallery attachment
                if($galleryData->galleryImg != ""){

                    // $deleteAttachment = $galleryAttachmentRepository->delete($id);

                    if($galleryData->hasfile('galleryImg')){
                        //$path = 'Gallery';
                        foreach($galleryData->galleryImg as $attachment){
                            $path = 'Gallery';
                            $galleryAttachment = $uploadService->fileUpload($attachment, $path);

                            $data = array(
                                'id_gallery' => $id,
                                'file_url' => $galleryAttachment,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );

                            $storeAttachment = $galleryAttachmentRepository->store($data);
                            //dd($storeAttachment);
                        }
                    }
                }

                // Update event applicable to
                if($galleryData->audience_type){

                    $deleteAudience = $galleryAudienceRepository->delete($id);

                    foreach($galleryData->audience_type as $audienceType){

                        if($audienceType == 'STAFF'){

                            foreach($galleryData->staffCategory as $staffCategory){

                                foreach($galleryData->staffSubcategory as $staffSubcategory){

                                    $data = $staffSubCategoryRepository->findSubCategory($staffCategory, $staffSubcategory);
                                    // dd($data);

                                    if($data){
                                        $audienceData = array(
                                            'id_gallery' => $id,
                                            'audience_type' => $audienceType,
                                            'id_staff_category' => $staffCategory,
                                            'id_staff_subcategory' => $staffSubcategory,
                                            'created_by' => Session::get('userId'),
                                            'created_at' => Carbon::now()
                                        );

                                        $storeAudience = $galleryAudienceRepository->store($audienceData);
                                    }
                                }
                            }

                        }else{

                            foreach($galleryData->standard as $standard){

                                $audienceData = array(
                                    'id_gallery' => $id,
                                    'audience_type' => $audienceType,
                                    'id_standard' => $standard,
                                    'created_by' => Session::get('userId'),
                                    'created_at' => Carbon::now()
                                );

                                $storeAudience = $galleryAudienceRepository->store($audienceData);
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

        // Delete gallery
        public function delete($id){

            $galleryRepository = new GalleryRepository();

            $gallery = $galleryRepository->delete($id);

            if($gallery){
                $signal = 'success';
                $msg = 'Gallery deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Download gallery attachment zip
        public function downloadGalleryFiles($id){

            $galleryAttachmentRepository = new GalleryAttachmentRepository();

            $zip = new ZipArchive;
            $fileName = 'myNewFile_'.time().'.zip';
            $zip->open($fileName, \ZipArchive::CREATE);

            $galleryAttachment = $galleryAttachmentRepository->fetch($id);

            foreach ($galleryAttachment as $file) {
                $files = explode('Gallery/', $file->file_url);
                $zip->addFromString($files[1], file_get_contents($file->file_url));
            }

            $zip->close();
            header('Content-disposition: attachment; filename='.time().'.zip');
            header('Content-type: application/zip');
            readfile($fileName);
        }

        // Deleted gallery records
        public function getDeletedRecords($allSessions){

            $galleryRepository = new GalleryRepository();
            $galleryAudienceRepository = new GalleryAudienceRepository();

            $galleryData = $galleryRepository->allDeleted($allSessions);
            $galleryDetail = array();

            foreach($galleryData as $key => $gallery){

                $galleryDetail[$key] = $gallery;
                $galleryData = '';

                $audience = $galleryAudienceRepository->galleryAudienceType($gallery->id);

                if($audience){

                    foreach($audience as $audienceType){
                        $galleryData .= $audienceType['audience_type'].', ';
                    }

                    $galleryData = substr($galleryData, 0, -2);
                }

                if($gallery->cover_image == ''){

                    $coverImage = "https://cdn.egenius.in/img/placeholder.jpg";

                }else {

                    $coverImage = $gallery->cover_image;
                }

                $galleryDetail[$key]['audienceType'] = $galleryData;
                $galleryDetail[$key]['coverImage'] = $coverImage;
            }
            //dd($galleryDetail);
            return $galleryDetail;
        }

        // Restore gallery records
        public function restore($id){

            $galleryRepository = new GalleryRepository();

            $gallery = $galleryRepository->restore($id);

            if($gallery){

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
