<?php

namespace App\Interfaces;

Interface StandardSubjectStaffMappingRepositoryInterface{
    public function all($staffId);
    public function store($data);
    public function fetch($id);
    public function update($data, $id);
    public function delete($subjectId, $standardId);
    public function getStaffs($subjectId, $standardId);
}

?>
