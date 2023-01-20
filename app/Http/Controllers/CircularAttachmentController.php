<?php

namespace App\Http\Controllers;

use App\Models\CircularAttachment;
use Illuminate\Http\Request;
use App\Services\CircularAttachmentService;

class CircularAttachmentController extends Controller
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
     * @param  \App\Models\CircularAttachment  $circularAttachment
     * @return \Illuminate\Http\Response
     */
    public function show(CircularAttachment $circularAttachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CircularAttachment  $circularAttachment
     * @return \Illuminate\Http\Response
     */
    public function edit(CircularAttachment $circularAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CircularAttachment  $circularAttachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CircularAttachment $circularAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function removeCircularAttachments(Request $request)
    {
        $circularAttachmentService = new CircularAttachmentService();

        $result = ["status" => 200];

        try{

            $result['data'] = $circularAttachmentService->delete($request->circularId);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
