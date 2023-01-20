<?php

namespace App\Interfaces;

Interface CreateFeeChallanRepositoryInterface{
    public function all();
    public function store($data);
    public function fetch($idAcademic, $idStudent);
    public function update($data);
    public function delete($id);
}

?>