<?php 
    namespace App\Repositories;
    use App\Models\InstitutionPoc;
    use App\Interfaces\InstitutionPocRepositoryInterface;

    class InstitutionPocRepository implements InstitutionPocRepositoryInterface{

        public function all(){
            return InstitutionPoc::all();            
        }

        public function store($data){
            return InstitutionPoc::create($data);
        }         

        public function fetchPoc($id){
            return InstitutionPoc::find($id);
        }        

        public function fetch($idInstitute){
            return InstitutionPoc::where('id_institute', $idInstitute)->get();
        }        

        public function update($data){
            return $data->save();
        }        

        public function delete($id){
            return InstitutionPoc::find($id)->delete();
        }
    }
?>