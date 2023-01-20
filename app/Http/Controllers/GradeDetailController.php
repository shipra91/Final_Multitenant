<?php

namespace App\Http\Controllers;

use App\Models\GradeDetail;
use Illuminate\Http\Request;
use App\Services\GradeDetailService;
use DataTables;

class GradeDetailController extends Controller
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
     * @param  \App\Models\GradeDetail  $gradeDetail
     * @return \Illuminate\Http\Response
     */
    public function show(GradeDetail $gradeDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GradeDetail  $gradeDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(GradeDetail $gradeDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GradeDetail  $gradeDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GradeDetail $gradeDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GradeDetail  $gradeDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gradeDetailService = new GradeDetailService();

        $result = ["status" => 200];

        try{

            $result['data'] = $gradeDetailService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
