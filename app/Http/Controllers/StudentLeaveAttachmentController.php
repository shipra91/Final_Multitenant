<?php

namespace App\Http\Controllers;

use App\Models\StudentLeaveAttachment;
use Illuminate\Http\Request;
use App\Services\LeaveApplicationAttachmentService;

class StudentLeaveAttachmentController extends Controller
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
     * @param  \App\Models\StudentLeaveAttachment  $studentLeaveAttachment
     * @return \Illuminate\Http\Response
     */
    public function show(StudentLeaveAttachment $studentLeaveAttachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentLeaveAttachment  $studentLeaveAttachment
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentLeaveAttachment $studentLeaveAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentLeaveAttachment  $studentLeaveAttachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentLeaveAttachment $studentLeaveAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentLeaveAttachment  $studentLeaveAttachment
     * @return \Illuminate\Http\Response
     */
    public function removeLeaveAttachments(Request $request)
    {
        $leaveApplicationAttachmentService = new LeaveApplicationAttachmentService();

        $result = ["status" => 200];

        try{

            $result['data'] = $leaveApplicationAttachmentService->delete($request->applicationId);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
