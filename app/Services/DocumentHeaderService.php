<?php
    namespace App\Services;
    use App\Models\DocumentHeader;
    use App\Services\DocumentHeaderService;
    use App\Repositories\DocumentHeaderRepository;
    use Carbon\Carbon;
    use Session;

    class DocumentHeaderService {

        // Get all document header
        public function getAll(){

            $documentHeaderRepository = new DocumentHeaderRepository();

            $documentHeader = $documentHeaderRepository->all();
            return $documentHeader;
        }

        // Get particular document header
        public function find($id){

            $documentHeaderRepository = new DocumentHeaderRepository();
            $documentHeader = $documentHeaderRepository->fetch($id);

            return $documentHeader;
        }

        // Insert document header
        public function add($headerData){

            $documentHeaderRepository = new DocumentHeaderRepository();

            foreach($headerData['documentHeader'] as $key => $documentHeader){

                $check = DocumentHeader::where('name', $documentHeader)->first();

                if(!$check){

                    $data = array(
                        'name' => $documentHeader,
                        'created_by' => Session::get('userId'),
                        'modified_by' => ''
                    );

                    $storeData = $documentHeaderRepository->store($data);

                    if($storeData) {
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
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Update document header
        public function update($headerData, $id){

            $documentHeaderRepository = new DocumentHeaderRepository();

            $check = DocumentHeader::where('name', $headerData->documentHeader)
                            ->where('id', '!=', $id)
                            ->first();

            if(!$check){

                $DocumentHeaderDetails = $documentHeaderRepository->fetch($id);

                $DocumentHeaderDetails->name = $headerData->documentHeader;
                $DocumentHeaderDetails->modified_by = Session::get('userId');
                $DocumentHeaderDetails->updated_at = Carbon::now();

                $updateData = $documentHeaderRepository->update($DocumentHeaderDetails);

                if($updateData){
                    $signal = 'success';
                    $msg = 'Data updated successfully!';

                }else{
                    $signal = 'failure';
                    $msg = 'Error updating data!';
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

        // Delete document header
        public function delete($id){

            $documentHeaderRepository = new DocumentHeaderRepository();

            $documentHeader = $documentHeaderRepository->delete($id);

            if($documentHeader){
                $signal = 'success';
                $msg = 'Document Header deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
