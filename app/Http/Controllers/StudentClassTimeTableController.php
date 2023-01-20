<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Services\StudentClassTimeTableService;
use DataTables;
use Session;

class StudentClassTimeTableController extends Controller
{
    public function index($allSessions)
    {
        $studentClassTimeTableService = new StudentClassTimeTableService();
        
        $userId = $allSessions['userId'];
        $institutionId = $allSessions['institutionId'];
        $academicYear = $allSessions['academicYear'];

        $timetableData = $studentClassTimeTableService->getStudentTimeTableData($userId, $institutionId , $academicYear, $allSessions);
           

        return view('StudentClassTimeTable/viewStudentTimeTable', ['timetableData' => $timetableData])->with("page", "studentClassTimeTable");
    }
}
