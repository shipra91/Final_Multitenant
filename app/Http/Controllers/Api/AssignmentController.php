<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Services\AssignmentSubmissionService;

class AssignmentController extends Controller
{
    public function getAssignment(Request $request){
        
        $assignmentSubmissionService = new AssignmentSubmissionService();
        
        $result = ["status" => 200];

        try{
            $allSessions = array(
                'institutionId' => $request->institutionId,
                'academicYear' => $request->academicYear
            );

            $result['data'] = $assignmentSubmissionService->getAll($request->idStudent, $allSessions);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function store(Request $request){

        $assignmentService = new AssignmentService();

        $result = ["status" => 200];

        try{

            $result['data'] = $assignmentService->add($request);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
