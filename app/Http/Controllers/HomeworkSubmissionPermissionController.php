<?php

namespace App\Http\Controllers;

use App\Models\HomeworkSubmissionPermission;
use Illuminate\Http\Request;
use App\Services\HomeworkSubmissionPermissionService;

class HomeworkSubmissionPermissionController extends Controller
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
        $homeworkSubmissionPermissionService = new HomeworkSubmissionPermissionService();

        $result = ["status" => 200];

        try{

            $result['data'] = $homeworkSubmissionPermissionService->add($request);

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
     * @param  \App\Models\HomeworkSubmissionPermission  $homeworkSubmissionPermission
     * @return \Illuminate\Http\Response
     */
    public function show(HomeworkSubmissionPermission $homeworkSubmissionPermission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomeworkSubmissionPermission  $homeworkSubmissionPermission
     * @return \Illuminate\Http\Response
     */
    public function edit(HomeworkSubmissionPermission $homeworkSubmissionPermission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HomeworkSubmissionPermission  $homeworkSubmissionPermission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HomeworkSubmissionPermission $homeworkSubmissionPermission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HomeworkSubmissionPermission  $homeworkSubmissionPermission
     * @return \Illuminate\Http\Response
     */
    public function destroy(HomeworkSubmissionPermission $homeworkSubmissionPermission)
    {
        //
    }
}
