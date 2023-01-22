<?php

namespace App\Http\Controllers;

use App\Models\SeminarConductedBy;
use Illuminate\Http\Request;
use App\Services\SeminarConductedByService;
use DataTables;
use Helper;

class SeminarConductedByController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $SeminarConductedByService = new SeminarConductedByService();
        $allSessions = session()->all();

        if ($request->ajax()){
            $seminars = $SeminarConductedByService->getAll($request, $allSessions);
            return Datatables::of($seminars)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        if(Helper::checkAccess('seminar-conductors', 'view')){
                            // $btn .='<a href="javascript:void();" data-id="'.$row->id_seminar.'" rel="tooltip" title="View" class="text-info seminarDetail"><i class="material-icons">visibility</i></a>

                            $btn .='<a href="/seminar-detail/'.$row->id_seminar.'" rel="tooltip" title="View" class="text-info"><i class="material-icons">visibility</i></a>

                            <a href="/seminar-download/'.$row->id_seminar.'/student" rel="tooltip" title="Download Files" class="text-success" target="_blank"><i class="material-icons">file_download</i></a>

                            <a href="javascript:void();" data-id="'.$row->id_seminar.'" student-id="'.$row->conducted_by.'"  rel="tooltip" title="View Mark And Comment" class="text-warning valuationDetails"><i class="material-icons">check_circle</i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('SeminarConductors/index')->with("page", "seminar_conductors");
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
     * @param  \App\Models\SeminarConductedBy  $seminarConductedBy
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $seminarDetails = '';
        $seminarConductedByService = new SeminarConductedByService();
        $allSessions = session()->all();

        if ($request->ajax()){
            $seminarDetails = $seminarConductedByService->getSeminarConductedByStudent(request()->route()->parameters['id'], $allSessions);
            return Datatables::of($seminarDetails)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void();" data-id="'.$row->id_student.'" rel="tooltip" title="Add mark and comment" class="text-warning addMarkComment"><i class="material-icons">edit</i></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);

        }

        return view('Seminar/viewStudentSeminar')->with("page", "seminar_conductors");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SeminarConductedBy  $seminarConductedBy
     * @return \Illuminate\Http\Response
     */
    public function edit(SeminarConductedBy $seminarConductedBy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SeminarConductedBy  $seminarConductedBy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $seminarConductedByService = new SeminarConductedByService();
        $result = ["status" => 200];

        try{

            $result['data'] = $seminarConductedByService->updateValuationData($request, $id);

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
     * @param  \App\Models\SeminarConductedBy  $seminarConductedBy
     * @return \Illuminate\Http\Response
     */
    public function destroy(SeminarConductedBy $seminarConductedBy)
    {
        //
    }

    public function getSeminarValuationDetails(Request $request){
        $seminarConductedByService = new SeminarConductedByService();
        return $seminarConductedByService->fetchSeminarValuationDetails($request);
    }
}
