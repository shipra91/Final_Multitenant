<?php

namespace App\Interfaces;

Interface InstitutionModuleRepositoryInterface{
    public function all($institutionId);
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
    public function restore($id);
    public function getModuleId($institutionId, $moduleId);
    public function getAllModuleId($institutionId, $moduleId);
}

?>