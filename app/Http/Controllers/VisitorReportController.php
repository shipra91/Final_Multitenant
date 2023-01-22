<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisitorManagement;
use App\Repositories\InstitutionRepository;
use App\Services\VisitorManagementService;
use App\Services\VisitorReportService;

class VisitorReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('VisitorManagement/visitorReport')->with('page', 'visitor_report');
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
     * @param  \App\Models\VisitorManagement  $templateCategory
     * @return \Illuminate\Http\Response
     */
    public function show(VisitorManagement $templateCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VisitorManagement  $templateCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(VisitorManagement $templateCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VisitorManagement  $templateCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VisitorManagement $templateCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VisitorManagement  $templateCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(VisitorManagement $templateCategory)
    {
        //
    }

    public function getReport(Request $request){

        //dd($request);
        $allSessions = session()->all();
        $institutionId = $allSessions['institutionId'];

        $visitorReportService = new VisitorReportService();
        $institutionRepository = new InstitutionRepository();

        $institute = $institutionRepository->fetch($institutionId);
        $getReportData = $visitorReportService->getReportData($request, $allSessions);
        // dd($getReportData);

        return view('VisitorManagement/visitorReportData', ['getReportData' => $getReportData, 'institute' => $institute])->with("page", "fee_report");
    }
}
