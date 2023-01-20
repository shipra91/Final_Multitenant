<?php

namespace App\Http\Controllers;

use App\Models\PaymentGatewayFields;
use Illuminate\Http\Request;
use App\Services\PaymentGatewayFieldsService;

class PaymentGatewayFieldsController extends Controller
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
     * @param  \App\Models\PaymentGatewayFields  $paymentGatewayFields
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentGatewayFields $paymentGatewayFields)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentGatewayFields  $paymentGatewayFields
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentGatewayFields $paymentGatewayFields)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentGatewayFields  $paymentGatewayFields
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentGatewayFields $paymentGatewayFields)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentGatewayFields  $paymentGatewayFields
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paymentGatewayFieldsService = new PaymentGatewayFieldsService();
        $result = ["status" => 200];

        try{

            $result['data'] = $paymentGatewayFieldsService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function fetchFieldsBasedOnGateways(Request $request)
    {
        $paymentGatewayFieldsService = new PaymentGatewayFieldsService();

        $idPaymentGateway = $request['id'];
        return $data = $paymentGatewayFieldsService->fetchFieldsBasedOnGateways($idPaymentGateway);
    }
}
