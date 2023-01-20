<?php

namespace App\Interfaces;

Interface CustomFeeAssignmentRepositoryInterface{
    public function all();
    public function store($data);
    public function fetch($idStudent, $idStandard, $idFeeCategory, $institutionId, $academicId);
    public function update($data);
    public function delete($id);
}

?>