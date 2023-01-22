<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Services\AttendanceSettingsService;
use App\Services\PeriodService;
use App\Services\AttendanceSessionService;
use App\Services\InstitutionSubjectService;
use App\Services\AttendanceService;
use Illuminate\Http\Request;
use DataTables;
use Helper;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $attendanceService = new AttendanceService;

        $input = \Arr::except($request->all(),array('_token', '_method'));

        $institutionStandards = $attendanceService->getStandard();
        $allSessions = session()->all();

        if($request->ajax()){
            $attendanceData = $attendanceService->getAll($input, $allSessions);
            // dd($attendanceData);
            return Datatables::of($attendanceData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        // if(Helper::checkAccess('student-attendance', 'view')){
                        //     $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" rel="tooltip" title="View" class="text-info"><i class="material-icons">visibility</i></a>';
                        // }
                        return $btn;
                    })
                    ->addColumn('status', function($res){

                        $statusData = '';

                        foreach($res['attendanceStatus'] as $status){

                            if($status === 'PRESENT'){
                                $statusData .= '<span class="badge badge-success m-3">'.$status.'</span>';
                            }else if($status === 'ABSENT'){
                                $statusData .= '<span class="badge badge-warning m-3">'.$status.'</span>';
                            }else{
                                $statusData .= '<span class="badge badge-danger m-3">'.$status.'</span>';
                            }
                        }

                        return $statusData;
                    })
                    ->rawColumns(['action', 'status'])
                    ->make(true);
        }

        return view('Attendance/index', ['institutionStandards' => $institutionStandards])->with("page", "student_attendance");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $attendanceSessionService = new AttendanceSessionService();
        $periodService = new PeriodService();
        $allSessions = session()->all();

        $allSessionData = $attendanceSessionService->getAll($allSessions);
        $allPeriods = $periodService->periodTypeWise();
        // dd($allSessions);

        return view('Attendance/attendance', ['allSessions' => $allSessionData, 'allPeriods' => $allPeriods])->with("page", "student_attendance");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attendanceService = new AttendanceService();
        $allSessions = session()->all();

        $result = ["status" => 200];

        try{

            $result['data'] = $attendanceService->add($request, $allSessions);

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
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }

    // Get standard on attendance type
    public function getStandard(Request $request){

        $attendanceSettingsService = new AttendanceSettingsService();
        $institutionSubjectService = new InstitutionSubjectService();
        $allSessions = session()->all();

        $standardData = $attendanceSettingsService->getAttendanceTypeData($request->attendanceType);
        $subjectData = $institutionSubjectService->getPeriodWiseSubjectData($request->attendanceType, $allSessions);
        //dd($standardData);
        // dd($subjectData);

        $data = array(
            'standardData' => $standardData,
            'subjectData' => $subjectData
        );

        return $data;
    }

    // Get students details
    public function getStudentAttendance(Request $request){

        $attendanceService = new AttendanceService();
        $attendanceSessionService = new AttendanceSessionService();
        $periodService = new PeriodService();
        $allSessions = session()->all();

        $attendanceData = $attendanceService->getAttendanceStudent($request, $allSessions);
        $allSessionData = $attendanceSessionService->getAll($allSessions);
        $allPeriods = $periodService->periodTypeWise();
        // dd($attendanceData);

        return view('Attendance/attendance', ["attendanceData" => $attendanceData, 'allSessions' => $allSessionData, 'allPeriods' => $allPeriods])->with("page", "student_attendance");
    }
}
