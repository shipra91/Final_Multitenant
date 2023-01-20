<?php

namespace App\Http\Controllers;

use App\Models\ClassTimeTableSettings;
use App\Services\ClassTimeTableSettingsService;
use Illuminate\Http\Request;
use DataTables;
use Session;
use Helper;

class ClassTimeTableSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $classTimeTableSettingsService = new ClassTimeTableSettingsService();
        $allSessions = session()->all();

        //dd($classTimeTableSettingsService->getAllPeriodSettings());

        if ($request->ajax()) {
            $timeTableData = $classTimeTableSettingsService->getAllPeriodSettings($allSessions);
            return Datatables::of($timeTableData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';

                        if(Helper::checkAccess('class-timetable-settings', 'edit')){
                            $btn = '<a href="/class-timetable-settings/'.$row['id'].'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                        }
                        if(Helper::checkAccess('class-timetable-settings', 'delete')){
                            $btn .= '<a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('ClassTimeTableSettings/index')->with("page", "class_timetable_setting");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classTimeTableSettingsService = new ClassTimeTableSettingsService();
        $allSessions = session()->all();

        $timeTableData = $classTimeTableSettingsService->getTimeTableData($allSessions);
        //dd($timeTableData);
        $daysArray = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        return view('ClassTimeTableSettings/timetableSetting', ['timeTableData'=>$timeTableData, 'daysArray' => $daysArray])->with("page", "class_timetable_setting");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $classTimeTableSettingsService = new ClassTimeTableSettingsService();

        $result = ["status" => 200];

        try{

            $result['data'] = $classTimeTableSettingsService->add($request);

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
     * @param  \App\Models\ClassTimeTableSettings  $classTimeTableSettings
     * @return \Illuminate\Http\Response
     */
    public function show(ClassTimeTableSettings $classTimeTableSettings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClassTimeTableSettings  $classTimeTableSettings
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $classTimeTableSettingsService = new ClassTimeTableSettingsService();

        $selectedData = $classTimeTableSettingsService->getTimeTableSelectedData($id);
        //dd($selectedData);
        return view('ClassTimeTableSettings/editTimetableSetting', ['selectedData' => $selectedData])->with("page", "class_timetable_setting");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClassTimeTableSettings  $classTimeTableSettings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $classTimeTableSettingsService = new ClassTimeTableSettingsService();

        $result = ["status" => 200];

        try{

            $result['data'] = $classTimeTableSettingsService->update($request, $id);

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
     * @param  \App\Models\ClassTimeTableSettings  $classTimeTableSettings
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $classTimeTableSettingsService = new ClassTimeTableSettingsService();

        $result = ["status" => 200];

        try{

            $result['data'] = $classTimeTableSettingsService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getPeriodSettings(Request $request)
    {
        $classTimeTableSettingsService = new ClassTimeTableSettingsService();
        $allSessions = session()->all();

        $timeTableData = $classTimeTableSettingsService->getTimeTableData($allSessions);
        $timeTableSettings = $classTimeTableSettingsService->getPeriodSettings($request, $allSessions);
        $daysArray = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        //dd($daysArray);

        return view('ClassTimeTableSettings/timetableSetting', ["timeTableData" => $timeTableData, 'timeTableSettings' => $timeTableSettings, 'daysArray' => $daysArray])->with("page", "class_timetable_setting");
    }
}
