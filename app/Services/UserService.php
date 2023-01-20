<?php 
    namespace App\Services;
    use App\Models\User;
    use App\Repositories\UserRepository;
    use Session;
    use Carbon\Carbon;
    use Hash;

    class UserService {
        
        public function getAll()
        {
            $userRepository = new UserRepository();
            $userDetails = $userRepository->all();
            return $userDetails;
        }

        public function find($id){
            $userRepository = new UserRepository();
            $user = $userRepository->fetch($id);
            return $user;
        }
    }

?>