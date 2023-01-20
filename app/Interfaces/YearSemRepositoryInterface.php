<?php

namespace App\Interfaces;

Interface YearSemRepositoryInterface{
    public function all($id, $allSessions);
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
}

?>