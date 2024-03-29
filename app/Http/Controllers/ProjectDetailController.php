<?php

namespace App\Http\Controllers;

use App\Models\ProjectDetail;
use Illuminate\Http\Request;
use App\Services\ProjectAttachmentService;

class ProjectDetailController extends Controller
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
     * @param  \App\Models\ProjectDetail  $projectDetail
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectDetail $projectDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProjectDetail  $projectDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectDetail $projectDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectDetail  $projectDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectDetail $projectDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectDetail  $projectDetail
     * @return \Illuminate\Http\Response
     */
    public function removeProjectAttachments(Request $request)
    {
        $projectAttachmentService = new ProjectAttachmentService();

        $result = ["status" => 200];

        try{

            $result['data'] = $projectAttachmentService->delete($request->projectId);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    
    }
}
