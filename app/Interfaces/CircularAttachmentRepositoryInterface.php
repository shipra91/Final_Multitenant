<?php

namespace App\Interfaces;

Interface CircularAttachmentRepositoryInterface{
    public function all();
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
}
