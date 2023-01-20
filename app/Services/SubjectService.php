<?php
    namespace App\Services;
    use App\Models\Subject;
    use App\Models\SubjectType;
    use App\Repositories\SubjectRepository;
    use App\Repositories\SubjectTypeRepository;
    use Carbon\Carbon;
    use Session;

    class SubjectService {

        // Get all subject
        public function getAll(){

            $subjectTypeRepository = new SubjectTypeRepository();
            $subjectRepository = new SubjectRepository();

            $subjects = $subjectRepository->all();

            $arraySubject = array();

            foreach($subjects as $data){
                
                $type = $subjectTypeRepository->fetch($data->id_type);
                $subjectCount = $subjectRepository->fetchSubjectNameCount($data->name);
                if(count($subjectCount) > 1){
                    $subjectName = $data->name.' ( '.$type->display_name.' )';
                }else{
                    $subjectName = $data->name;
                }

                $data = array(
                    'id' => $data->id,
                    'type' => $type->display_name,
                    'name' => $subjectName,
                    'created_by' => $data->created_by,
                    'modified_by' => $data->modified_by
                );

                array_push($arraySubject, $data);
            }

            return $arraySubject;
        }

        // Get particular subject
        public function find($id){

            $subjectRepository = new SubjectRepository();
            $subject = $subjectRepository->fetch($id);

            return $subject;
        }

        public function getSubjects(){

            $subjectTypeRepository = new SubjectTypeRepository();
            $subjectRepository = new SubjectRepository();
            $arraySubjectType = array();

            $subjectTypes = $subjectTypeRepository->all();

            foreach($subjectTypes as $type){
                $arraySubjectType[$type->label] = $subjectRepository->fetchSubjects($type->id);
            }
            // dd($arraySubjectType);
            return $arraySubjectType;
        }

        // Insert subject
        public function add($subjectData){

            $subjectRepository = new SubjectRepository();

            $check = Subject::where('name', $subjectData->subject_name)                            
                            ->where('id_type', $subjectData->subject_type)
                            ->first();

            if(!$check){

                $data = array(
                    'id_type' => $subjectData->subject_type,
                    'name' => $subjectData->subject_name,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );

                $storeData = $subjectRepository->store($data);

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

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        // Update subject
        public function update($subjectData, $id){

            $subjectRepository = new SubjectRepository();

            $check = Subject::where('name', $subjectData->subject_name)                          
                            ->where('id_type', $subjectData->subject_type)
                            ->where('id', '!=', $id)->first();

            if(!$check){

                $subjectDetails = $subjectRepository->fetch($id);

                $subjectDetails->id_type = $subjectData->subject_type;
                $subjectDetails->name = $subjectData->subject_name;
                $subjectDetails->modified_by = Session::get('userId');
                $subjectDetails->updated_at = Carbon::now();

                $updateData = $subjectRepository->update($subjectDetails);

                if($updateData) {
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

        // Delete standard
        public function delete($id){

            $subjectRepository = new SubjectRepository();
            $division = $subjectRepository->delete($id);

            if($division){
                $signal = 'success';
                $msg = 'Subject deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function fetchSubjectTypeDetails($idSubject){
            $subjectRepository = new SubjectRepository();

            return $subjectRepository->fetchSubjectTypeDetails($idSubject);
        }
    }

?>
