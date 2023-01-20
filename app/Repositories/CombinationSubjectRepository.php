<?php 
    namespace App\Repositories;
    use App\Models\CombinationSubject;
    use App\Interfaces\CombinationSubjectRepositoryInterface;

    class CombinationSubjectRepository implements CombinationSubjectRepositoryInterface{

        public function all(){
            return CombinationSubject::all();            
        }

        public function store($data){
            return CombinationSubject::create($data);
        }        

        public function fetch($id){
            return CombinationSubject::find($id);
        }        

        public function update($data, $id){
            return CombinationSubject::whereId($id)->update($data);
        }        

        public function delete($id){
            return CombinationSubject::find($id)->delete();
        }

        public function fetchCombinationSubjects($idCombination){
            return CombinationSubject::where('id_combination', $idCombination)->get();
        }  
    }
?>