<?php

namespace App\Http\Controllers;

use App\Models\CustomFeeAssignment;
use App\Services\CustomFeeAssignmentService;
use Illuminate\Http\Request;

class CustomFeeAssignmentController extends Controller
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
        $customFeeAssignmentService = new CustomFeeAssignmentService();

        $result = ["status" => 200];
        try{
            
            $result['data'] = $customFeeAssignmentService->add($request);    

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
     * @param  \App\Models\CustomFeeAssignment  $customFeeAssignment
     * @return \Illuminate\Http\Response
     */
    public function show(CustomFeeAssignment $customFeeAssignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomFeeAssignment  $customFeeAssignment
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomFeeAssignment $customFeeAssignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomFeeAssignment  $customFeeAssignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomFeeAssignment $customFeeAssignment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomFeeAssignment  $customFeeAssignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomFeeAssignment $customFeeAssignment)
    {
        //
    }
}
