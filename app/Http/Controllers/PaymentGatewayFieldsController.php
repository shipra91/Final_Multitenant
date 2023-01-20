<?php

namespace App\Http\Controllers;

use App\Models\PaymentGatewayFields;
use Illuminate\Http\Request;
use App\Services\PaymentGatewayFieldsService;

class PaymentGatewayFieldsController extends Controller
{
    /**
     *
     * create Constructor to use the functions defined in the repositories
     */
    protected $paymentGatewayFieldsService;
    public function __construct(PaymentGatewayFieldsService $paymentGatewayFieldsService)
    {
        $this->paymentGatewayFieldsService = $paymentGatewayFieldsService;
    }

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
        $result = ["status" => 200];

        try{

            $result['data'] = $this->paymentGatewayFieldsService->delete($id);

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
        $idPaymentGateway = $request['id'];
        return $this->paymentGatewayFieldsService->fetchFieldsBasedOnGateways($idPaymentGateway);
    }
}
