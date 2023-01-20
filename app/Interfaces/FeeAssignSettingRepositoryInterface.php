<?php

namespace App\Interfaces;

Interface FeeAssignSettingRepositoryInterface{
    public function all($feeMasterId, $feeHeadingId);
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
}

?>
