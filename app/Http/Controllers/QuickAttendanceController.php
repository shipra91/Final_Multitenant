<?php

namespace App\Http\Controllers;

use App\Models\QuickAttendance;
use Illuminate\Http\Request;
use App\Services\QuickAttendanceService;
use App\Services\InstitutionStandardService;
use Session;
use DataTables;
use Helper;

class QuickAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $quickAttendanceService = new QuickAttendanceService();
        $attendanceData = $quickAttendanceService->getAttendanceData();

        $institutionStandardService = new InstitutionStandardService();
        $standards = $institutionStandardService->fetchStaffStandard();

        if ($request->ajax()){
            $quickAttendance = $quickAttendanceService->getAll();
            return Datatables::of($quickAttendance)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $btn = '';
                        if(Helper::checkAccess('quick-attendance', 'delete')){
                            $btn .= '<a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger deleteQuickAttendance"><i class="material-icons">delete</i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('QuickAttendance/index', ["attendanceData" => $attendanceData, "standards" => $standards])->with("page", "quick_attendance");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $quickAttendanceService = new QuickAttendanceService();
        // $attendanceData = $quickAttendanceService->getAttendanceData();
        // return view('AttendanceSettings/attendanceSettings', ["attendanceData" => $attendanceData]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        $quickAttendanceService = new QuickAttendanceService();

        $result = ["status" => 200];

        try{

            $result['data'] = $quickAttendanceService->add($request);

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
     * @param  \App\Models\QuickAttendance  $quickAttendance
     * @return \Illuminate\Http\Response
     */

    public function show(Request $request)
    {
        $quickAttendanceService = new QuickAttendanceService();

        if ($request->ajax()){
            $absentData = $quickAttendanceService->getAbsentStudents();
            return Datatables::of($absentData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void();" data-id="'.$row['idAttendance'].'" rel="tooltip" title="Remove From Absent List" class="text-danger absentDetails"><i class="material-icons">delete</i></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('QuickAttendance/index')->with("page", "quick_attendance");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuickAttendance  $quickAttendance
     * @return \Illuminate\Http\Response
     */
    public function edit(QuickAttendance $quickAttendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuickAttendance  $quickAttendance
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $quickAttendanceService = new QuickAttendanceService();

        $result = ["status" => 200];

        try{

            $result['data'] = $quickAttendanceService->update($request, $id);

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
     * @param  \App\Models\QuickAttendance  $quickAttendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuickAttendance $quickAttendance)
    {
        //
    }

    // Get standard based on subject
    public function getSubjectStandards(Request $request){

        $quickAttendanceService = new QuickAttendanceService();
        $standards = $quickAttendanceService->getSubjectStandards($request);
        //dd($standards);
        return $standards;
    }
}
