<?php

namespace App\Interfaces;

Interface PaymentGatewayFieldsRepositoryInterface{
    public function all($paymentGatewayId);
    public function store($data);
    public function fetch($id);
    // public function update($data, $id);
    public function update($data);
    public function delete($id);
}

?>
