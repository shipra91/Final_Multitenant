<?php

namespace App\Http\Controllers;

use App\Models\FeeMapping;
use Illuminate\Http\Request;
use App\Services\FeeMappingService;
use App\Repositories\FeeCategoryRepository;
use App\Http\Requests\StoreFeeMappingRequest;

class FeeMappingController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $feeMappingService = new FeeMappingService();
        $feeCategoryRepository = new FeeCategoryRepository();

        $feeCategory = $feeCategoryRepository->all();
        $feeHeadings = $feeMappingService->allFeeHeading();
        // dd($feeCategory);

        return view('FeeMapping/FeeMapping', ['feeCategory' => $feeCategory, 'feeHeadings' => $feeHeadings])->with("page", "fee_mapping");
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
    public function store(StoreFeeMappingRequest $request)
    {
        $feeMappingService = new FeeMappingService();

        $result = ["status" => 200];

        try{

            $result['data'] = $feeMappingService->add($request);

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
     * @param  \App\Models\FeeMapping  $feeMapping
     * @return \Illuminate\Http\Response
     */
    public function show(FeeMapping $feeMapping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FeeMapping  $feeMapping
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $feeMapping = $feeMappingService->find($id);
        // $feeCategory = $feeMappingService->allFeeCategory();
        // return view('FeeMapping/FeeMapping', ["feeHeading" => $feeHeading, "feeCategory" => $feeCategory]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FeeMapping  $feeMapping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FeeMapping $feeMapping)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FeeMapping  $feeMapping
     * @return \Illuminate\Http\Response
     */
    public function destroy(FeeMapping $feeMapping)
    {
        //
    }
}
