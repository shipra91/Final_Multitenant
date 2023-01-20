<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\InstitutionStandardService;
use App\Repositories\FeeMappingRepository;
use App\Repositories\InstitutionRepository;
use App\Services\FeeReportService;

class FeeReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $institutionStandardService = new InstitutionStandardService();
        $feeMappingRepository = new FeeMappingRepository();

        $standardData = $institutionStandardService->fetchStandard();
        $feeCategory = $feeMappingRepository->getFeeCategory();
        $reportType = array(
                        array("OUTSTANDING", "Outstanding Report"),
                        array("FEE_COLLECTION", "Fee Collection Report"),
                        array("FEE_CANCELLATION", "Fee Cancellation Report"),
                        array("FEE_CONCESSION", "Fee Concession Report")
                    );
        return view('FeeReports/index', ['standardData' => $standardData, 'reportType' => $reportType, 'feeCategory' => $feeCategory])->with("page", "fee_report");
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

    public function getReport(Request $request){

        $allSessions = session()->all();
        $institutionId = $allSessions['institutionId'];

        $feeReportService = new FeeReportService();
        $institutionRepository = new InstitutionRepository();

        $institute = $institutionRepository->fetch($institutionId);

        $getReportData = $feeReportService->getReportData($request);
        // dd($getReportData);
        if($request->reportType == 'OUTSTANDING'){
            $page = 'outStandingReport';
        }else if($request->reportType == 'FEE_CANCELLATION'){
            $page = 'cancellationReport';
        }else if($request->reportType == 'FEE_COLLECTION'){
            $page = 'collectionReport';
        }else if($request->reportType == 'FEE_CONCESSION'){
            $page = 'concessionReport';
        }
        return view('FeeReports/'.$page, ['getReportData' => $getReportData, 'institute' => $institute])->with("page", "fee_report");
    }
}
