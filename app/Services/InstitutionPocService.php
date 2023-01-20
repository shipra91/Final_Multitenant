<?php 
    namespace App\Services;
    use App\Repositories\InstitutionPocRepository;

    class InstitutionPocService {
       
        // Delete Institution Poc
        public function delete($id)
        { 
            $institutionPocRepository = new InstitutionPocRepository();
            $poc = $institutionPocRepository->delete($id);

            if($poc){
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
?>