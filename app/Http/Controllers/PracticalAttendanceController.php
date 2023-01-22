<?php

namespace App\Http\Controllers;

use App\Models\PracticalAttendance;
use App\Services\PracticalAttendanceService;
use Illuminate\Http\Request;
use DataTables;

class PracticalAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $practicalAttendanceService = new PracticalAttendanceService;
        $allSessions = session()->all();

        $practicalSubjects = $practicalAttendanceService->getPracticalSubjects($allSessions);
        $periods = $practicalAttendanceService->getPeriods($allSessions);

        return view ('PracticalAttendance/PracticalAttendance', ['practicalSubjects' => $practicalSubjects, 'periods' => $periods])->with("page", "practicalAttendance");
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
        $practicalAttendanceService = new PracticalAttendanceService;

        $result = ["status" => 200];

        try{

            $result['data'] = $practicalAttendanceService->add($request);

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
     * @param  \App\Models\PracticalAttendance  $practicalAttendance
     * @return \Illuminate\Http\Response
     */
    public function show(PracticalAttendance $practicalAttendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PracticalAttendance  $practicalAttendance
     * @return \Illuminate\Http\Response
     */
    public function edit(PracticalAttendance $practicalAttendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PracticalAttendance  $practicalAttendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PracticalAttendance $practicalAttendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PracticalAttendance  $practicalAttendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(PracticalAttendance $practicalAttendance)
    {
        //
    }

    // Get batch number based on standard
    public function getbatch(Request $request){

        $practicalAttendanceService = new PracticalAttendanceService;
        $allSessions = session()->all();

        $batch = $practicalAttendanceService->getBatch($request->standardId, $allSessions);
        //dd($batch);
        return $batch;
    }

    // Get students details
    public function getStudentPracticalAttendance(Request $request){

        $practicalAttendanceService = new PracticalAttendanceService;
        $allSessions = session()->all();

        $practicalSubjects = $practicalAttendanceService->getPracticalSubjects($allSessions);
        $periods = $practicalAttendanceService->getPeriods($allSessions);

        $attendanceData = $practicalAttendanceService->getAttendanceStudent($request, $allSessions);
        //dd($attendanceData);

        return view ('PracticalAttendance/PracticalAttendance', ["attendanceData" => $attendanceData, 'practicalSubjects' => $practicalSubjects, 'periods' => $periods])->with("page", "practicalAttendance");
    }
}
