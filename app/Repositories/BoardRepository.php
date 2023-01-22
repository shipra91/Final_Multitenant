<?php 
    namespace App\Repositories;
    use App\Models\Board;
    use App\Interfaces\BoardRepositoryInterface;

    class BoardRepository implements BoardRepositoryInterface{

        public function all(){
            return Board::all();            
        }

        public function store($data){
            return Board::create($data);
        }        

        public function fetch($id){
            return Board::find($id);
        }        

        public function update($data, $id){
            return Board::whereId($id)->update($data);
        }        

        public function delete($id){
            return Board::find($id)->delete();
        }

        public function getBoardId($board){
            return Board::where('name',$board)->first();
        }    

    }
?>