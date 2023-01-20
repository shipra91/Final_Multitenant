<?php

namespace App\Interfaces;

Interface StaffScheduleMappingRepositoryInterface{
    public function all($staffId, $day);
    public function store($data);
    public function fetch($id);
    // public function update($data, $id);
    public function update($data);
    public function delete($id);
}

?>
