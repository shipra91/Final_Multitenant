<?php

namespace App\Http\Controllers;

use App\Models\FeeSetting;
use Illuminate\Http\Request;
use App\Services\FeeSettingService;

class FeeSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feeSettingService = new FeeSettingService();
        $feeSettingData = $feeSettingService->fetchData();
        return view('FeeSetting/feeSettingCreation',['feeSettingData'=> $feeSettingData])->with("page", "fee_setting");
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
        $feeSettingService = new FeeSettingService();

        $result = ["status" => 200];

        try{

            $result['data'] = $feeSettingService->add($request);

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
     * @param  \App\Models\FeeSetting  $feeSetting
     * @return \Illuminate\Http\Response
     */
    public function show(FeeSetting $feeSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FeeSetting  $feeSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(FeeSetting $feeSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FeeSetting  $feeSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FeeSetting $feeSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FeeSetting  $feeSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(FeeSetting $feeSetting)
    {
        //
    }
}
