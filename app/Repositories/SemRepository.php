<?php 
    namespace App\Repositories;
    use App\Models\Sem;
    use App\Interfaces\SemRepositoryInterface;
    use League\Flysystem\Filesystem;
    use Storage;

    class SemRepository implements SemRepositoryInterface{

        public function all(){
            return Sem::all();            
        }

        public function store($data){
            return Sem::create($data);
        }        

        public function fetch($id){
            return Sem::find($id);
        }    

        public function fetchSems($id){
            return Sem::where('id_type', $id)->get();
        }  

        public function update($data, $id){
            return Sem::whereId($id)->update($data);
        } 

        public function delete($id){
            return Sem::find($id)->delete();
        }
    }
?>