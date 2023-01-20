<?php

namespace App\Http\Controllers;

use App\Models\DocumentDetail;
use Illuminate\Http\Request;
use App\Services\DocumentDetailService;
use DataTables;

class DocumentDetailController extends Controller
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
     * @param  \App\Models\DocumentDetail  $documentDetail
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DocumentDetail  $documentDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(DocumentDetail $documentDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DocumentDetail  $documentDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DocumentDetail $documentDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DocumentDetail  $documentDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $documentDetailService = new DocumentDetailService();

        $result = ["status" => 200];

        try{

            $result['data'] = $documentDetailService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
