<?php

namespace App\Http\Controllers;

use App\Models\ComposeMessage;
use Illuminate\Http\Request;
use App\Services\ComposeMessageService;

class ComposeMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $composeMessageService = new ComposeMessageService();
        $allSessions = session()->all();
        
        $details = $composeMessageService->getDetails($allSessions);

        return view('MessageCenter/composeMessage',['details'=>$details])->with("page", "compose_message");  
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
        $composeMessageService = new ComposeMessageService();
        $allSessions = session()->all();

        $result = ["status" => 200];

        try{
            
            $result['data'] = $composeMessageService->add($request, $allSessions);    

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
     * @param  \App\Models\ComposeMessage  $composeMessage
     * @return \Illuminate\Http\Response
     */
    public function show(ComposeMessage $composeMessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ComposeMessage  $composeMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(ComposeMessage $composeMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ComposeMessage  $composeMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ComposeMessage $composeMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ComposeMessage  $composeMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComposeMessage $composeMessage)
    {
        //
    }

    public function getPhoneNumbers(Request $request) {
        $composeMessageService = new ComposeMessageService();
        $allSessions = session()->all();

        $term = $request->term;
        return $composeMessageService->getPhoneNumbers($term, $allSessions);
    }

    public function updateSentMessage() { //only sent messages not delivered or failed messages
        $composeMessageService = new ComposeMessageService();
        $allSessions = session()->all();

        return $composeMessageService->updateSentMessage($allSessions);
    }
}
