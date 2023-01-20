<?php

namespace App\Http\Controllers;

use App\Models\HomeworkDetail;
use Illuminate\Http\Request;
use App\Services\HomeworkAttachmentService;

class HomeworkDetailController extends Controller
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
     * @param  \App\Models\HomeworkDetail  $homeworkDetail
     * @return \Illuminate\Http\Response
     */
    public function show(HomeworkDetail $homeworkDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomeworkDetail  $homeworkDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(HomeworkDetail $homeworkDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HomeworkDetail  $homeworkDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HomeworkDetail $homeworkDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HomeworkDetail  $homeworkDetail
     * @return \Illuminate\Http\Response
     */
    public function removeHomeworkAttachments(Request $request)
    {
        $homeworkAttachmentService = new HomeworkAttachmentService();

        $result = ["status" => 200];

        try{

            $result['data'] = $homeworkAttachmentService->delete($request->homeworkId);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
