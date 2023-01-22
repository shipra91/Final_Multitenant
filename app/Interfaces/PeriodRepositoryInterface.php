<?php

namespace App\Interfaces;

Interface PeriodRepositoryInterface{
    public function all($allSessions);
    public function store($data);
    public function fetch($id);
    public function update($data, $id);
    public function delete($id);
}

?>