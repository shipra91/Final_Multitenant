<?php

namespace App\Interfaces;

Interface RoleRepositoryInterface{
    public function all();
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
    public function getRoleID($userType = '');
    public function getRoleDetail($userType = '');
}

?>