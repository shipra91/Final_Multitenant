<?php

namespace App\Interfaces;

Interface FeeCategorySettingRepositoryInterface{
    public function all($masterId);
    public function store($data);
    public function fetch($id);
    public function search($id);
    public function update($data);
    public function delete($id);
}

?>
