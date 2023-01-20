<?php

namespace App\Http\Controllers;

use App\Models\FeeMaster;
use Illuminate\Http\Request;
use App\Services\FeeMasterService;
use DataTables;
use Helper;

class FeeMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $feeMasterService = new FeeMasterService();
        $allSessions = session()->all();

        if ($request->ajax()) {

            $feeMasterData = $feeMasterService->getFeeMasterData($allSessions);
            return Datatables::of($feeMasterData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        if(Helper::checkAccess('fee-master', 'delete')){
                            $btn .= '<a type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('FeeMaster/FeeMaster')->with("page", "fee_master");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $feeMasterService = new FeeMasterService();
        $allSessions = session()->all();

        $filterData = $feeMasterService->getAllData($allSessions);

        return view('FeeMaster/FeeMasterCreation', ['filterData' => $filterData])->with("page", "fee_master");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $feeMasterService = new FeeMasterService();
        $allSessions = session()->all();

        $result = ["status" => 200];

        try{

            $result['data'] = $feeMasterService->add($request, $allSessions);

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
     * @param  \App\Models\FeeMaster  $feeMaster
     * @return \Illuminate\Http\Response
     */
    public function show(FeeMaster $feeMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FeeMaster  $feeMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(FeeMaster $feeMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FeeMaster  $feeMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FeeMaster $feeMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FeeMaster  $feeMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $feeMasterService = new FeeMasterService();
        $result = ["status" => 200];

        try{
            
            $result['data'] = $feeMasterService->delete($id);

        }catch(Exception $e){
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }

    // Get Fee Heading Based On Fee Category
    public function getFeeHeading(Request $request){
        $feeMasterService = new FeeMasterService();
        $allSessions = session()->all();

        $data = $feeMasterService->allFeeData($request, $allSessions);
        // dd($data);
        return $data;
    }

    public function getFeeCustomAssign(Request $request){
        $feeMasterService = new FeeMasterService();
        $allSessions = session()->all();

        $data = $feeMasterService->allCustomFeeData($request, $allSessions);
        return $data;
    }
}
