<?php 
    namespace App\Repositories;
    use App\Models\ETPLUsers;
    use App\Interfaces\ETPLUsersAuthRepositoryInterface;
    use League\Flysystem\Filesystem;
    use Storage;

    class ETPLUsersAuthRepository implements ETPLUsersAuthRepositoryInterface{

        public function all(){
            return ETPLUsers::all();            
        }

        public function store($data){
            return ETPLUsers::create($data);
        }        

        public function fetch($id){
            return ETPLUsers::find($id);
        }        

        public function update($data){
            return $data->save();
        }        

        public function delete($id){
            return ETPLUsers::find($id)->delete();
        }

        public function allDeleted(){
            return ETPLUsers::onlyTrashed()->get();            
        }        

        public function restore($id){
            return ETPLUsers::withTrashed()->find($id)->restore();
        } 
        
        public function restoreAll(){
            return ETPLUsers::onlyTrashed()->restore();
        }
    }
?>