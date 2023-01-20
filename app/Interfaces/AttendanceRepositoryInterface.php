<?php

namespace App\Interfaces;

Interface AttendanceRepositoryInterface{
    public function all();
    public function store($data);
    // public function fetch($id);
    public function fetch($studentId, $heldOn, $standardId, $subjectId, $attendanceType, $periodSession);
    public function update($data);
    public function delete($id);
}

?>
