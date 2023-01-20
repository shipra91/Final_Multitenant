<?php

namespace App\Interfaces;

Interface ClassTimeTableRepositoryInterface{
    public function all();
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
}
