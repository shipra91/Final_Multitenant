<?php

namespace App\Interfaces;

Interface StaffSubjectMappingRepositoryInterface{
    public function all($staffId);
    public function store($data);
    public function fetch($id);
    public function update($data, $id);
    public function delete($id);
    public function fetchSubjectStaffs($id);
}

?>
