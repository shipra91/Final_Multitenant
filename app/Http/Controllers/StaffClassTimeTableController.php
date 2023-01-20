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
        // dd($staffClassTimeTableService->getAllTeachingStaff());
        if($request->ajax()){
            $staff = $staffClassTimeTableService->getAllTeachingStaff();
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

    public function show($id)
    {
        $staffClassTimeTableService = new StaffClassTimeTableService();

        $timetableData = $staffClassTimeTableService->getStaffTimeTableData($id);
        // dd($data);
        return view('StaffClassTimeTable/viewStaffTimeTable', ['timetableData' => $timetableData])->with("page", "staffClassTimeTable");
    }
}
