<?php 
    namespace App\Services;
    use App\Models\CombinationSubject;
    use App\Services\CombinationSubjectService;
    use App\Interfaces\CombinationSubjectRepositoryInterface;
    use Carbon\Carbon;
    use Session;

    class CombinationSubjectService 
    {
        private CombinationSubjectRepositoryInterface $combinationSubjectRepository;
        public function __construct(CombinationSubjectRepositoryInterface $combinationSubjectRepository)
        {
            $this->combinationSubjectRepository = $combinationSubjectRepository;
        }
        public function getAll()
        {
            $combinationSubject = $this->combinationSubjectRepository->all();
            return $combinationSubject;
        }

        public function getCombinationSubjects($idCombination)
        {
            $combinationSubject = $this->combinationSubjectRepository->fetchCombinationSubjects($idCombination);
            return $combinationSubject;
        }

        public function add($combinationSubjectData, $lastInsertedId)
        {
            if($combinationSubjectData->subject_name[0] !='')
            {
                foreach($combinationSubjectData->subject_name as $key => $combinationSubject) 
                {
                    $data = array( 
                    'id_combination' => $lastInsertedId,
                    'id_subject' => $combinationSubject,
                    'created_by' => Session::get('userId'),
                    'created_at' => Carbon::now()
                    );
              
                    $storeSubject = $this->combinationSubjectRepository->store($data);
                }
            }
            
            $signal = 'success';
            $msg = 'Data inserted successfully!';
            
            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );
            return $output;
        }

        // public function update($combinationSubjectData, $id)
        // {
            
        
        // }

        public function delete($id){
            
            $combinationSubject = $this->combinationSubjectRepository->delete($id);

            if($combinationSubject){
                $signal = 'success';
                $msg = 'CombinationSubject deleted successfully!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
    }

?>