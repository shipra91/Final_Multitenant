<?php

namespace App\Interfaces;

Interface FeeAssignDetailRepositoryInterface{
    public function all($idStudent, $idFeeCategory, $idAcademic);
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id, $actionType);
}

?>