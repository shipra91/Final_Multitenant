<?php
    namespace App\Repositories;
    use App\Models\PaymentGatewayFields;
    use App\Interfaces\PaymentGatewayFieldsRepositoryInterface;
    use DB;

    class PaymentGatewayFieldsRepository implements PaymentGatewayFieldsRepositoryInterface{

        // public function all(){
        //     return PaymentGatewayFields::all();
        // }

        public function all($paymentGatewayId){
            return PaymentGatewayFields::where('id_payment_gateway', $paymentGatewayId)->get();
        }

        public function store($data){
            return PaymentGatewayFields::create($data);
        }

        public function fetch($id){
            //\DB::enableQueryLog();
            $paymentGatewayField = PaymentGatewayFields::find($id);
            //dd(\DB::getQueryLog());
            return $paymentGatewayField;
        }

        // public function update($data, $id){
        //     return PaymentGatewayFields::whereId($id)->update($data);
        // }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return PaymentGatewayFields::find($id)->delete();
        }

        public function fetchFieldsBasedOnGateways($idPaymentGateway){
            \DB::enableQueryLog();
            $data = PaymentGatewayFields::where('id_payment_gateway', $idPaymentGateway)->get();
            // dd(\DB::getQueryLog());
            return $data;
        }

        
    }
