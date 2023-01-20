<?php

namespace App\Http\Controllers;

use App\Models\EventAttachment;
use Illuminate\Http\Request;
use App\Services\EventAttachmentService;

class EventAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\EventAttachment  $eventAttachment
     * @return \Illuminate\Http\Response
     */
    public function show(EventAttachment $eventAttachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EventAttachment  $eventAttachment
     * @return \Illuminate\Http\Response
     */
    public function edit(EventAttachment $eventAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EventAttachment  $eventAttachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventAttachment $eventAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventAttachment  $eventAttachment
     * @return \Illuminate\Http\Response
     */
    public function removeEventAttachments(Request $request)
    {
        $eventAttachmentService = new EventAttachmentService();

        $result = ["status" => 200];

        try{

            $result['data'] = $eventAttachmentService->delete($request->eventId);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
