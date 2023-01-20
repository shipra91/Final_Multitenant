<?php 
    namespace App\Repositories;
    use App\Models\LoginDeviceToken;
    use App\Interfaces\LoginDeviceTokenRepositoryInterface;

    class LoginDeviceTokenRepository implements LoginDeviceTokenRepositoryInterface{

        public function all(){
            return LoginDeviceToken::all();            
        }

        public function store($data){
            return $institutionType = LoginDeviceToken::create($data);
        }        

        public function fetch($id){
            return LoginDeviceToken::find($id);
        }        

        public function update($data){
            return $data->save();
        }        

        public function delete($mobile, $deviceToken){
            return LoginDeviceToken::where('mobile', $mobile)->where('device_token', $deviceToken)->delete();
        }       

        public function checkifDeviceExist($mobile, $deviceToken){
            return LoginDeviceToken::where('mobile', $mobile)
                    ->where('device_token', $deviceToken)
                    ->first();
        }
    }
?>