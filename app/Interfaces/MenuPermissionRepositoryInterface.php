<?php

namespace App\Interfaces;

Interface MenuPermissionRepositoryInterface{
    public function all($allSessions);
    public function store($data);
    public function fetch($id);
    public function restore($id);
    public function restoreAll($allSessions);
    public function delete($id);
    public function getAllServicePermission($roleId, $allSessions);
}

?>