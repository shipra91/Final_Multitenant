<?php 
    namespace App\Repositories;
    use App\Models\User;
    use App\Interfaces\UserRepositoryInterface;
    use League\Flysystem\Filesystem;
    use Storage;

    class UserRepository implements UserRepositoryInterface{

        public function all(){ 
            return User::orderBy('created_at', 'ASC')->get();           
        }

        public function store($data){
            return User::create($data);
        }        

        public function fetch($mobile){
            return User::where('username', $mobile)->first();
        }   

        public function update($data){
            return $data->save();
        } 

        public function delete($id){
            return User::find($id)->delete();
        }

        public function deleteAllUsers($idInstitution){
            return User::where('id_institution', $idInstitution)->delete();
        }

        public function restoreAllUsers($idInstitution){
            return User::withTrashed()->where('id_institution', $idInstitution)->restore();
        }

        public function checkMobileLoginData($mobile, $mPIN){
            return User::where('username', $mobile)->where('password', $mPIN)->first();
        }
    }
?>