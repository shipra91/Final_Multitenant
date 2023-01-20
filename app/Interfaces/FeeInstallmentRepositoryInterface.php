<?php

namespace App\Interfaces;

Interface FeeInstallmentRepositoryInterface{
    public function all($feeAssignmentId);
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
}

?>
