<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoginOtp;
use App\Services\MobileLoginService;

class AppLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd('$request');
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    //    dd('ygh');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $mobileLoginService = new MobileLoginService();
        
        $mobileLoginData = $mobileLoginService->createOTP($request);
        return response()->json([
            "status"=> true,
            "data"=> $mobileLoginData
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getOtp(Request $request){
        $mobileLoginService = new MobileLoginService();
        
        $mobileLoginData = $mobileLoginService->createMobileOTP($request);
        return response()->json([
            "status"=> true,
            "data"=> $mobileLoginData
        ]);
    }

    public function verifyOTP(Request $request){
        $mobileLoginService = new MobileLoginService();
        
        $mobileLoginData = $mobileLoginService->loginWithOTP($request);
        return response()->json([
            "status"=> true,
            "data"=> $mobileLoginData
        ]);
    }

    public function createmPIN(Request $request){
        $mobileLoginService = new MobileLoginService();
        
        $mobileLoginData = $mobileLoginService->createmPIN($request);
        return response()->json([
            "status"=> true,
            "data"=> $mobileLoginData
        ]);
    }

    public function login(Request $request){
        $mobileLoginService = new MobileLoginService();
        
        $mobileLoginData = $mobileLoginService->loginWithmPIN($request);
        return response()->json([
            "status"=> true,
            "data"=> $mobileLoginData
        ]);
    }

    public function logout(Request $request){
        $mobileLoginService = new MobileLoginService();
        
        $mobileLoginData = $mobileLoginService->mobileLogout($request);
        return response()->json([
            "status"=> true,
            "data"=> $mobileLoginData
        ]);
    }

    public function refreshLogin(Request $request){
        $mobileLoginService = new MobileLoginService();
        
        $mobileLoginData = $mobileLoginService->refreshLogin($request);
        return response()->json([
            "status"=> true,
            "data"=> $mobileLoginData
        ]);
    }
}
