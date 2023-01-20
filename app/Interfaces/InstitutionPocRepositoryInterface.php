<?php

namespace App\Interfaces;

Interface InstitutionPocRepositoryInterface{
    public function all();
    public function store($data);
    public function fetch($institutionId);
    public function fetchPoc($id);
    public function update($data);
    public function delete($id);
}

?>