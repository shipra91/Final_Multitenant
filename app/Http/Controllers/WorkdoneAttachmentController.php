<?php

namespace App\Http\Controllers;

use App\Models\WorkdoneAttachment;
use Illuminate\Http\Request;
use App\Services\WorkdoneAttachmentService;

class WorkdoneAttachmentController extends Controller
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
     * @param  \App\Models\WorkdoneAttachment  $workdoneAttachment
     * @return \Illuminate\Http\Response
     */
    public function show(WorkdoneAttachment $workdoneAttachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorkdoneAttachment  $workdoneAttachment
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkdoneAttachment $workdoneAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkdoneAttachment  $workdoneAttachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkdoneAttachment $workdoneAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkdoneAttachment  $workdoneAttachment
     * @return \Illuminate\Http\Response
     */
    public function removeWorkdoneAttachments(Request $request)
    {
        $workdoneAttachmentService = new WorkdoneAttachmentService();

        $result = ["status" => 200];

        try{

            $result['data'] = $workdoneAttachmentService->delete($request->workdoneId);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
