<?php

namespace App\Interfaces;

Interface ComposeMessageRepositoryInterface {
    public function all();
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
}

?>