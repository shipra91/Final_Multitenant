<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AssignmentSubmissionService;

class AssignmentSubmissionController extends Controller
{
    public function store(Request $request)
    {
        $assignmentSubmissionService = new AssignmentSubmissionService();

        $result = ["status" => 200];

        try{

            $result['data'] = $assignmentSubmissionService->add($request);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
