<?php

namespace App\Interfaces;

Interface InstitutionRepositoryInterface{
    public function all();
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
    public function upload($file, $idOrganization, $institutionName);
    public function otherFileUpload($file);
    public function allDeleted();
    public function restore($id);
    public function restoreAll();
}

?>