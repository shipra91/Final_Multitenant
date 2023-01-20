<?php 
    namespace App\Repositories;
    use App\Models\Division;
    use App\Interfaces\DivisionRepositoryInterface;
    use League\Flysystem\Filesystem;
    use Storage;

    class DivisionRepository implements DivisionRepositoryInterface{

        public function all(){
            return Division::all();            
        }

        public function store($data){
            return Division::create($data);
        }        

        public function fetch($id){
            return Division::find($id);
        }        

        public function update($data){
            return $data->save();
        } 

        public function delete($id){
            return Division::find($id)->delete();
        }
    }
?>