<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;
use App\Services\ResultService;
use App\Http\Requests\StoreResultRequest;
use App\Repositories\StudentMappingRepository;
use App\Repositories\GradeRepository;
use DataTables;
use Session;
use PDF;
use Helper;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request);
        $resultService = new ResultService;
        $allSessions = session()->all();

        $input = \Arr::except($request->all(), array('_token', '_method'));

        if($request->ajax()) {

            $resultData = $resultService->getAllStudentData($input, $allSessions);

            return Datatables::of($resultData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        if(Helper::checkAccess('result', 'edit')){
                            $btn .= '<a href="javascript:void();" data-id="'.$row->id_student.'" data-standard="'.$row->id_standard.'" data-exam="'.$row->examId.'" rel="tooltip" title="View" class="text-warning resultDetail"><i class="material-icons">visibility</i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $institutionStandards = $resultService->getAllData($allSessions);
        $exam = $resultService->getExamByStandard($request['standardId']);

        return view('Exam/result', ['institutionStandards' => $institutionStandards, 'exam' => $exam])->with("page", "result");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $resultService = new ResultService;
        $allSessions = session()->all();

        $institutionStandards = $resultService->getAllData($allSessions);
        $students = $resultService->fetchStudent($request, $allSessions);
        // dd($students);
        $exam = $resultService->getExamByStandard($request->get('standard'), $allSessions);
        $subjects = $resultService->getSubjectByExam($request->get('standard'), $request->get('exam'), $allSessions);
        
        return view ('Exam/addResult', ['institutionStandards' => $institutionStandards, 'students' => $students, 'exam' => $exam, 'subjects' => $subjects])->with("page", "result");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $resultService = new ResultService;

        $result = ["status" => 200];

        try{

            $result['data'] = $resultService->add($request);

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
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function show(Result $result)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function edit(Result $result)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Result $result)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function destroy(Result $result)
    {
        //
    }

    // Get exam based on standard
    public function getExam(Request $request){

        $resultService = new ResultService;
        $allSessions = session()->all();

        $standardId = $request->standardId;
        $exam= $resultService->getExamByStandard($standardId, $allSessions);
        // dd($exam);
        return $exam;
    }

    // Get subjects based on exam
    public function getSubject(Request $request){

        $resultService = new ResultService;
        $allSessions = session()->all();

        $examId = $request->examId;
        $standardId = $request->standardId;
        $subjects = $resultService->getSubjectByExam($standardId, $examId, $allSessions);
        // dd($subjects);
        return $subjects;
    }

    // Get Result Details
    public function getResult(Request $request){

        $resultService = new ResultService;
        $allSessions = session()->all();

        $resultDetails = $resultService->getResultDetail($request, $allSessions);
        //dd($resultDetails);
        return $resultDetails;

    }

    public function getMarksCard($exam, $standardId){

        $resultService = new ResultService();        
        $sessionData = Session::all();

        $idInstitution = $sessionData['institutionId'];
        $idAcademics = $sessionData['academicYear'];

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($resultService->generateMarksCard($idInstitution, $idAcademics, $exam, $standardId, $allSessions))->setPaper('a4', 'landscape');
        return $pdf->stream();

    }

    public function getSubjectGrade(Request $request){

        $gradeRepository = new GradeRepository();
        $totalScore = $request->totalScore;
        $exam = $request->examId;
        $standardId = $request->standardId;

        $sessionData = Session::all();
        $idInstitution = $sessionData['institutionId'];
        $idAcademics = $sessionData['academicYear'];

        $getGrade = $gradeRepository->getGrade($idInstitution, $idAcademics, $exam, $standardId, $totalScore);

        return $getGrade;
    }
}
