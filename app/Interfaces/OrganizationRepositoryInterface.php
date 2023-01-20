<?php

namespace App\Interfaces;

Interface OrganizationRepositoryInterface{
    public function all();
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
    public function upload($file, $basePath);
    public function uploadOtherFiles($file, $basePath);
    public function allDeleted();
    public function restore($id);
    public function restoreAll();
}

?>