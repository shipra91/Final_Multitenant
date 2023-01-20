<?php

namespace App\Interfaces;

Interface StaffRepositoryInterface{
    public function all($request);
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
    public function getMaxStaffId();
    public function allDeleted();
    public function restore($id);
    public function restoreAll();
}

?>
