<?php

namespace App\Interfaces;

Interface ExamTimetableRepositoryInterface{
    public function all();
    public function store($data);
    public function fetch($request, $id, $stdId);
    public function update($data);
    public function delete($id);
}

?>