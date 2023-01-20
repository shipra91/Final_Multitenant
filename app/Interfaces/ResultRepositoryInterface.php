<?php

namespace App\Interfaces;

Interface ResultRepositoryInterface{
    public function all();
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
}

?>
