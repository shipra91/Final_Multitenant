<?php
    namespace App\Repositories;
    use App\Models\PaymentGatewayValues;
    use App\Interfaces\PaymentGatewayValuesRepositoryInterface;
    use DB;

    class PaymentGatewayValuesRepository implements PaymentGatewayValuesRepositoryInterface{

        public function all(){
            return PaymentGatewayValues::all();
        }

        public function store($data){
            return PaymentGatewayValues::create($data);
        }

        public function search($id){
            return PaymentGatewayValues::find($id);
        }

        public function fetch($paymentGatewaySettingsId, $fieldId){
            //\DB::enableQueryLog();
            $paymentGatewayValues = PaymentGatewayValues::where('id_payment_gateway_settings', $paymentGatewaySettingsId)->where('id_gateway_fields', $fieldId)->first();
            //dd(\DB::getQueryLog());
            return $paymentGatewayValues;
        }

        // public function fetch($id){
        //     //\DB::enableQueryLog();
        //     $paymentGatewayValues = PaymentGatewayValues::find($id);
        //     //dd(\DB::getQueryLog());
        //     return $paymentGatewayValues;
        // }

        // public function update($data, $id){
        //     return PaymentGatewayFields::whereId($id)->update($data);
        // }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return PaymentGatewayValues::find($id)->delete();
        }

        public function allPaymentSettingValues($paymentGatewaySettingsId, $fieldId){
            return PaymentGatewayValues::where('id_payment_gateway_settings', $paymentGatewaySettingsId)
                                        ->where('id_gateway_fields', $fieldId)->first();
        }
    }
