<?php 
    namespace App\Repositories;
    use App\Models\Standard;
    use App\Interfaces\StandardRepositoryInterface;

    class StandardRepository implements StandardRepositoryInterface{

        public function all(){
            return Standard::all();            
        }

        public function store($data){
            return Standard::create($data);
        }        

        public function fetch($id){
            return Standard::find($id);
        }        

        public function update($data){
            return $data->save();
        }        

        public function delete($id){
            return Standard::find($id)->delete();
        }
    }
?>