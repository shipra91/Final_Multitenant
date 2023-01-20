<?php

namespace App\Http\Controllers;

use App\Models\AttendanceReport;
use Illuminate\Http\Request;
use App\Services\AttendanceReportService;
use App\Repositories\InstitutionRepository;

class AttendanceReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('AttendanceReport/index')->with("page", "attendance_report");
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
        $attendanceReportService = new AttendanceReportService();
        // $getReportData = $attendanceReportService->callAttendanceProcedure($request);
        $getReportData = $attendanceReportService->getReportData($request);
        
        return view('AttendanceReport/periodWiseReport')->with("page", "attendance_report");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AttendanceReport  $attendanceReport
     * @return \Illuminate\Http\Response
     */
    public function show(AttendanceReport $attendanceReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AttendanceReport  $attendanceReport
     * @return \Illuminate\Http\Response
     */
    public function edit(AttendanceReport $attendanceReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AttendanceReport  $attendanceReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AttendanceReport $attendanceReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AttendanceReport  $attendanceReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttendanceReport $attendanceReport)
    {
        //
    }

    public function getReport(Request $request)
    {

        $allSessions = session()->all();
        $institutionId = $allSessions['institutionId'];
        
        $attendanceReportService = new AttendanceReportService();
        // $getReportData = $attendanceReportService->callAttendanceProcedure($request);
        
        $institutionRepository = new InstitutionRepository();

        $institute = $institutionRepository->fetch($institutionId);
        $getReportData = $attendanceReportService->getReportData($request);
        // dd($getReportData);

        if($request->attendanceType == 'periodwise'){
            $page = 'periodWiseReport';
        }else if($request->attendanceType == 'sessionwise'){
            $page = 'sessionWiseReport';
        }else if($request->attendanceType == 'daywise'){
            $page = 'dayWiseReport';
        }
        return view('AttendanceReport/'.$page, ['getReportData' => $getReportData, 'institute' => $institute])->with("page", "attendance_report");
    }

    public function getAbsentReport(Request $request){

        $allSessions = session()->all();
        $institutionId = $allSessions['institutionId'];

        $attendanceReportService = new AttendanceReportService();  
        $institutionRepository = new InstitutionRepository();

        $getReportData = $attendanceReportService->getAbsentReport($request); 
        $institute = $institutionRepository->fetch($institutionId);
        
        if($request->dailyAattendanceType == 'periodwise'){
            $page = 'periodWiseAbsentReport';
        }else if($request->dailyAattendanceType == 'sessionwise'){
            $page = 'sessionWiseAbsentReport';
        }else if($request->dailyAattendanceType == 'daywise'){
            $page = 'dayWiseAbsentReport';
        }
        return view('AttendanceReport/'.$page, ['getReportData' => $getReportData, 'institute' => $institute])->with("page", "attendance_report");
    }
}
