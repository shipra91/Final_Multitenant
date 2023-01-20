<?php
    namespace App\Services;

    use App\Models\Document;
    use App\Models\DocumentDetail;
    use App\Repositories\DocumentHeaderRepository;
    use App\Repositories\DocumentRepository;
    use App\Repositories\DocumentDetailRepository;
    use Carbon\Carbon;
    use Session;

    class DocumentDetailService {

        // Delete document detail
        public function delete($id){

            $documentDetailRepository = new DocumentDetailRepository();
            $documentDetails = $documentDetailRepository->delete($id);

            if($documentDetails){
                $signal = 'success';
                $msg = 'Data deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }
