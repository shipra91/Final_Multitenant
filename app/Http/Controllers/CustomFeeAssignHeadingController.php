<?php

namespace App\Http\Controllers;

use App\Models\CustomFeeAssignHeading;
use App\Services\CustomFeeAssignHeadingService;
use Illuminate\Http\Request;

class CustomFeeAssignHeadingController extends Controller
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
        $customFeeAssignHeadingService = new CustomFeeAssignHeadingService();

        $result = ["status" => 200];
        try{
            
            $result['data'] = $customFeeAssignHeadingService->add($request);    

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
     * @param  \App\Models\CustomFeeAssignHeading  $customFeeAssignHeading
     * @return \Illuminate\Http\Response
     */
    public function show(CustomFeeAssignHeading $customFeeAssignHeading)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomFeeAssignHeading  $customFeeAssignHeading
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomFeeAssignHeading $customFeeAssignHeading)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomFeeAssignHeading  $customFeeAssignHeading
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomFeeAssignHeading $customFeeAssignHeading)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomFeeAssignHeading  $customFeeAssignHeading
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomFeeAssignHeading $customFeeAssignHeading)
    {
        //
    }
}
