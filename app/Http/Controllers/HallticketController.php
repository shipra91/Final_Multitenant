<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\InstitutionStandardService;
use App\Services\HallticketService;
use App\Services\ExamMasterService;
use App\Services\ExamTimetableService;

class HallticketController extends Controller
{
    public function index(Request $request)
    {
        $examTimetableService = new ExamTimetableService();

        $institutionStandardDetails = array();
        $examDetails = $examTimetableService->getExamWithTimetable();
        return view('Exam/hallticketGenerate', ['examDetails' => $examDetails])->with("page", "hall_ticket");
    }

    public function getHallTicket(Request $request)
    {
        $hallticketService = new HallticketService();

        $hallTicketDetails = $hallticketService->getHallticketDetails($request);
        return view('Exam/hallticketPrint', ['hallTicketDetails' => $hallTicketDetails])->with("page", "hall_ticket");
    }
}
