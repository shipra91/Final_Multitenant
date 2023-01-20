<?php

namespace App\Interfaces;

Interface CategoryFeeHeadingMasterRepositoryInterface{
    public function all();
    public function store($data);
    public function fetch($feeCategorySettingId, $feeHeadingId);
    public function update($data);
    public function delete($id);
}

?>