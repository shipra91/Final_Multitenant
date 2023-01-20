<?php

namespace App\Interfaces;

Interface UniversityRepositoryInterface{
    public function all();
    public function store($data);
    public function fetch($id);
    public function update($data, $id);
    public function delete($id);
}

?>