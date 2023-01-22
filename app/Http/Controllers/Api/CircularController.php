<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CircularService;

class CircularController extends Controller
{
    public function getCircular(Request $request){
        
        $circularService = new CircularService();
        
        $result = ["status" => 200];

        try{
            
            $allSessions = array(
                'institutionId' => $request->institutionId,
                'academicYear' => $request->academicYear
            );

            $result['data'] = $circularService->getAll($allSessions);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);        
    }

    public function store(Request $request)
    {
        $circularService = new CircularService();

        $result = ["status" => 200];

        try{

            $result['data'] = $circularService->add($request);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
    
    public function getRecipientCircular(Request $request){
        $circularService = new CircularService();

        $result = ["status" => 200];

        try{

            $allSessions = array(
                'userId' => $request->userId,
                'institutionId' => $request->institutionId,
                'academicYear' => $request->academicYear
            );

            $result['data'] = $circularService->viewOwnCirculars($allSessions);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
