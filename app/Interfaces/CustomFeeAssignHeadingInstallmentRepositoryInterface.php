<?php

namespace App\Interfaces;

Interface CustomFeeAssignHeadingInstallmentRepositoryInterface{
    public function all();
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
}

?>