<?php     
namespace App\Services;
use App\Models\SeminarConductedBy;
use App\Services\SeminarConductedByService;
use App\Repositories\SeminarConductedByRepository;
use App\Repositories\StudentMappingRepository;

class SeminarConductedByService {

        public function getSeminarConductedByStudent($idSeminar) {
            $seminarConductedByRepository = new SeminarConductedByRepository();
            $studentMappingRepository = new StudentMappingRepository();
            $seminarConductedByDetails = array();
            $seminarConductedBy = $seminarConductedByRepository->fetch($idSeminar); 
            foreach($seminarConductedBy as  $key => $conductors) {
                if($conductors->type == "STUDENT") {
                    $seminarConductedByDetails[$key] = $studentMappingRepository->fetchStudent($conductors->conducted_by);
                }
            }
            return $seminarConductedByDetails;
        }

        public function fetchSeminarValuationDetails($data) {
         
            $seminarConductedByRepository = new SeminarConductedByRepository();
            $seminarConductedByDetails = $seminarConductedByRepository->fetchStudentSeminar($data); 
            return $seminarConductedByDetails;
        }

        public function updateValuationData($valuationData, $id) {
            $seminarConductedByRepository = new SeminarConductedByRepository(); $seminarConductedByDetails = $seminarConductedByRepository->fetchSeminar($id); 
            $seminarConductedByDetails->obtained_marks = $valuationData->obtained_mark;
            $seminarConductedByDetails->remarks = $valuationData->comment;
            $update = $seminarConductedByRepository->update($seminarConductedByDetails); 

            if($update){
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

        public function getAll() {
            $seminarConductedByRepository = new SeminarConductedByRepository();
            $data = $seminarConductedByRepository->all();
            return $data;
        }
    }
?>