<?php

namespace App\Http\Controllers;

use App\Models\CreateFeeChallan;
use Illuminate\Http\Request;
use App\Services\CreateFeeChallanService;
use DataTables;

class CreateFeeChallanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $idAcademic, $idStudent)
    {
        $createFeeChallanService = new CreateFeeChallanService();
        $allSessions = session()->all();
      
        if ($request->ajax()) {
            $challanDetails = $createFeeChallanService->getChallan($idAcademic, $idStudent, $allSessions);
                return Datatables::of($challanDetails)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        $btn .= '<a href="/fee-challan-download/'.$row['id'].'" rel="tooltip" title="Generate Challan" class="text-info" target="_blank"><i class="material-icons">save_alt</i></a>';
                        if($row['status'] == 'NO')
                        {
                            $btn .= '<label class="text-danger">REJECTED  </label><p><b> Reason : '.$row['rejection_reason'].'</b></p>';
                        }
                        else if($row['status'] == 'YES')
                        {
                            $btn .= '<label class="text-success">APPROVED </label><p><b>Txn Id : '.$row['bank_transaction_id'].'</b></p>';
                        }
                        else{
                            $btn .= '
                            <a href="javascript:void();" data-id="'.$row['id'].'" data-amount="'.$row['amount_received'].'"  rel="tooltip" title="Approve Challan" class="text-success challanApproveDetails"><i class="material-icons">verified</i></a>
                            <a href="javascript:void();" data-id="'.$row['id'].'"  rel="tooltip" title="Reject Challan" class="text-danger challanRejectDetails"><i class="material-icons">dangerous</i></a>';
    
                        }

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('FeeCollection/index')->with("page", "fee_challan");  
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
        $createFeeChallanService = new CreateFeeChallanService();

        try{

            $result['data'] = $createFeeChallanService->add($request);

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
     * @param  \App\Models\CreateFeeChallan  $createFeeChallan
     * @return \Illuminate\Http\Response
     */
    public function show(CreateFeeChallan $createFeeChallan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CreateFeeChallan  $createFeeChallan
     * @return \Illuminate\Http\Response
     */
    public function edit(CreateFeeChallan $createFeeChallan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CreateFeeChallan  $createFeeChallan
     * @return \Illuminate\Http\Response
     */
    public function approveChallan(Request $request, $id)
    {
        $createFeeChallanService = new CreateFeeChallanService();
        $allSessions = session()->all();

        $result = ["status" => 200];
        try{     
            $result['data'] = $createFeeChallanService->approveChallan($request, $id, $allSessions);  

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }

    

    public function rejectChallan(Request $request, $id)
    {
       
        $createFeeChallanService = new CreateFeeChallanService();
        $result = ["status" => 200];
        try{     
            $result['data'] = $createFeeChallanService->rejectChallan($request, $id);  

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
     * @param  \App\Models\CreateFeeChallan  $createFeeChallan
     * @return \Illuminate\Http\Response
     */
    public function destroy(CreateFeeChallan $createFeeChallan)
    {
        //
    }
}
