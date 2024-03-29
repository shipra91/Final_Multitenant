<?php

namespace App\Interfaces;

Interface ApplicationFeeSettingRepositoryInterface{
    public function all();
    public function store($data);
    public function fetch($id);
    public function update($data, $id);
    public function delete($id);
    public function allDeleted();
    public function restore($id);
    public function restoreAll();
}

?>