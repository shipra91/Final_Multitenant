<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\EventService;

class EventController extends Controller
{
    public function getEvent(Request $request){
        
        $eventService = new EventService();
        
        $result = ["status" => 200];
        
        try{

            $allSessions = array(
                'institutionId' => $request->institutionId,
                'academicYear' => $request->academicYear
            );

            $result['data'] = $eventService->getAll($allSessions);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);    
    }

    public function store(Request $request){

        $eventService = new EventService();

        $result = ["status" => 200];

        try{

            $allSessions = array(
                'institutionId' => $request->institutionId,
                'academicYear' => $request->academicYear
            );

            $result['data'] = $eventService->add($request, $allSessions);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
