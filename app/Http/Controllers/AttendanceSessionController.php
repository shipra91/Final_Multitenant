<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSession;
use Illuminate\Http\Request;
use App\Services\AttendanceSessionService;
use App\Http\Requests\AttendanceSessionRequest;
use DataTables;
use Helper;

class AttendanceSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $attendanceSessionService = new AttendanceSessionService();

        if ($request->ajax()){
            $attendanceSession = $attendanceSessionService->getAll();
            return Datatables::of($attendanceSession)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        if(Helper::checkAccess('attendance-session', 'delete')){
                            $btn .= '<a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('AttendanceSession/index')->with("page", "session_attendance");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AttendanceSession/attendanceSession')->with("page", "session_attendance");;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttendanceSessionRequest $request)
    {
        $attendanceSessionService = new AttendanceSessionService();

        $result = ["status" => 200];

        try{

            $result['data'] = $attendanceSessionService->add($request);

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
     * @param  \App\Models\AttendanceSession  $attendanceSession
     * @return \Illuminate\Http\Response
     */
    public function show(AttendanceSession $attendanceSession)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AttendanceSession  $attendanceSession
     * @return \Illuminate\Http\Response
     */
    public function edit(AttendanceSession $attendanceSession)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AttendanceSession  $attendanceSession
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AttendanceSession $attendanceSession)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AttendanceSession  $attendanceSession
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attendanceSessionService = new AttendanceSessionService();

        $result = ["status" => 200];

        try{

            $result['data'] = $attendanceSessionService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    // Deleted session records
    public function getDeletedRecords(Request $request){

        $attendanceSessionService = new AttendanceSessionService();
        //dd($attendanceSessionService->getDeletedRecords());

        if($request->ajax()){
            $deletedData = $attendanceSessionService->getDeletedRecords();
            return Datatables::of($deletedData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn ='';
                        if(Helper::checkAccess('attendance-session', 'create')){
                            $btn .= '<button type="button" data-id="'.$row['id'].'" rel="tooltip" title="Restore" class="btn btn-success btn-sm restore m0">Restore</button>';
                        }else{
                            $btn .= 'No Access';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('AttendanceSession/view_deleted_record')->with("page", "session_attendance");
    }

    // Restore session records
    public function restore($id)
    {
        $attendanceSessionService = new AttendanceSessionService();

        $result = ["status" => 200];

        try{

            $result['data'] = $attendanceSessionService->restore($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
