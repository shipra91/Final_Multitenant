<?php 
    namespace App\Services;
    use App\Models\Combination;
    use App\Models\CombinationSubject;
    use App\Services\SubjectService;
    use App\Services\CombinationService;
    use App\Services\CombinationSubjectService;  
    use App\Repositories\CombinationRepository;
    // use App\Interfaces\CombinationRepositoryInterface;
    use App\Interfaces\CombinationSubjectRepositoryInterface;
    use Session;

    use Carbon\Carbon;

    class CombinationService 
    {  
        public function getAll(){
            $subjectService = new SubjectService();
            $combinationSubjectService = new CombinationSubjectService();
            $combinationRepository = new CombinationRepository();
            $combinations = $combinationRepository->all();

            $combinationDetail = array();
            
            foreach($combinations as $combination)
            {
                $combinationSubjectDetails = '';

                $combinationSubject = $combinationSubjectService->getCombinationSubjects($combination['id']);
                $subjectDetails = array();

                foreach($combinationSubject as $data)
                {
                    $subjectId = $data['id_subject'];
                    $subject = $subjectService->find($subjectId);
                    array_push($subjectDetails, $subject['name']);
                }
                $combinationSubjectDetails = implode(', ', $subjectDetails);

                $combinationData = array(
                    'id' => $combination['id'],
                    'name' => $combination['name'],
                    'subjects' => $combinationSubjectDetails
                );

                array_push($combinationDetail, $combinationData);
            }

            return $combinationDetail;
        }

        public function find($id){
            $combinationRepository = new CombinationRepository();
            $combination = $combinationRepository->fetch($id);
            return $combination;
        }

        public function add($combinationData)
        {
            $combinationSubjectService = new CombinationSubjectService();
            $combinationRepository = new CombinationRepository();
            $check = Combination::where('name', $combinationData->combination)->first();
            if(!$check){
              
                $data = array(
                    'name' => $combinationData->combination, 
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                );
                $storeData = $combinationRepository->store($data); 
             
                if($storeData) {

                    $lastInsertedId = $storeData->id;
                       
                    $subjectResponse = $combinationSubjectService->add($combinationData, $lastInsertedId );
                 
                    if($subjectResponse)
                    {
                        $signal = 'success';
                        $msg = 'Data inserted successfully!';
                    }
                    else
                    {
                        $signal = 'failure';
                        $msg = 'Error inserting in subject!';
                    }

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

        public function update($combinationData, $id){

            $combinationRepository = new CombinationRepository();
            $check = Combination::where('name', $combinationData->combination)->where('id', '!=', $id)->first();
            if(!$check){

                $data = array(
                    'name' => $combinationData->combination, 
                    'modified_by' => Session::get('userId'),
                    'updated_at' => Carbon::now()
                );

                $storeData = $combinationRepository->update($data, $id); 
              
                if($storeData) {

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

        public function delete($id){
            $combinationRepository = new CombinationRepository();
            $combination = $combinationRepository->delete($id);

            if($combination){
                $signal = 'success';
                $msg = 'Combination deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }

?>