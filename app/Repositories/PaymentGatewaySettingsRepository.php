<?php
    namespace App\Repositories;
    use App\Models\PaymentGatewaySettings;
    use App\Models\PaymentGateway;
    use App\Interfaces\PaymentGatewaySettingsRepositoryInterface;
    use DB;

    class PaymentGatewaySettingsRepository implements PaymentGatewaySettingsRepositoryInterface{

        public function all(){
            return PaymentGatewaySettings::join('tbl_payment_gateway', 'tbl_payment_gateway.id', '=', 'tbl_payment_gateway_settings.id_payment_gateway')
            ->select('tbl_payment_gateway.*', 'tbl_payment_gateway_settings.*')->get();
        }

        public function store($data){
            return PaymentGatewaySettings::create($data);
        }

        public function fetch($id){
            // \DB::enableQueryLog();
            $paymentGatewaySettings = PaymentGatewaySettings::find($id);
            // dd(\DB::getQueryLog());
            return $paymentGatewaySettings;
        }

        // public function update($data, $id){
        //     return PaymentGatewayFields::whereId($id)->update($data);
        // }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return PaymentGatewaySettings::find($id)->delete();
        }

        public function getPaymentGateway(){
            return PaymentGateway::all();
        }
    }
