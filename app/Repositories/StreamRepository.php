<?php 
    namespace App\Repositories;
    use App\Models\Stream;
    use App\Interfaces\StreamRepositoryInterface;

    class StreamRepository implements StreamRepositoryInterface{

        public function all(){
            return Stream::all();            
        }

        public function store($data){
            return Stream::create($data);
        }        

        public function fetch($id){
            return Stream::find($id);
        }        

        public function update($data, $id){
            return Stream::whereId($id)->update($data);
        }        

        public function delete($id){
            return Stream::find($id)->delete();
        }
    }
?>