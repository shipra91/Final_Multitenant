<?php

namespace App\Interfaces;

Interface StandardSubjectRepositoryInterface{
    public function all($allSessions);
    public function store($data);
    public function fetch($id, $allSessions);
    public function update($data);
    public function delete($id, $allSessions);
}

?>