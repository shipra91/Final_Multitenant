<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\HolidayService;

class HolidayController extends Controller
{
    public function getHoliday(Request $request){
        
        $mobileLoginService = new MobileLoginService();

        $result = ["status" => 200];

        try{

            $allSessions = array(
                'institutionId' => $request->institutionId,
                'academicYear' => $request->academicYear
            );

            $result['data'] = $holidayService->getAll($allSessions);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }    
        
        return response()->json($result, $result['status']);
    }

    public function store(Request $request){

        $holidayService = new HolidayService();
        
        $result = ["status" => 200];

        try{

            $result['data'] = $holidayService->add($request);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
