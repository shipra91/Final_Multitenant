<?php

namespace App\Interfaces;

Interface YearRepositoryInterface{
    public function all();
    public function getAll();
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
}

?>