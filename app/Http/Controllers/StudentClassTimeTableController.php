<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Services\StudentClassTimeTableService;
use DataTables;
use Session;

class StudentClassTimeTableController extends Controller
{
    public function index()
    {
        $studentClassTimeTableService = new StudentClassTimeTableService();

        $allSessions = session()->all();
        $userId = $allSessions['userId'];
        $institutionId = $allSessions['institutionId'];
        $academicYear = $allSessions['academicYear'];

        $timetableData = $studentClassTimeTableService->getStudentTimeTableData($userId, $institutionId , $academicYear );
        return view('StudentClassTimeTable/viewStudentTimeTable', ['timetableData' => $timetableData])->with("page", "studentClassTimeTable");
    }
}
