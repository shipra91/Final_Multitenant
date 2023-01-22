<?php

namespace App\Http\Controllers;

use App\Models\SeminarAttachment;
use Illuminate\Http\Request;
use App\Services\SeminarAttachmentService;

class SeminarAttachmentController extends Controller
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
     * @param  \App\Models\SeminarAttachment  $seminarAttachment
     * @return \Illuminate\Http\Response
     */
    public function show(SeminarAttachment $seminarAttachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SeminarAttachment  $seminarAttachment
     * @return \Illuminate\Http\Response
     */
    public function edit(SeminarAttachment $seminarAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SeminarAttachment  $seminarAttachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SeminarAttachment $seminarAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SeminarAttachment  $seminarAttachment
     * @return \Illuminate\Http\Response
     */
    public function removeSeminarAttachments(Request $request)
    {
        $seminarAttachmentService = new SeminarAttachmentService();

        $result = ["status" => 200];

        try{

            $result['data'] = $seminarAttachmentService->delete($request->seminarId);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
