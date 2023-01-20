<?php

namespace App\Interfaces;

Interface StaffRepositoryInterface{
    public function all($request, $allSessions);
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
    public function getMaxStaffId();
    public function allDeleted($allSessions);
    public function restore($id);
    public function restoreAll($allSessions);
}

?>
