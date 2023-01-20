<?php 
    namespace App\Repositories;
    use App\Models\InstitutionType;
    use App\Interfaces\InstitutionTypeRepositoryInterface;

    class InstitutionTypeRepository implements InstitutionTypeRepositoryInterface{

        public function all(){
            return InstitutionType::all();            
        }

        public function store($data){
            return $institutionType = InstitutionType::create($data);
        }        

        public function fetch($id){
            return $institutionType = InstitutionType::find($id);
        }        

        public function update($data, $id){
            return InstitutionType::whereId($id)->update($data);
        }        

        public function delete($id){
            return $institutionType = InstitutionType::find($id)->delete();
        }
    }
?>