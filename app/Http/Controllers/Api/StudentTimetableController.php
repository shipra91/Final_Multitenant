<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StudentClassTimeTableService;

class StudentTimetableController extends Controller
{
    public function getTimetable(Request $request){

        $studentClassTimeTableService = new StudentClassTimeTableService();
        
        $result = ["status" => 200];

        try{

            $userId = $request->userId;
            $institutionId = $request->institutionId;
            $academicYear = $request->academicYear;

            $allSessions = array(
                'institutionId' => $institutionId,
                'academicYear' => $academicYear
            );

            $result['data'] = $studentClassTimeTableService->getStudentTimeTableData($userId, $institutionId , $academicYear, $allSessions);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }  
        
        return response()->json($result, $result['status']);
    }
}
