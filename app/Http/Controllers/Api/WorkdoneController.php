<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Workdone;
use App\Services\WorkdoneService;

class WorkdoneController extends Controller
{
    public function getWorkdone(Request $request){
        
        $workdoneService = new WorkdoneService();
        
        $result = ["status" => 200];

        try{

            $allSessions = array(
                'institutionId' => $request->institutionId,
                'academicYear' => $request->academicYear
            );

            $result['data'] = $workdoneService->getAll($allSessions);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function store(Request $request){

        $workdoneService = new WorkdoneService();

        $result = ["status" => 200];

        try{

            $result['data'] = $workdoneService->add($request);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
