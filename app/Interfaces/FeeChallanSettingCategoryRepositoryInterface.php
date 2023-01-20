<?php

namespace App\Interfaces;

Interface FeeChallanSettingCategoryRepositoryInterface{
    public function all($id);
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
}

?>