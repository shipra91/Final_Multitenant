<?php

namespace App\Interfaces;

Interface EventAttendanceRepositoryInterface{
    public function all();
    public function store($data);
    // public function fetch($id);
    public function fetch($idEvent, $idRecepient);
    // public function update($data, $id);
    public function update($data);
    public function delete($id);
}

?>


