<?php
    namespace App\Repositories;
    use App\Models\PaymentGateway;
    use App\Interfaces\PaymentGatewayRepositoryInterface;

    class PaymentGatewayRepository implements PaymentGatewayRepositoryInterface{

        public function all(){
            return PaymentGateway::all();
        }

        public function store($data){
            return PaymentGateway::create($data);
        }

        public function fetch($id){
            return PaymentGateway::find($id);
        }

        // public function update($data, $id){
        //     return PaymentGateway::whereId($id)->update($data);
        // }

        public function update($data){
            return $data->save();
        }

        public function delete($id){
            return PaymentGateway::find($id)->delete();
        }
    }

