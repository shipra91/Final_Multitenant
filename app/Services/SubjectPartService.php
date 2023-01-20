<?php
    namespace App\Services;
    use App\Models\SubjectPart;
    use App\Repositories\SubjectPartRepository;
    use Carbon\Carbon;
    use Session;
    use DB;

    class SubjectPartService {
        public function add($requestData){

            $subjectPartRepository = new SubjectPartRepository();

            $allSessions = session()->all();
            $idInstitution = $allSessions['institutionId'];
            $academicYear = $allSessions['academicYear'];

            $check = SubjectPart::where('part_title', $requestData->subject_part)
                        ->where('id_institute', $idInstitution)
                        ->where('id_academic', $academicYear)
                        ->first();
            if(!$check){

                $data = array(
                    'id_institute' => $idInstitution,
                    'id_academic' => $academicYear,
                    'part_title' => $requestData->subject_part,
                    'grade_mark' => $requestData->mark_grade,                    
                    'created_by' => Session::get('userId'),
                );

                $storeData = $subjectPartRepository->store($data);

                if($storeData) {
                    $signal = 'success';
                    $msg = 'Data saved successfully!';

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

        public function getAll(){
            $subjectPartRepository = new SubjectPartRepository();

            $data = $subjectPartRepository->all();

            return $data;
        }

        public function fetchData($id){
            $subjectPartRepository = new SubjectPartRepository();
            $data = $subjectPartRepository->fetch($id);
            return $data;
        }

        public function update($requestData, $id){
            $subjectPartRepository = new SubjectPartRepository();

            $data = $subjectPartRepository->fetch($id);
            $data->part_title = $requestData->subject_part;
            $data->grade_mark = $requestData->mark_grade;
            $data->modified_by = Session::get('userId');

            $result = $subjectPartRepository->update($data);

            if($result) {
                $signal = 'success';
                $msg = 'Data updated successfully!';

            }else{
                $signal = 'failure';
                $msg = 'Error saving data!';
            }
            
            $output = array(
                'signal' => $signal,
                'message' => $msg
            );

            return $output;
        }

        public function delete($id){
            $subjectPartRepository = new SubjectPartRepository();           

            $result = $subjectPartRepository->delete($id);

            if($result) {
                $signal = 'success';
                $msg = 'Data deleted successfully!';

            }else{
                $signal = 'failure';
                $msg = 'Error saving data!';
            }
            
            $output = array(
                'signal' => $signal,
                'message' => $msg
            );

            return $output;
        }
    }
?>