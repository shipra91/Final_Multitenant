<?php

namespace App\Http\Controllers;

use App\Models\LoginOtp;
use App\Services\MobileLoginService;
use Illuminate\Http\Request;

class LoginOtpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

        $result = ["status" => 200];

        try{

            $result['data'] = $mobileLoginService->createmPIN($request);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LoginOtp  $loginOtp
     * @return \Illuminate\Http\Response
     */
    public function show(LoginOtp $loginOtp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LoginOtp  $loginOtp
     * @return \Illuminate\Http\Response
     */
    public function edit(LoginOtp $loginOtp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LoginOtp  $loginOtp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoginOtp $loginOtp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LoginOtp  $loginOtp
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoginOtp $loginOtp)
    {
        //
    }

    public function getOTP(Request $request){
        
        $mobileLoginService = new MobileLoginService();
        $mobile = $request->mobile;
        $data = $mobileLoginService->createWebOTP($mobile);
        return $data;
    }

    public function OTPLogin(Request $request){
        
        $mobileLoginService = new MobileLoginService();
        $data = $mobileLoginService->loginWithOTP($request);
        return $data;
    }
}
