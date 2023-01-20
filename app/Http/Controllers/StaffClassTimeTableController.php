<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use App\Services\StaffClassTimeTableService;
use DataTables;

class StaffClassTimeTableController extends Controller
{
    public function index(Request $request)
    {
        $staffClassTimeTableService = new StaffClassTimeTableService();
        $allSessions = session()->all();

        if ($request->ajax()){
            $staff = $staffClassTimeTableService->getAllTeachingStaff($allSessions);
            return Datatables::of($staff)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn ='<a href="/staff-time-table-detail/'.$row['id'].'" rel="tooltip" title="View" class="text-info"><i class="material-icons">visibility</i></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('StaffClassTimeTable/index')->with("page", "staffClassTimeTable");
    }

    public function show($id, $allSessions)
    {
        $staffClassTimeTableService = new StaffClassTimeTableService();

        $timetableData = $staffClassTimeTableService->getStaffTimeTableData($id, $allSessions);
        // dd($data);

        return view('StaffClassTimeTable/viewStaffTimeTable', ['timetableData' => $timetableData])->with("page", "staffClassTimeTable");
    }
}
