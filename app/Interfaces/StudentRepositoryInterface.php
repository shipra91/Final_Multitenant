<?php

namespace App\Interfaces;

Interface StudentRepositoryInterface{
    public function all($allSessions);
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
    public function getMaxStudentId();
}

?>