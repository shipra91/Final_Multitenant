<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoginOtp;
use App\Services\MobileLoginService;
use App\Repositories\AcademicYearMappingRepository;
use Helper;

class AppLoginController extends Controller
{

    public function getInstitutionfromUrl(Request $request){

        $mobileLoginService = new MobileLoginService();
        
        $result = ["status" => 200];

        try{

            $result['data'] = $mobileLoginService->getUrl($request);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);

    }

    public function getOtp(Request $request){
        $mobileLoginService = new MobileLoginService();
        
        $result = ["status" => 200];

        try{

            $result['data'] = $mobileLoginService->createMobileOTP($request);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
        
    }

    public function verifyOTP(Request $request){

        $mobileLoginService = new MobileLoginService();

        $result = ["status" => 200];

        try{

            $result['data'] = $mobileLoginService->loginWithOTP($request);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        return response()->json($result, $result['status']);
    }

    public function createmPIN(Request $request){
        $mobileLoginService = new MobileLoginService();

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

    public function login(Request $request){
        $mobileLoginService = new MobileLoginService();

        $result = ["status" => 200];

        try{

            $result['data'] = $mobileLoginService->loginWithmPIN($request);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        return response()->json($result, $result['status']);
    }

    public function logout(Request $request){
        $mobileLoginService = new MobileLoginService();
        
        $result = ["status" => 200];

        try{

            $result['data'] = $mobileLoginService->mobileLogout($request);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        return response()->json($result, $result['status']);
    }

    public function refreshLogin(Request $request){
        $mobileLoginService = new MobileLoginService();
        
        $result = ["status" => 200];

        try{

            $result['data'] = $mobileLoginService->refreshLogin($request);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        return response()->json($result, $result['status']);
    }
}
