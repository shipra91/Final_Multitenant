<?php

namespace App\Interfaces;

Interface DynamicTokensRepositoryInterface{
    public function all();
    public function store($data);
    public function fetch($id);
    public function restore($id);
    public function restoreAll();
    public function delete($id);
}

?>