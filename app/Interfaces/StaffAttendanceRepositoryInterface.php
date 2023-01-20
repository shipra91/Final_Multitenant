<?php

namespace App\Interfaces;

Interface StaffAttendanceRepositoryInterface{
    public function all();
    public function store($data);
    public function fetch($staffId, $heldOn, $idInstitution, $academicYear);
    public function update($data);
    public function delete($id);
}

?>