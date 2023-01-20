<?php 
    namespace App\Services;
    use App\Models\InstitutionModule;
    use App\Repositories\InstitutionModuleRepository;

    class InstitutionModuleService { 
        // Get All Institution Module
        public function getAll($institutionId){ 
            $institutionModuleRepository = new InstitutionModuleRepository();
            $instituteModule = $institutionModuleRepository->all($institutionId);
            return $instituteModule;
        }

        // Get All Institution ModuleIds
        public function getAllIds($institutionId){
            $institutionModuleRepository = new InstitutionModuleRepository();
            $arrayOutput = array();
            $instituteModule = $institutionModuleRepository->all($institutionId);
            
            foreach($instituteModule as $moduleId){
                array_push($arrayOutput, $moduleId['id']);
            }
            // dd($arrayOutput);
            return $arrayOutput;
        }

        // Get Perticular Institution Module
        public function find($id){
            $institutionModuleRepository = new InstitutionModuleRepository();
            $instituteModule = $institutionModuleRepository->fetch($id);
            return $instituteModule;
        }
    }
?>