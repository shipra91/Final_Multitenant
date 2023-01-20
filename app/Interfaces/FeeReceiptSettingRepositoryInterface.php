<?php

namespace App\Interfaces;

Interface FeeReceiptSettingRepositoryInterface{
    public function all();
    public function store($data);
    public function fetch($id, $idAcademic);
    public function update($data);
    public function delete($id);
}

?>
