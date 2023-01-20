<?php

namespace App\Http\Controllers;
use App\Models\EventAttendance;
use App\Services\EventAttendanceService;
use Illuminate\Http\Request;

class EventAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $eventAttendanceService = new EventAttendanceService();
        $recepientData = $eventAttendanceService->getEventRecipients($id);
        // dd($recepientData);

        return view('Events/eventAttendance', ['recepientData' => $recepientData])->with("page", "event_attendance");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $eventAttendanceService = new EventAttendanceService();

        $result = ["status" => 200];

        try{

            $result['data'] = $eventAttendanceService->add($request);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventAttendance  $eventAttendance
     * @return \Illuminate\Http\Response
     */
    public function show(EventAttendance $eventAttendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EventAttendance  $eventAttendance
     * @return \Illuminate\Http\Response
     */
    public function edit(EventAttendance $eventAttendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EventAttendance  $eventAttendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventAttendance $eventAttendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventAttendance  $eventAttendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventAttendance $eventAttendance)
    {
        //
    }
}
