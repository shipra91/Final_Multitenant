<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSettings;
use Illuminate\Http\Request;
use App\Services\AttendanceSettingsService;
use App\Http\Requests\StoreAttendanceSettingsRequest;
use DataTables;
use Helper;
use Session;

class AttendanceSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $attendanceSettingsService = new AttendanceSettingsService();

        $allSessions = session()->all();
        $institutionId = $allSessions['institutionId'];
        $academicYear = $allSessions['academicYear'];

        if ($request->ajax()){
            $attendanceSettings = $attendanceSettingsService->getAll($institutionId, $academicYear);
            return Datatables::of($attendanceSettings)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        // <a href="/attendance-settings/'.$row['id'].'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>
                        if(Helper::checkAccess('attendance-settings', 'view')){
                            $btn .= '<a href="/attendance-settings-detail/'.$row['id'].'" rel="tooltip" title="View" class="text-info"><i class="material-icons">visibility</i></a>';
                        }
                        if(Helper::checkAccess('attendance-settings', 'delete')){
                            $btn .= '<a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('AttendanceSettings/index')->with("page", "attendance_setting");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $attendanceSettingsService = new AttendanceSettingsService();
        $allSessions = session()->all();
        
        $settingsDetails = $attendanceSettingsService->getAttendanceData($allSessions);

        return view('AttendanceSettings/attendanceSettings', ["settingsDetails" => $settingsDetails])->with("page", "attendance_setting");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttendanceSettingsRequest $request)
    {
        $attendanceSettingsService = new AttendanceSettingsService();

        $result = ["status" => 200];

        try{

            $result['data'] = $attendanceSettingsService->add($request);

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
     * @param  \App\Models\AttendanceSettings  $attendanceSettings
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $attendanceSettingsService = new AttendanceSettingsService();
        $settingsData = $attendanceSettingsService->find($id);

        return view('AttendanceSettings/attendanceSettingsDetail', ["settingsData" => $settingsData])->with("page", "attendance_setting");
        //dd($settingsData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AttendanceSettings  $attendanceSettings
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attendanceSettingsService = new AttendanceSettingsService();
        $selectedSettings = $attendanceSettingsService->find($id);

        return view('AttendanceSettings/etitAttendanceSettings', ["selectedSettings" => $selectedSettings])->with("page", "attendance_setting");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AttendanceSettings  $attendanceSettings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $attendanceSettingsService = new AttendanceSettingsService();

        $result = ["status" => 200];

        try{

            $result['data'] = $attendanceSettingsService->update($request, $id);

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
     * @param  \App\Models\AttendanceSettings  $attendanceSettings
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attendanceSettingsService = new AttendanceSettingsService();

        $result = ["status" => 200];

        try{

            $result['data'] = $attendanceSettingsService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    // Deleted attendance setting records
    public function getDeletedRecords(Request $request){

        $attendanceSettingsService = new AttendanceSettingsService();
        //dd($attendanceSettingsService->getDeletedRecords());
        $allSessions = session()->all();

        if ($request->ajax()){
            $deletedData = $attendanceSettingsService->getDeletedRecords($allSessions);
            return Datatables::of($deletedData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<button type="button" data-id="'.$row['id'].'" rel="tooltip" title="Restore" class="btn btn-success btn-sm restore m0">Restore</button>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('AttendanceSettings/view_deleted_record')->with("page", "attendance_setting");
    }

    // Restore attendance setting records
    public function restore($id)
    {
        $attendanceSettingsService = new AttendanceSettingsService();

        $result = ["status" => 200];

        try{

            $result['data'] = $attendanceSettingsService->restore($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
