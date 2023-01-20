<?php

namespace App\Http\Controllers;

use App\Models\FeeAssignDetail;
use Illuminate\Http\Request;
use App\Services\FeeAssignDetailService;
use App\Repositories\FeeMasterRepository;

class FeeAssignDetailController extends Controller
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
     * @param  \App\Models\FeeAssignDetail  $feeAssignDetail
     * @return \Illuminate\Http\Response
     */
    public function show(FeeAssignDetail $feeAssignDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FeeAssignDetail  $feeAssignDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(FeeAssignDetail $feeAssignDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FeeAssignDetail  $feeAssignDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FeeAssignDetail $feeAssignDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FeeAssignDetail  $feeAssignDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(FeeAssignDetail $feeAssignDetail)
    {
        //
    }

    public function getFeeConcession(Request $request){
        $feeAssignDetailService = new FeeAssignDetailService();
        $allSessions = session()->all();

        $idFeeCategory = $request->idFeeCategory;
        $idStudent = $request->idStudent;

        $response = $feeAssignDetailService->fetchFeeConcession($idFeeCategory, $idStudent, $allSessions);
        return $response;
    }

    public function getFeeAddition(Request $request){
        $feeAssignDetailService = new FeeAssignDetailService();
        $allSessions = session()->all();

        $idFeeCategory = $request->idFeeCategory;
        $idStudent = $request->idStudent;

        $response = $feeAssignDetailService->fetchFeeAddition($idFeeCategory, $idStudent, $allSessions);
        return $response;
    }

    public function getFeeTypeAmount(Request $request){
        
        $feeMasterRepository = new FeeMasterRepository();
        $allSessions = session()->all();

        $feeData = $feeMasterRepository->getFeeTypeAmount($request, $allSessions);

        return $feeData;
    }
}
