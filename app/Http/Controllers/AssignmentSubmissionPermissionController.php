<?php

namespace App\Http\Controllers;

use App\Models\AssignmentSubmissionPermission;
use Illuminate\Http\Request;
use App\Services\AssignmentSubmissionPermissionService;

class AssignmentSubmissionPermissionController extends Controller
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
        $assignmentSubmissionPermissionService = new AssignmentSubmissionPermissionService();

        $result = ["status" => 200];

        try{
            
            $result['data'] = $assignmentSubmissionPermissionService->add($request);    

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
     * @param  \App\Models\AssignmentSubmissionPermission  $assignmentSubmissionPermission
     * @return \Illuminate\Http\Response
     */
    public function show(AssignmentSubmissionPermission $assignmentSubmissionPermission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AssignmentSubmissionPermission  $assignmentSubmissionPermission
     * @return \Illuminate\Http\Response
     */
    public function edit(AssignmentSubmissionPermission $assignmentSubmissionPermission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AssignmentSubmissionPermission  $assignmentSubmissionPermission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssignmentSubmissionPermission $assignmentSubmissionPermission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AssignmentSubmissionPermission  $assignmentSubmissionPermission
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssignmentSubmissionPermission $assignmentSubmissionPermission)
    {
        //
    }
}
