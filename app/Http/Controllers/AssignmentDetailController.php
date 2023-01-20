<?php

namespace App\Http\Controllers;

use App\Models\AssignmentDetail;
use Illuminate\Http\Request;
use App\Services\AssignmentAttachmentService;

class AssignmentDetailController extends Controller
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
     * @param  \App\Models\AssignmentDetail  $assignmentDetail
     * @return \Illuminate\Http\Response
     */
    public function show(AssignmentDetail $assignmentDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AssignmentDetail  $assignmentDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(AssignmentDetail $assignmentDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AssignmentDetail  $assignmentDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssignmentDetail $assignmentDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AssignmentDetail  $assignmentDetail
     * @return \Illuminate\Http\Response
     */
    public function removeAssignmentAttachments(Request $request)
    {
        $assignmentAttachmentService = new AssignmentAttachmentService();

        $result = ["status" => 200];

        try{

            $result['data'] = $assignmentAttachmentService->delete($request->assignmentId);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
