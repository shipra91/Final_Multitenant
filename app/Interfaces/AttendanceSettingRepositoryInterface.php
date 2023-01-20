<?php

namespace App\Interfaces;

Interface AttendanceSettingRepositoryInterface{
    public function all($institutionId, $academicId);
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
}

?>