<?php 
    namespace App\Repositories;
    use App\Models\Gender;
    use App\Interfaces\GenderRepositoryInterface;

    class GenderRepository implements GenderRepositoryInterface{

        public function all(){
            return Gender::all();            
        }

        public function store($data){
            return Gender::create($data);
        }        

        public function fetch($id){
            return Gender::find($id);
        }        

        public function update($data, $id){
            return Gender::whereId($id)->update($data);
        }        

        public function delete($id){
            return Gender::find($id)->delete();
        }
    }
?>