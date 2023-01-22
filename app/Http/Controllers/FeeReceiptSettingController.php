<?php

namespace App\Http\Controllers;

use App\Models\FeeReceiptSetting;
use App\Services\FeeReceiptSettingService;
use App\Repositories\FeeCategoryRepository;
use Illuminate\Http\Request;
use DataTables;
use Helper;

class FeeReceiptSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $feeReceiptSettingService = new FeeReceiptSettingService();
        $feeCategoryRepository = new FeeCategoryRepository();
        $allSessions = session()->all();

        $feeCategories = $feeReceiptSettingService->getReceiptFeeCategories($allSessions);

        if($request->ajax()){
            $feeSettings = $feeReceiptSettingService->getAll($allSessions);
            return Datatables::of($feeSettings)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        if($row['delete_status'] == 'show'){
                            if(Helper::checkAccess('receipt-settings', 'delete')){
                                $btn .= '<a href="javascript:void(0);" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                            }
                        }
                        
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('FeeReceiptSetting/index', ['feeCategories' => $feeCategories])->with("page", "fee_receipt_setting");
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
        $feeReceiptSettingService = new FeeReceiptSettingService();

        $result = ["status" => 200];

        try{

            $result['data'] = $feeReceiptSettingService->add($request);

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
     * @param  \App\Models\FeeReceiptSetting  $feeReceiptSetting
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $feeReceiptSettingService = new FeeReceiptSettingService();

        $feeSettings = $feeReceiptSettingService->fetch($id);
        return view('FeeReceiptSetting/viewFeeReceiptSetting', ['feeSettings' => $feeSettings])->with("page", "fee_receipt_setting");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FeeReceiptSetting  $feeReceiptSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(FeeReceiptSetting $feeReceiptSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FeeReceiptSetting  $feeReceiptSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FeeReceiptSetting $feeReceiptSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FeeReceiptSetting  $feeReceiptSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $feeReceiptSettingService = new FeeReceiptSettingService();

        $result = ["status" => 200];

        try{

            $result['data'] = $feeReceiptSettingService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
