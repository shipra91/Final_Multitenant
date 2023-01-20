<?php 
    namespace App\Services;
    use App\Models\SubjectType;
    use App\Repositories\SubjectTypeRepository;

    class SubjectTypeService {

        public function getAll(){
            $subjectTypeRepository = new SubjectTypeRepository();
            $subjectTypes = $subjectTypeRepository->all();
            return $subjectTypes;
        }

        public function find($id){
            $subjectTypeRepository = new SubjectTypeRepository();
            $subjectType = $subjectTypeRepository->fetch($id);
            return $subjectType;
        }
    }

?>