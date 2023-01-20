<?php

namespace App\Http\Controllers;

use App\Models\StaffAttendance;
use Illuminate\Http\Request;
use App\Services\StaffAttendanceService;
use DataTables;
use Helper;

class StaffAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $staffAttendanceService = new StaffAttendanceService;

        $input = \Arr::except($request->all(),array('_token', '_method'));

        // dd($staffAttendanceService->getAll($input));

        if($request->ajax()){
            $attendanceData = $staffAttendanceService->getAll($input);
            // dd($attendanceData);
            return Datatables::of($attendanceData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        if(Helper::checkAccess('staff-attendance', 'view')){
                            $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" rel="tooltip" title="View" class="text-warning"><i class="material-icons">visibility</i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('StaffAttendance/index')->with("page", "staff_attendance");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $staffAttendanceService = new StaffAttendanceService;
        $attendanceDetails = $staffAttendanceService->getAttendanceData();
        // dd($attendanceDetails);

        return view('StaffAttendance/staffAttendance', ["attendanceDetails" => $attendanceDetails])->with("page", "staff_attendance");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $staffAttendanceService = new StaffAttendanceService;

        $result = ["status" => 200];

        try{

            $result['data'] = $staffAttendanceService->add($request);

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
     * @param  \App\Models\StaffAttendance  $staffAttendance
     * @return \Illuminate\Http\Response
     */

    public function show(StaffAttendance $staffAttendance)
    {
        //
    }

    public function getAttendance(Request $request)
    {
        $staffAttendanceService = new StaffAttendanceService;

        // dd($request->get('idInstitute'));
        $idInstitute = $request->get('idInstitute');
        $idAcademic = $request->get('idAcademic');
        $heldOn = $request->get('attendanceDate');
        $staffCategory = $request->get('staffCategory');

        $attendanceDetails = $staffAttendanceService->getAttendanceData();
        $attendanceData = $staffAttendanceService->getAttendanceStaff($heldOn, $staffCategory, $idInstitute, $idAcademic);
        // dd($attendanceData);
        return view('StaffAttendance/staffAttendance', ["attendanceDetails" => $attendanceDetails, "attendanceData" => $attendanceData])->with("page", "staff_attendance");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StaffAttendance  $staffAttendance
     * @return \Illuminate\Http\Response
     */
    public function edit(StaffAttendance $staffAttendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StaffAttendance  $staffAttendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StaffAttendance $staffAttendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StaffAttendance  $staffAttendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(StaffAttendance $staffAttendance)
    {
        //
    }
}
