<?php

namespace App\Interfaces;

Interface StaffBoardRepositoryInterface{
    public function all($staffId);
    public function store($data);
    public function fetch($id);
    public function update($data, $id);
    public function delete($id);
}

?>
