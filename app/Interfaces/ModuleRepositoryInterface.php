<?php

namespace App\Interfaces;

Interface ModuleRepositoryInterface{
    public function all($idparent);
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
    public function allInstitutionModules($idParent);
}

?>