<?php

namespace App\Http\Controllers;

use App\Models\StudentLeaveReport;
use App\Repositories\InstitutionRepository;
use App\Services\StudentLeaveReportService;
use Illuminate\Http\Request;

class StudentLeaveReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('StudentLeaveManagement/StudentLeaveReport')->with('page', 'student_leave_report');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentLeaveReport  $studentLeaveReport
     * @return \Illuminate\Http\Response
     */
    public function show(StudentLeaveReport $studentLeaveReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentLeaveReport  $studentLeaveReport
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentLeaveReport $studentLeaveReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentLeaveReport  $studentLeaveReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentLeaveReport $studentLeaveReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentLeaveReport  $studentLeaveReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentLeaveReport $studentLeaveReport)
    {
        //
    }

    // Get student leave report
    public function getReport(Request $request){
        //dd($request);

        $institutionRepository = new InstitutionRepository();
        $studentLeaveReportService = new StudentLeaveReportService();

        $allSessions = session()->all();
        $institutionId = $allSessions['institutionId'];
        $institute = $institutionRepository->fetch($institutionId);
        $getReportData = $studentLeaveReportService->getReportData($request);
        // dd($getReportData);

        return view('StudentLeaveManagement/StudentLeaveReportData', ['institute' => $institute, 'getReportData' => $getReportData])->with("page", "student_leave_report");
    }
}
