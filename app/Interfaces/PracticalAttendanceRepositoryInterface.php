<?php

namespace App\Interfaces;

Interface PracticalAttendanceRepositoryInterface{
    public function all();
    public function store($data);
    // public function fetch($id);
    public function fetch($standardId, $subjectId, $studentId, $periodId, $batchId, $heldOn);
    public function update($data);
    public function delete($id);
}

?>
