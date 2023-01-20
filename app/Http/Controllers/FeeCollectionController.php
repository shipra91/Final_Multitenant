<?php

namespace App\Http\Controllers;

use App\Models\FeeCollection;
use App\Services\FeeCollectionService;
use Illuminate\Http\Request;
use DataTables;

class FeeCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $feeCollectionService = new FeeCollectionService();
        $getStudentDetail = $feeCollectionService->studentFeeDetail($request);
        // dd($getStudentDetail);
        
        return view('FeeCollection/index', ['getStudentDetail' => $getStudentDetail])->with("page", "fee_collection");
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
        $result = ["status" => 200];
        $feeCollectionService = new FeeCollectionService();

        try{

            $result['data'] = $feeCollectionService->add($request);

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
     * @param  \App\Models\FeeCollection  $feeCollection
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    { 
        $feeCollectionService = new FeeCollectionService();
        $paymentDetails = $feeCollectionService->getStudentFeeDetails($request);
        return view('FeeCollection/feeCancellation',['paymentDetails' => $paymentDetails ])->with("page", "fee_cancellation");  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FeeCollection  $feeCollection
     * @return \Illuminate\Http\Response
     */
    public function edit(FeeCollection $feeCollection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FeeCollection  $feeCollection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $feeCollectionService = new FeeCollectionService();
        $result = ["status" => 200];

        try{
            
            $result['data'] = $feeCollectionService->update($request, $id);  

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FeeCollection  $feeCollection
     * @return \Illuminate\Http\Response
     */
    public function destroy(FeeCollection $feeCollection)
    {
        //
    }
}
