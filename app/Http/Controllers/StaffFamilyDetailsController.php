<?php

namespace App\Http\Controllers;

use App\Models\StaffFamilyDetails;
use Illuminate\Http\Request;
use App\Services\StaffFamilyService;

class StaffFamilyDetailsController extends Controller
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
     * @param  \App\Models\StaffFamilyDetails  $staffFamilyDetails
     * @return \Illuminate\Http\Response
     */
    public function show(StaffFamilyDetails $staffFamilyDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StaffFamilyDetails  $staffFamilyDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(StaffFamilyDetails $staffFamilyDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StaffFamilyDetails  $staffFamilyDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StaffFamilyDetails $staffFamilyDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StaffFamilyDetails  $staffFamilyDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $staffFamilyService = new StaffFamilyService();

        $result = ["status" => 200];

        try{

            $result['data'] = $staffFamilyService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
