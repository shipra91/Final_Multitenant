<?php 
    namespace App\Repositories;
    use App\Models\LoginOtp;
    use App\Interfaces\MobileLoginRepositoryInterface;
    use App\Repositories\StudentRepository;
    use App\Repositories\StaffRepository;
    use League\Flysystem\Filesystem;
    use Storage;
    use DB;

    class MobileLoginRepository implements MobileLoginRepositoryInterface{

        public function getLoginStatus($mobile){
            
            $loginStatus = LoginOtp::where('mobile_number', $mobile)
                            ->first();

            return $loginStatus;
        }

        public function store($data){
            return LoginOtp::create($data);
        }

        public function fetch($id){
            return LoginOtp::find($id);
        }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return LoginOtp::find($id)->delete();
        }

        public function userExists($mobile){            
            $studentRepository = new StudentRepository();
            $staffRepository = new StaffRepository();

            $staffCheck = $staffRepository->userExist($mobile);
        }

        public function checkValidLogin($mobile, $otp){
            $data = LoginOtp::where('mobile_number', $mobile)->where('otp', $otp)->first();
            return $data;
        }
    }
?>