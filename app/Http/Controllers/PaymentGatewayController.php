<?php

namespace App\Http\Controllers;

use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use App\Http\Requests\StorePaymentGatewayRequest;
use App\Services\PaymentGatewayService;
use DataTables;

class PaymentGatewayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $paymentGatewayService = new PaymentGatewayService();

        if ($request->ajax()) {
            $paymentGateway = $paymentGatewayService->getAll();
            return Datatables::of($paymentGateway)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $btn = '<a href="/etpl/payment-gateway/'.$row['id'].'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>
                        <a href="/etpl/payment-gateway-detail/'.$row['id'].'" rel="tooltip" title="View" class="text-info"><i class="material-icons">visibility</i></a>
                        <a href="javascript:void(0);" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('PaymentGateway/paymentGateway')->with("page", "payment_gateway");
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
    public function store(StorePaymentGatewayRequest $request)
    {
        $paymentGatewayService = new PaymentGatewayService();

        $result = ["status" => 200];

        try{

            $result['data'] = $paymentGatewayService->add($request);

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
     * @param  \App\Models\PaymentGateway  $paymentGateway
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $paymentGatewayService = new PaymentGatewayService();

        $paymentGatewayData = $paymentGatewayService->find($id);
        return view('PaymentGateway/viewPaymentGateway', ["paymentGatewayData" => $paymentGatewayData])->with("page", "payment_gateway");
        //dd($paymentGatewayData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentGateway  $paymentGateway
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $paymentGatewayService = new PaymentGatewayService();

        $selectedPaymentGateway = $paymentGatewayService->find($id);
        return view('PaymentGateway/editPaymentGateway', ["selectedPaymentGateway" => $selectedPaymentGateway])->with("page", "payment_gateway");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentGateway  $paymentGateway
     * @return \Illuminate\Http\Response
     */
    public function update(StorePaymentGatewayRequest $request, $id)
    {
        
        $paymentGatewayService = new PaymentGatewayService();
        $result = ["status" => 200];

        try{

            $result['data'] = $paymentGatewayService->update($request, $id);

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
     * @param  \App\Models\PaymentGateway  $paymentGateway
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {        
        $paymentGatewayService = new PaymentGatewayService();
        $result = ["status" => 200];

        try{

            $result['data'] = $paymentGatewayService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
