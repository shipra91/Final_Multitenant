<?php

namespace App\Http\Controllers;

use App\Models\ExamTimetableSetting;
use Illuminate\Http\Request;
use App\Services\ExamMasterService;
use App\Services\StandardSubjectService;
use App\Services\ExamTimetableService;

class ExamTimetableSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $examMasterService =  new ExamMasterService();        
        $examStandardDetails['standard_details'] = array();       
        $examDetails = $examMasterService->all(); 

        return view('Exam/examTimetableCreation', ['examDetails' => $examDetails, 'examStandardDetails' => $examStandardDetails])->with("page", "exam_timetable");
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
        $examTimetableService =  new ExamTimetableService();

        $result = ["status" => 200];
        try{
            
            $result['data'] = $examTimetableService->add($request);    

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
     * @param  \App\Models\ExamTimetableSetting  $examTimetableSetting
     * @return \Illuminate\Http\Response
     */
    public function show(ExamTimetableSetting $examTimetableSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExamTimetableSetting  $examTimetableSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(ExamTimetableSetting $examTimetableSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExamTimetableSetting  $examTimetableSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExamTimetableSetting $examTimetableSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExamTimetableSetting  $examTimetableSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExamTimetableSetting $examTimetableSetting)
    {
        //
    }
    public function getDetails(Request $request)
    { 
        $standardSubjectService =  new StandardSubjectService();
        $examMasterService =  new ExamMasterService();
        $examTimetableService =  new ExamTimetableService();

        $examId = $request->get('exam');
        $standardIds = $request->get('standard');
  
        $examDetails = $examMasterService->all();
        $examStandardDetails = $examMasterService->find($examId);
        $examTimetableDetails = $examTimetableService->find($request);

        // dd($examTimetableDetails); 
        return view('Exam/examTimetableCreation', ['examDetails' => $examDetails, 'examStandardDetails' => $examStandardDetails, 'examTimetableDetails' => $examTimetableDetails])->with("page", "exam_timetable");
       
    }

    public function getExamSubjects(Request $request)
    {
        $examTimetableService =  new ExamTimetableService();
        $subjectDetails = $examTimetableService->fetchExamSubjects($request);
        // dd($subjectDetails);
        return $subjectDetails;
    }

    
}
