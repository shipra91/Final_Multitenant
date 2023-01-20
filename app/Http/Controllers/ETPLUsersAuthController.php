<?php
namespace App\Http\Controllers;

use Hash;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ETPLUsers;
use App\Models\Role;
use App\Services\ETPLUsersAuthService;

class ETPLUsersAuthController extends Controller
{
    
    public function index(){

        return view('/etpl/login');
    }  

    public function customLogin(Request $request){        

        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
    
        $credentials = $request->only('email', 'password');
        
        if(Auth::guard('webadmin')->attempt($credentials) === true){
            
            if(Auth::guard('webadmin')->user()->is_activated === 'Yes'){
                
                $roleDetail = Role::where('label', Auth::guard('webadmin')->user()->type)->first();
                
                $data = array(
                    'roleId' => $roleDetail->id, 
                    'role' => Auth::guard('webadmin')->user()->type,            
                    'username' => Auth::guard('webadmin')->user()->email,
                    'fullname' => Auth::guard('webadmin')->user()->fullname,   
                    'contact' => Auth::guard('webadmin')->user()->contact, 
                    'userId' => Auth::guard('webadmin')->user()->emp_id                        
                );
                
                Session::put($data);
                return redirect()->intended('etpl/dashboard')
                            ->withSuccess('Signed in');

            }else{
                return redirect("/etpl/login")
                            ->withSuccess('Email is not activated, please check you mail for activation.');
            }
            
        }
        
        return redirect("/etpl/login")->withSuccess('Login details are not valid');
    }
     
    public function registration(){        
        return view('/etpl/registration');
    }
       
 
    public function customRegistration(Request $request)
    {  
        $request->validate([
            'emp_id' => 'required',
            'fullname' => 'required',
            'mobile' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
            
        $data = $request->all();
        $check = $this->create($data);
        return $check;
        //return redirect("/etpl/login")->withSuccess('have signed-up successfully');
    }
 
 
    public function create(array $data){

        $etplUsersAuthService = new ETPLUsersAuthService();

        $result = ["status" => 200];
        try{

            $result['data'] = $etplUsersAuthService->add($data);    

        }catch(Exception $e){
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }  

    public function activateEmail(){
        return view('etpl/activate_email');
    }
    
    public function emailActivation(Request $request){

        $etplUsersAuthService = new ETPLUsersAuthService();

        $result = ["status" => 200];
        try{

            $result['data'] = $etplUsersAuthService->activate($request);    

        }catch(Exception $e){
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }
     
 
    public function dashboard()
    {
        if(Auth::guard('webadmin')->check()){
            
            if(Auth::guard('webadmin')->user()->type === 'developer'){
                return view('/etpl/dashboard');
            }else{
                return view('/etpl/dashboard1');
            }

        }
   
        return redirect("/etpl/login")->withSuccess('are not allowed to access');
    }
     
 
    public function signOut() {
        Session::flush();
        Auth::guard('webadmin')->logout();
   
        return Redirect('/etpl/login');
    }
}
