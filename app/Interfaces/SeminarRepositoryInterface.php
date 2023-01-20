<?php

namespace App\Interfaces;

Interface SeminarRepositoryInterface{
    public function all($allSessions);
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
}
