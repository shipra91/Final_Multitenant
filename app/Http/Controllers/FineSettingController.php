<?php

namespace App\Http\Controllers;

use App\Models\FineSetting;
use Illuminate\Http\Request;
use App\Services\FineSettingService;
use DataTables;
use Helper;

class FineSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fineSettingService = new FineSettingService();
        $fineSettingDetails = array();
        $fineSettingDetails['fine_setting'] = '';
        $fineSettingDetails['label_fine_option'] = '';
        $fineSettingDetails['setting_types'] = '';
        $fineSettingDetails['fine_setting_details'] = $fineSettingService->getSetting();
        $fineOptionDetails = $fineSettingService->getOptionDetails();

        if ($request->ajax()) {
            $fineSetting = $fineSettingService->getSetting();
            return Datatables::of($fineSetting)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $btn = '';
                        if(Helper::checkAccess('fine-setting', 'edit')){
                            $btn .= '<a href="/fine-setting/'.$row->label_fine_options.'" type="button" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                        }
                        if(Helper::checkAccess('fine-setting', 'delete')){
                            $btn .= '<a href="javascript:void();" type="button" data-label="'.$row->label_fine_options.'" rel="tooltip" title="Delete" class="text-danger  delete"><i class="material-icons">delete</i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('FineSetting/fineSettingCreation', ['fineOptionDetails'=> $fineOptionDetails, 'fineSettingDetails'=> $fineSettingDetails])->with("page", "fine_setting");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $fineSettingService = new FineSettingService();
        $labelFineOption = $request->get('fine_options');
        $fineSettingDetails = $fineSettingService->getSettingDetails($labelFineOption);
        $fineOptionDetails = $fineSettingService->getOptionDetails();
        return view('FineSetting/fineSettingCreation', ['fineOptionDetails'=> $fineOptionDetails, 'fineSettingDetails'=> $fineSettingDetails])->with("page", "fine_setting");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fineSettingService = new FineSettingService();

        $result = ["status" => 200];

        try{

            $result['data'] = $fineSettingService->add($request);

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
     * @param  \App\Models\FineSetting  $fineSetting
     * @return \Illuminate\Http\Response
     */
    public function show(FineSetting $fineSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FineSetting  $fineSetting
     * @return \Illuminate\Http\Response
     */
    public function edit($label)
    {
        $fineSettingService = new FineSettingService();
        $fineSettingDetails = $fineSettingService->getSettingDetails($label);
        return view('FineSetting/editFineSetting', ["fineSettingDetails" => $fineSettingDetails])->with("page", "fine_setting");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FineSetting  $fineSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $label)
    {
        $fineSettingService = new FineSettingService();
        $result = ["status" => 200];

        try{

            $result['data'] = $fineSettingService->update($request, $label);

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
     * @param  \App\Models\FineSetting  $fineSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy($label)
    {
        $fineSettingService = new FineSettingService();
        $result = ["status" => 200];
        try{

            $result['data'] = $fineSettingService->delete($label);

        }catch(Exception $e){
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
