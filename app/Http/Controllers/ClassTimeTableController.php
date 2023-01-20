<?php

namespace App\Http\Controllers;

use App\Models\ClassTimeTable;
use App\Services\ClassTimeTableService;
use App\Services\StaffService;
use App\Services\RoomMasterService;
use Illuminate\Http\Request;

class ClassTimeTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roomMasterService = new RoomMasterService();
        $classTimeTableService = new ClassTimeTableService();
        $allSessions = session()->all();

        $roomData = $roomMasterService->all();
        $standard = $classTimeTableService->getStandards($allSessions);
        // dd($timeTableData);
        return view('ClassTimeTable/index', ['standard'=>$standard, 'roomData' => $roomData])->with("page", "class_timetable");
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
        $classTimeTableService = new ClassTimeTableService();

        $result = ["status" => 200];

        try{

            $result['data'] = $classTimeTableService->add($request);

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
     * @param  \App\Models\ClassTimeTable  $classTimeTable
     * @return \Illuminate\Http\Response
     */
    public function show(ClassTimeTable $classTimeTable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClassTimeTable  $classTimeTable
     * @return \Illuminate\Http\Response
     */
    public function edit(ClassTimeTable $classTimeTable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClassTimeTable  $classTimeTable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClassTimeTable $classTimeTable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClassTimeTable  $classTimeTable
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClassTimeTable $classTimeTable)
    {
        //
    }

    public function getStandard(Request $request)
    {
        $roomMasterService = new RoomMasterService();
        $classTimeTableService = new ClassTimeTableService();
        $timeTableSettingData = array();
        $allSessions = session()->all();

        $standardId = $request->get('standard');

        $roomData = $roomMasterService->all();
        $standard = $classTimeTableService->getStandards($allSessions);
        $timeTableSettingData = $classTimeTableService->getTimeTableDayWise($standardId, $allSessions);
        
        return view('ClassTimeTable/index', ['standard'=>$standard, 'timeTableSettingData'=>$timeTableSettingData, 'roomData' => $roomData])->with("page", "class_timetable");
    }

    // Get staff based on standard and subject
    public function getAllStaff(Request $request)
    {
        $staffService = new StaffService();
        $allSessions = session()->all();

        $standard = $request->standardId;
        $subjectArray = array(
            'subject' => $request->subjectId
        );        

        $staffData = $staffService->getStaffByStandardAndSubject($standard, $subjectArray, $allSessions);
      
        return $staffData;
    }
}
