<?php 
    namespace App\Repositories;
    use App\Models\Combination;
    use App\Interfaces\CombinationRepositoryInterface;

    class CombinationRepository implements CombinationRepositoryInterface{

        public function all(){
            return Combination::all();            
        }

        public function store($data){
            return Combination::create($data);
        }        

        public function fetch($id){
            return Combination::find($id);
        }        

        public function update($data, $id){
            return Combination::whereId($id)->update($data);
        }        

        public function delete($id){
            return Combination::find($id)->delete();
        }
    }
?>