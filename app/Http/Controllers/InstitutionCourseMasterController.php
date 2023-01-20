<?php

namespace App\Http\Controllers;

use App\Models\InstitutionCourseMaster;
use Illuminate\Http\Request;
use App\Services\InstitutionCourseMasterService;

class InstitutionCourseMasterController extends Controller
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
     * @param  \App\Models\InstitutionCourseMaster  $institutionCourseMaster
     * @return \Illuminate\Http\Response
     */
    public function show(InstitutionCourseMaster $institutionCourseMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InstitutionCourseMaster  $institutionCourseMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(InstitutionCourseMaster $institutionCourseMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InstitutionCourseMaster  $institutionCourseMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InstitutionCourseMaster $institutionCourseMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InstitutionCourseMaster  $institutionCourseMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $institutionCourseMasterService = new InstitutionCourseMasterService();
        $result = ["status" => 200];

        try{

            $result['data'] = $institutionCourseMasterService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
