<?php

namespace App\Http\Controllers;

use App\Models\ExamSubjectConfiguration;
use App\Services\ExamTimetableService;
use App\Services\ExamSubjectConfigurationService;
use Illuminate\Http\Request;
use Session;

class ExamSubjectConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $examSubjectConfigurationService = new ExamSubjectConfigurationService();
        $examTimetableService = new ExamTimetableService();
        $allSessions = session()->all();

        $examData = $examTimetableService->getExamWithTimetable($allSessions);
        $gradeSets = $examSubjectConfigurationService->allGradeSet($allSessions);

        return view('ExamSubjectConfiguration/exam_subject_configuration', ['examData' => $examData, 'gradeSets' => $gradeSets])->with('page', 'exam_subject_configuration');
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
        $examSubjectConfigurationService = new ExamSubjectConfigurationService();
        $allSessions = session()->all();

        $result = ["status" => 200];

        try{

            $result['data'] = $examSubjectConfigurationService->add($request, $allSessions);

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
     * @param  \App\Models\ExamSubjectConfiguarion  $examSubjectConfiguarion
     * @return \Illuminate\Http\Response
     */
    public function show(ExamSubjectConfiguarion $examSubjectConfiguarion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExamSubjectConfiguarion  $examSubjectConfiguarion
     * @return \Illuminate\Http\Response
     */
    public function edit(ExamSubjectConfiguarion $examSubjectConfiguarion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExamSubjectConfiguarion  $examSubjectConfiguarion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExamSubjectConfiguarion $examSubjectConfiguarion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExamSubjectConfiguarion  $examSubjectConfiguarion
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExamSubjectConfiguarion $examSubjectConfiguarion)
    {
        //
    }
}
