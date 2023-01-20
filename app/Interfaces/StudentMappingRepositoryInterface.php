<?php

namespace App\Interfaces;

Interface StudentMappingRepositoryInterface{
    public function all();
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
    public function fetchInstitutionStudents($standard, $feetype,$gender);
}

?>
