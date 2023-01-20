<?php
    namespace App\Services;
    use App\Models\Document;
    use App\Models\DocumentDetail;
    use App\Services\DocumentService;
    use App\Repositories\DocumentHeaderRepository;
    use App\Repositories\DocumentRepository;
    use App\Repositories\DocumentDetailRepository;
    use App\Repositories\StudentRepository;
    use App\Repositories\StudentMappingRepository;
    use App\Services\InstitutionStandardService;
    use Carbon\Carbon;
    use Session;

    class DocumentService {

        // Get all document header
        public function allDocumentHeader(){
            $documentHeaderRepository = new DocumentHeaderRepository();
            return $documentHeaderRepository->all();
        }

        // Get particular document detail
        public function getPartcularDocumentDetail($id){

            $documentDetailRepository = new DocumentDetailRepository();

            $documentDetails = $documentDetailRepository->fetch($id);
            return $documentDetails;
        }

        // Get all document
        public function getAll($allSessions){

            $documentRepository = new DocumentRepository();
            $studentRepository = new StudentRepository();

            $documents = $documentRepository->all($allSessions);

            $documentDetails = array();

            foreach($documents as $key => $document){

                $student = $studentRepository->fetch($document->id_student);

                $documentArray = array(
                    'id' => $document->id,
                    'student'=>$student->name,
                    'docketNumber'=>$document->docket_number,
                );

                $documentDetails[$key]= $documentArray;
            }

            return $documentDetails;
        }

        // Get particular document
        public function getDocumentSelectedData($idDocument, $allSessions){
            // dd($idDocument);
            $documentRepository = new DocumentRepository();
            $documentDetailRepository = new DocumentDetailRepository();
            $documentHeaderRepository = new DocumentHeaderRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $institutionStandardService = new InstitutionStandardService();

            $documentData = array();
            $documentDetailData = array();

            $document = $documentRepository->fetch($idDocument);
            $studentDetails = $studentMappingRepository->fetchStudent($document->id_student, $allSessions);
            //dd($studentDetails);
            $standard = $institutionStandardService->fetchStandardByUsingId($studentDetails->id_standard);
            //dd($standard);

            $documentDetails = $documentDetailRepository->all($idDocument);

            foreach($documentDetails as $key => $doc){
                $docDetail[$key] = $doc;
                $headerData = $documentHeaderRepository->fetch($doc->id_document_header);
                $docDetail[$key]['headerName'] = $headerData->name;
            }

            $documentData['studentName'] = $studentDetails->name;
            $documentData['studentStandard'] = $standard;
            $documentData['UID'] = $studentDetails->egenius_uid;
            $documentData['idDocument'] = $idDocument;
            $documentData['documentDetails'] = $docDetail;
            // dd($documentData);
            return $documentData;
        }

        // Insert document
        public function add($documentData){

            $institutionId = $documentData->id_institute;
            $academicYear = $documentData->id_academic;

            $documentRepository = new DocumentRepository();
            $documentDetailRepository = new DocumentDetailRepository();

            $randomid = mt_rand(100000,999999);
            //dd($randomid);
            $studentId = $documentData->studentId;
            $docketNumber = $randomid;

            $check = Document::where('id_student', $studentId)->where('id_institute', $institutionId)->where('id_academic', $academicYear)->first();

            if(!$check){

                $data = array(
                    'id_student' => $studentId,
                    'docket_number' => $docketNumber,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );

                $storeData = $documentRepository->store($data);

                if($storeData){

                    $lastInsertedId = $storeData->id;

                    if($documentData->documentHeader){

                        foreach($documentData->documentHeader as $key => $documentHeader){

                            $uniqueId = $documentData->uniqueId[$key];
                            $docCount = $documentData->docCount[$key];

                            $data = array(
                                'id_document' => $lastInsertedId,
                                'id_document_header' => $documentHeader,
                                'unique_id' => $uniqueId,
                                'doc_count' => $docCount,
                                'created_by' => Session::get('userId'),
                                'created_at' => Carbon::now()
                            );

                            $storeDocumentDetail = $documentDetailRepository->store($data);
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

        // Update document
        public function update($documentData, $id){

            $documentRepository = new DocumentRepository();
            $documentDetailRepository = new DocumentDetailRepository();
            $exist=0;
            $inserted = 0;

            foreach($documentData->documentHeader as $key => $documentHeader){

                //dd($documentHeader);
                $documentDetailId = $documentData->documentDetailId[$key];
                //dd($documentDetailId);
                $uniqueId = $documentData->uniqueId[$key];
                $docCount = $documentData->docCount[$key];

                if($documentDetailId!=''){

                    $documentDetail = $documentDetailRepository->fetch($documentDetailId);

                    $documentDetail->id_document_header = $documentHeader;
                    $documentDetail->unique_id = $uniqueId;
                    $documentDetail->doc_count = $docCount;
                    $documentDetail->modified_by = Session::get('userId');
                    $documentDetail->updated_at = Carbon::now();

                    $response = $documentDetailRepository->update($documentDetail);
                    $inserted++;

                }else{

                    $check = DocumentDetail::where('id_document', $id)
                                            ->where('id_document_header', $documentHeader)
                                            ->first();

                    if(!$check){

                        $data = array(
                            'id_document' => $id,
                            'id_document_header' => $documentHeader,
                            'unique_id' => $uniqueId,
                            'doc_count' => $docCount,
                            'modified_by' => Session::get('userId'),
                            'created_at' => Carbon::now(),
                        );
                        // dd($data);
                        $response = $documentDetailRepository->store($data);
                        $inserted++;

                    }else{
                        $exist++;
                    }
                }

                if($response){

                    if($exist > 0){
                        $signal = 'success';
                        $msg = 'Updated : '.$inserted.' And Existing : '.$exist;

                    }else{
                        $signal = 'success';
                        $msg = 'Data updated successfully!';
                    }

                }else{
                    $signal = 'failure';
                    $msg = 'Error inserting data!';
                }
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Update release document
        public function documentRelease($documentData, $id){

            $documentDetailRepository = new DocumentDetailRepository();

            $documentDetail = $documentDetailRepository->fetch($id);

            $documentDetail->released_reason = $documentData->release_reason;
            $documentDetail->released_date = Carbon::createFromFormat('d/m/Y H:i:s', $documentData->release_date)->format('Y-m-d  H:i:s');
            $documentDetail->released_by = Session::get('userId');

            $storeData = $documentDetailRepository->update($documentDetail);

            if($storeData){
                $signal = 'success';
                $msg = 'Released document successfully!';

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

        public function studentDocuments($request){

        }
    }
?>
