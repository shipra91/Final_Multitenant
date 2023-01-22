<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StaffClassTimeTableService;

class StaffTimetableController extends Controller
{  
    public function getTimetable(Request $request){

        $staffClassTimeTableService = new StaffClassTimeTableService();
        
        $result = ["status" => 200];

        try{

            $userId = $request->userId;

            $allSessions = array(
                'institutionId' => $institutionId,
                'academicYear' => $academicYear
            );

            $result['data'] = $staffClassTimeTableService->getStaffTimeTableData($userId, $allSessions);;

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        } 
        
        return response()->json($result, $result['status']);
    }
}
