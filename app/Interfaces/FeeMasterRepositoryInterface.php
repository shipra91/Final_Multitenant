<?php

namespace App\Interfaces;

Interface FeeMasterRepositoryInterface{
    public function all($idFeeCategory, $standard, $fee_type, $installment_type);
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
}

?>
