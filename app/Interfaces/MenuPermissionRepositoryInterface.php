<?php

namespace App\Interfaces;

Interface MenuPermissionRepositoryInterface{
    public function all();
    public function store($data);
    public function fetch($id);
    public function restore($id);
    public function restoreAll();
    public function delete($id);
    public function getAllServicePermission($roleId);
}

?>