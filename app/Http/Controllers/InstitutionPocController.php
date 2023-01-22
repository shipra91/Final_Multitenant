<?php

namespace App\Http\Controllers;

use App\Models\InstitutionPoc;
use Illuminate\Http\Request;
use App\Services\InstitutionPocService;

class InstitutionPocController extends Controller
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
     * @param  \App\Models\InstitutionPoc  $institutionPoc
     * @return \Illuminate\Http\Response
     */
    public function show(InstitutionPoc $institutionPoc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InstitutionPoc  $institutionPoc
     * @return \Illuminate\Http\Response
     */
    public function edit(InstitutionPoc $institutionPoc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InstitutionPoc  $institutionPoc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InstitutionPoc $institutionPoc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InstitutionPoc  $institutionPoc
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $institutionPocService = new InstitutionPocService();

        $result = ["status" => 200];

        try{

            $result['data'] = $institutionPocService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
