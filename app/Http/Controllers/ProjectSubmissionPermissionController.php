<?php

namespace App\Http\Controllers;

use App\Models\ProjectSubmissionPermission;
use Illuminate\Http\Request;
use App\Services\ProjectSubmissionPermissionService;

class ProjectSubmissionPermissionController extends Controller
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
        $projectSubmissionPermissionService = new ProjectSubmissionPermissionService();

        $result = ["status" => 200];

        try{

            $result['data'] = $projectSubmissionPermissionService->add($request);

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
     * @param  \App\Models\ProjectSubmissionPermission  $projectSubmissionPermission
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectSubmissionPermission $projectSubmissionPermission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProjectSubmissionPermission  $projectSubmissionPermission
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectSubmissionPermission $projectSubmissionPermission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectSubmissionPermission  $projectSubmissionPermission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectSubmissionPermission $projectSubmissionPermission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectSubmissionPermission  $projectSubmissionPermission
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectSubmissionPermission $projectSubmissionPermission)
    {
        //
    }
}
