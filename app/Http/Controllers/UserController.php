<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
// use Illuminate\Support\Facades\Session;
// use Auth; 
use Carbon\Carbon;
use DB;

class UserController extends Controller
{
    public function index(){
        return view('login');
    }

    // public function auth(Request $request) 
    // {
    //     dd($request);
    //     $username = $request->username;
    //     $password = md5($request->password);

    //     $result = User::where(['username'=>$username, 'password'=>$password])->get();
    //     dd($result[0]->id);

    //     if(isset($result[0]->id)){

    //         $request=session()->put('ADMIN_LOGIN',true);
    //         $request=session()->put('USER_ID',$result[0]->id);
    //         // $request=session()->put('INSTITUTION_ID',$result[0]->id_institution);
    //         // $request=session()->put('ROLE_ID',$result[0]->id_role);
    //         // $request=session()->put('USERTYPE',$result[0]->type);
    //         return redirect('/dashboard');

    //     }else{

    //         $request->session()->flash('error','Please enter valid login credential');
    //         return redirect()->intended('/');
    //     }
    // }

    // public function userLogin(Request $request){
    //     request()->validate([
    //         'username' => 'required',
    //         'password' => 'required',
    //     ]);
     
    //     $credentials = $request->only('username', 'password');
    //     if (Auth::attempt($credentials)) {
    //         $user = Auth::user(); 
    //         // Authentication passed...
    //         return redirect()->intended('dashboard');
    //     }
    //     return Redirect::to("/")->withSuccess('Oppes! You have entered invalid credentials');
    // }

    public function dashboard()
    {
        //if(session()){
            return view('index');
        //}
  
        //return redirect("login")->withSuccess('You are not allowed to access');
    }
    
    // public function signOut() {
    //     Session::flush();
    //     Auth::logout();
  
    //     return Redirect('login');
    // }
}
