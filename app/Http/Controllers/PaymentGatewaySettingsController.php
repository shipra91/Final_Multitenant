<?php

namespace App\Http\Controllers;

use App\Models\PaymentGatewaySettings;
use Illuminate\Http\Request;
use App\Services\PaymentGatewaySettingsService;
use DataTables;
use Helper;

class PaymentGatewaySettingsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paymentGatewaySettingsService = new PaymentGatewaySettingsService();

        if ($request->ajax()) {
            $paymentGatewaySettings = $paymentGatewaySettingsService->getAll();
            return Datatables::of($paymentGatewaySettings)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $btn = '';
                        if(Helper::checkAccess('payment-gateway-settings', 'edit')){
                            $btn .= '<a href="/payment-gateway-settings/'.$row['id'].'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                        }
                        if(Helper::checkAccess('payment-gateway-settings', 'view')){
                            $btn .= '<a href="/payment-gateway-settings-detail/'.$row['id'].'" rel="tooltip" title="View" class="text-info"><i class="material-icons">visibility</i></a>';
                        }
                        if(Helper::checkAccess('payment-gateway-settings', 'delete')){
                            $btn .= '<a href="javascript:void(0);" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('PaymentGatewaySettings/paymentGatewaySettings')->with("page", "payment_gateway_setting");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $paymentGatewaySettingsService = new PaymentGatewaySettingsService();
        $paymentGateways = $paymentGatewaySettingsService->allPaymentGateway();

        return view('PaymentGatewaySettings/addPaymentGatewaySettings', ['paymentGateways' => $paymentGateways])->with("page", "payment_gateway_setting");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $paymentGatewaySettingsService = new PaymentGatewaySettingsService();
        $result = ["status" => 200];

        try{

            $result['data'] = $paymentGatewaySettingsService->add($request);

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
     * @param  \App\Models\PaymentGatewaySettings  $paymentGatewaySettings
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paymentGatewaySettingsService = new PaymentGatewaySettingsService();
        $selectedGatewaySettings = $paymentGatewaySettingsService->find($id);
        return view('PaymentGatewaySettings/viewPaymentGatewaySettings', ["selectedGatewaySettings" => $selectedGatewaySettings])->with("page", "payment_gateway_setting");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentGatewaySettings  $paymentGatewaySettings
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $paymentGatewaySettingsService = new PaymentGatewaySettingsService();
        $selectedGatewaySettings = $paymentGatewaySettingsService->find($id);
        //dd($selectedGatewaySettings);

        return view('PaymentGatewaySettings/editPaymentGatewaySettings', ["selectedGatewaySettings" => $selectedGatewaySettings])->with("page", "payment_gateway_setting");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentGatewaySettings  $paymentGatewaySettings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $paymentGatewaySettingsService = new PaymentGatewaySettingsService();
        $result = ["status" => 200];

        try{

            $result['data'] = $paymentGatewaySettingsService->update($request, $id);

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
     * @param  \App\Models\PaymentGatewaySettings  $paymentGatewaySettings
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paymentGatewaySettingsService = new PaymentGatewaySettingsService();
        $result = ["status" => 200];

        try{

            $result['data'] = $paymentGatewaySettingsService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
