<?php 
    namespace App\Repositories;
    use App\Models\University;
    use App\Interfaces\UniversityRepositoryInterface;

    class UniversityRepository implements UniversityRepositoryInterface{

        public function all(){
            return University::all();            
        }

        public function store($data){
            return $University = University::create($data);
        }        

        public function fetch($id){
            return $University = University::find($id);
        }        

        public function update($data, $id){
            return University::whereId($id)->update($data);
        }        

        public function delete($id){
            return $University = University::find($id)->delete();
        }
    }
?>