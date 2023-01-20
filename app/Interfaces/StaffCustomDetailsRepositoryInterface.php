<?php

namespace App\Interfaces;

Interface StaffCustomDetailsRepositoryInterface{
    public function all();
    public function store($data);
    public function fetch($id);
    public function update($data, $id);
    public function delete($id);
    public function checkFieldExistence($staffId, $customFieldId);
}

?>