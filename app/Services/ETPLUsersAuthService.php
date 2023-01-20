<?php 
    namespace App\Services;
    use App\Models\ETPLUsers;
    use App\Repositories\ETPLUsersAuthRepository;
    use Session;
    use Hash;
    use Mail;
    use DB;
    use App\Mail\SendEmail;
    use App\Mail\SendActivationEmail;

    class ETPLUsersAuthService {

        public function getAll(){
            
        }
        
        public function add($data){

            $etplUsersAuthRepository = new ETPLUsersAuthRepository();

            $emailExplode = explode("@", $data['email']);
            if($emailExplode[1] == "erelego.com") {  

                $checkEmailExistence = ETPLUsers::where('email', $data['email'])
                                                ->first();

                if(!$checkEmailExistence){
                    $check = ETPLUsers::where('emp_id', $data['emp_id'])
                            ->orWhere('email', $data['email'])
                            ->orWhere('contact', $data['mobile'])
                            ->first();

                    if(!$check){
                        $data = array(
                            'emp_id' => $data['emp_id'],
                            'email' => $data['email'],
                            'contact' => $data['mobile'],
                            'fullname' => $data['fullname'],
                            'password' => Hash::make($data['password']),
                            'created_by' => Session::get('userId')
                        );
                        $storeData = $etplUsersAuthRepository->store($data);
                        if($storeData) {
                            $signal = 'success';
                            $msg = 'Please check your mail to activate the account!';
                            //send mail
                            $mailData = [
                                'title' => 'Account Activation Email From Multitenant Team',
                                'body' => 'http://multitenant.egenius.in/etpl/activate'
                            ];
                            Mail::to($data['email'])->send(new SendEmail($mailData));

                        }else{

                            $signal = 'failure';
                            $msg = 'Error registering your data!';
                        }
                    }else{
                        $signal = 'exist';
                        $msg = 'This account is already registered with us!';
                    }

                }else{
                    $signal = 'exist';
                    $msg = 'This email is already registered with us!';
                }
            }else{
                $signal = 'invalid_email';
                $msg = 'Please enter valid company email!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }

        public function activate($request){

            $etplUsersAuthRepository = new ETPLUsersAuthRepository();
            DB::enableQueryLog();

            $check = ETPLUsers::where('email', $request->email)
                    ->first();
            // dd(DB::getQueryLog());

            if($check){

                if(Hash::check($request->password, $check->password)){
                    $id = $check->id;

                    $userData = $etplUsersAuthRepository->fetch($id);
                    $userData->is_activated = 'Yes';

                    $storeData = $etplUsersAuthRepository->update($userData);
                    if($storeData) {

                        $signal = 'success';
                        $msg = 'Email activated successfully!';

                        //send mail
                        $mailData = [
                            'title' => 'Account Activation Email',
                            'body' => 'Account activation is successful!'
                        ];

                        Mail::to($request->email)->send(new SendActivationEmail($mailData));

                    }else{

                        $signal = 'failure';
                        $msg = 'Error inserting data!';

                    } 
                }else{
                    $signal = 'incorrect_password';
                    $msg = 'Password is incorrect';
                }   

            }else{
                $signal = 'invalid';
                $msg = 'This email doesn\'t exist with us!';
            }

            $output = array(
                'signal'=>$signal,
                'message'=>$msg
            );

            return $output;
        }
        
    }

?>