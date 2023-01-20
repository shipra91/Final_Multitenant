<?php

namespace App\Interfaces;

Interface PaymentGatewayValuesRepositoryInterface{
    public function all();
    public function store($data);
    // public function fetch($id);
    public function fetch($paymentGatewaySettingsId, $fieldId);
    public function search($id);
    public function update($data);
    public function delete($id);
}

?>
