<?php

namespace App\Interfaces;

Interface PreadmissionRepositoryInterface{
    public function all($data);
    public function store($data);
    public function fetch($id);
    // public function update($data, $id);
    public function update($data);
    public function delete($id);
    public function getMaxPreadmissionId();
}

?>
