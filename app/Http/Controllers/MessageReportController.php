<?php

namespace App\Http\Controllers;

use App\Models\MessageReport;
use Illuminate\Http\Request;
use App\Services\ComposeMessageService;
use DataTables;

class MessageReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $composeMessageService = new ComposeMessageService();
        $allSessions = session()->all();

        if ($request->ajax()){
            $allMessage = $composeMessageService->getAllMessages($allSessions);
            return Datatables::of($allMessage)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $btn = '<a href="/message-report/'.$row->id.'" data-id="'.$row->id.'" class="text-success" rel="tooltip" title="Report" target="print_popup" onsubmit="window.open("about:blank","print_popup","width=1000,height=800");"><i class="material-icons">cloud_download</i></a>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('MessageCenter/messageReport')->with("page", "message_report");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MessageReport  $messageReport
     * @return \Illuminate\Http\Response
     */
    public function show($idMessageCenter)
    {
        $composeMessageService = new ComposeMessageService();
        $allSessions = session()->all();

        $messageReportDetails = $composeMessageService->getMessageReport($idMessageCenter, $allSessions);

        return view('MessageCenter/messageReportDetails',['messageReportDetails'=>$messageReportDetails])->with("page", "message_report");

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MessageReport  $messageReport
     * @return \Illuminate\Http\Response
     */
    public function edit(MessageReport $messageReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MessageReport  $messageReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MessageReport $messageReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MessageReport  $messageReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(MessageReport $messageReport)
    {
        //
    }
}
