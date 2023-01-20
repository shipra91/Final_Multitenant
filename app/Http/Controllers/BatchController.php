<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;
use App\Services\BatchService;
use DataTables;
use Session;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $batchService = new BatchService;

        $institutionStandards = $batchService->getStandard();
        $studentData = $batchService->getStudentsData($request);
        $batchDetails = $batchService->getBatchStudent($request['standard']);
        //dd($studentData);

        return view ('PracticalAttendance/batch', ['institutionStandards' => $institutionStandards, 'studentData' => $studentData, 'batchDetails' => $batchDetails])->with("page", "batch_creation");
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
        $batchService = new BatchService;

        $result = ["status" => 200];

        try{

            $result['data'] = $batchService->add($request);

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
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function show(Batch $batch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function edit(Batch $batch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Batch $batch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Batch $batch)
    {
        //
    }

    // Get batch number based on standard
    public function getbatch(Request $request){

        $batchService = new BatchService;

        $standardId = $request->standardId;
        $batch= $batchService->getBatchNoByStandard($standardId);
        //dd($batch);
        return $batch;
    }
}
