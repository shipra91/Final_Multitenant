<?php

namespace App\Interfaces;

Interface ModuleDynamicTokensMappingRepositoryInterface{
    public function all();
    public function store($data);
    public function fetch($id);
    public function restore($id);
    public function restoreAll();
    public function delete($id);
}

?>