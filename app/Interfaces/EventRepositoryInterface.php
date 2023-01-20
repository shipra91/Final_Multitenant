<?php

namespace App\Interfaces;

Interface EventRepositoryInterface{
    public function all($allSessions);
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
    public function allDeleted($allSessions);
    public function restore($id);
    public function restoreAll($allSessions);
}
