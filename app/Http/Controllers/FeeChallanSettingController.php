<?php

namespace App\Http\Controllers;

use App\Models\FeeChallanSetting;
use App\Services\FeeChallanSettingService;
use App\Services\InstitutionBankDetailsService;
use App\Repositories\FeeCategoryRepository;
use Illuminate\Http\Request;
use DataTables;
use Helper;

class FeeChallanSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $feeChallanSettingService = new FeeChallanSettingService();
        $feeCategoryRepository = new FeeCategoryRepository(); 
        $institutionBankDetailsService = new InstitutionBankDetailsService();
        $allSessions = session()->all();

        $feeCategories = $feeChallanSettingService->getChallanFeeCategories($allSessions);
        $institutionBankDetails = $institutionBankDetailsService->getAll();

        if($request->ajax()){
            $feeSettings = $feeChallanSettingService->getAll($allSessions);
            return Datatables::of($feeSettings)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        if($row['delete_status'] == 'show'){
                            if(Helper::checkAccess('challan-setting', 'delete')){
                                $btn .= '<a href="javascript:void(0);" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                            }
                        }
                        if(Helper::checkAccess('challan-setting', 'view')){
                            $btn .= '<a href="javascript:void();" data-id="'.$row['id'].'" rel="tooltip" title="View" class="text-info challanSettingDetail"><i class="material-icons">visibility</i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('FeeChallanSetting/createFeeChallanSetting', ['feeCategories' => $feeCategories, 'institutionBankDetails' => $institutionBankDetails])->with("page", "challan_setting");
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
        $feeChallanSettingService = new FeeChallanSettingService();

        $result = ["status" => 200];

        try{

            $result['data'] = $feeChallanSettingService->add($request);

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
     * @param  \App\Models\FeeChallanSetting  $feeChallanSetting
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $feeChallanSettingService = new FeeChallanSettingService();

        // $eventData = $eventService->getEventData();
        // $selectedData = $eventService->getEventSelectedData($id);
        // dd($selectedData);
        //return view('Events/viewEvent', ['eventData' => $eventData, 'selectedData' => $selectedData]);
        return view('FeeChallanSetting/viewFeeChallanSetting');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FeeChallanSetting  $feeChallanSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(FeeChallanSetting $feeChallanSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FeeChallanSetting  $feeChallanSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FeeChallanSetting $feeChallanSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FeeChallanSetting  $feeChallanSetting
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $feeChallanSettingService = new FeeChallanSettingService();

        $result = ["status" => 200];

        try{

            $result['data'] = $feeChallanSettingService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
    
    public function getChallanSetting(Request $request){
        $feeChallanSettingService = new FeeChallanSettingService();

        $challanSettingId = $request->challanSettingId;
       
        return $feeChallanSettingService->find($challanSettingId);
    }
}
