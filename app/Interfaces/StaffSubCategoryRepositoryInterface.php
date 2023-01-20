<?php

namespace App\Interfaces;

Interface StaffSubCategoryRepositoryInterface{
    public function all();
    public function store($data);
    public function fetch($id);
    // public function update($data, $id);
    public function update($data);
    public function delete($id);
}

?>
