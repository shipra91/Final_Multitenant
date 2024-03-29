<?php

namespace App\Interfaces;

Interface FeeChallanSettingRepositoryInterface{
    public function all($allSessions);
    public function store($data);
    public function fetch($id, $idAcademic);
    public function update($data);
    public function delete($id);
}

?>
