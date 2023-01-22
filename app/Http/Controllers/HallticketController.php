<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\InstitutionStandardService;
use App\Services\HallticketService;
use App\Services\ExamMasterService;
use App\Services\ExamTimetableService;

class HallticketController extends Controller
{
    public function index(Request $request){
        $institutionStandardDetails = array();

        $examTimetableService = new ExamTimetableService();
        $allSessions = session()->all();

        $examDetails = $examTimetableService->getExamWithTimetable($allSessions);

        return view('Exam/hallticketGenerate', ['examDetails' => $examDetails])->with("page", "hall_ticket");
    }

    public function getHallTicket(Request $request){

        $hallticketService = new HallticketService();
        $allSessions = session()->all();

        $hallTicketDetails = $hallticketService->getHallticketDetails($request, $allSessions);

        return view('Exam/hallticketPrint', ['hallTicketDetails' => $hallTicketDetails])->with("page", "hall_ticket");

    }
}
