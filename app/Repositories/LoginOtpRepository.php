<?php 
    namespace App\Repositories;
    use App\Models\LoginOtp;
    use App\Interfaces\LoginOtpRepositoryInterface;

    class LoginOtpRepository implements LoginOtpRepositoryInterface{

        public function all(){
            return LoginOtp::all();            
        }

        public function existingUser($phone){
            $data = LoginOtp::where('mobile_number', $phone)->first();
        }

        public function store($data){
            return $loginOtp = LoginOtp::create($data);
        }        

        public function fetch($id){
            return $loginOtp = LoginOtp::find($id);
        }        

        public function update($data){
            return $data->save();
        }        

        public function delete($id){
            return $loginOtp = LoginOtp::find($id)->delete();
        }
    }
?>