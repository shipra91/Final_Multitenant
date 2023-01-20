<?php

namespace App\Interfaces;

Interface CircularApplicableToRepositoryInterface{
    public function all($idCircular);
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
}