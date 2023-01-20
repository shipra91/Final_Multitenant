<?php

namespace App\Interfaces;

Interface CombinationSubjectRepositoryInterface{
    public function all();
    public function store($data);
    public function fetch($id);
    public function update($data, $id);
    public function delete($id);
}

?>