<?php

namespace App\Interfaces;

Interface FeeChallanDetailRepositoryInterface{
    public function all();
    public function store($data);
    public function fetch($idFeeCategory, $idFeeChallan);
    public function update($data);
    public function delete($id);
}

?>