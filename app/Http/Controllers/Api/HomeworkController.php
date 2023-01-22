<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Homework;
use App\Services\HomeworkSubmissionService;

class HomeworkController extends Controller
{
    public function getHomework(Request $request){
        
        $HomeworkSubmissionService = new HomeworkSubmissionService();
        
        $result = ["status" => 200];

        try{

            $allSessions = array(
                'institutionId' => $request->institutionId,
                'academicYear' => $request->academicYear
            );

            $result['data'] = $HomeworkSubmissionService->getAll($request->idStudent, $allSessions);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function store(StoreHomeworkRequest $request){
        
        $homeworkService = new HomeworkService();

        $result = ["status" => 200];

        try{

            $result['data'] = $homeworkService->add($request);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
