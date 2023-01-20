<?php

namespace App\Http\Controllers;

use App\Models\StudentDetention;
use Illuminate\Http\Request;
use App\Services\StudentDetentionService;
use Session;
use DataTables;
use Helper;

class StudentDetentionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $studentDetentionService = new StudentDetentionService();
        $allSessions = session()->all();

        if ($request->ajax()){
            $detainedStudents = $studentDetentionService->getAll($allSessions);
            return Datatables::of($detainedStudents)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '' ;     
                        if(Helper::checkAccess('detention', 'delete')){
                            $btn .= '<a href="javascript:void();" type="button" data-id="'.$row['id_student'].'" rel="tooltip" title="Delete" class="text-danger deleteDetainedStudents"><i class="material-icons">delete</i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view ('StudentDetention/index')->with("page", "detention");
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

    public function store(Request $request){

        $studentDetentionService = new StudentDetentionService();

        $result = ["status" => 200];

        try{

            $result['data'] = $studentDetentionService->add($request);

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
     * @param  \App\Models\StudentDetention  $studentDetention
     * @return \Illuminate\Http\Response
     */

    public function show(StudentDetention $studentDetention)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentDetention  $studentDetention
     * @return \Illuminate\Http\Response
     */

    public function edit(StudentDetention $studentDetention)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentDetention  $studentDetention
     * @return \Illuminate\Http\Response
     */

    public function update($id)
    {
        $studentDetentionService = new StudentDetentionService();

        $result = ["status" => 200];

        try{

            $result['data'] = $studentDetentionService->update($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentDetention  $studentDetention
     * @return \Illuminate\Http\Response
     */

    public function destroy(StudentDetention $studentDetention)
    {
        //
    }

    // Get Students
    public function getStudents(Request $request){

        $studentDetentionService = new StudentDetentionService;
        $allSessions = session()->all();

        $term = $request->term;
        $students = $studentDetentionService->getStudentDetails($term, $allSessions);
        //dd($students);

        return $students;
    }

    // Get Staff Students
    public function getStaffsStudents(Request $request){

        $studentDetentionService = new StudentDetentionService;
        $allSessions = session()->all();

        $term = $request->term;
        $students = $studentDetentionService->getStaffStudentDetails($term, $allSessions);
        //dd($students);

        return $students;
    }

      // Get Staff Students
      public function getStaffsStudentsForMessageCenter(Request $request){

        $studentDetentionService = new StudentDetentionService;
        $allSessions = session()->all();

        $term = $request->term;
        $students = $studentDetentionService->getStaffStudentDetailsForMessageCenter($term, $allSessions);
        //dd($students);

        return $students;
    }

    public function fetchStudents(Request $request){

        $studentDetentionService = new StudentDetentionService;
        $allSessions = session()->all();

        $term = $request->term;
        $details = $request->details;

        $students = $studentDetentionService->fetchStudentDetails($term, $details, $allSessions);
        // dd($students);

        return $students;
    }
}
