<?php

namespace App\Interfaces;

Interface InstitutionBoardRepositoryInterface{
    public function all($institutionId);
    public function store($data);
    public function fetch($id);
    public function update($data, $id);
    public function delete($id);
    public function restore($id);
    public function getBoardId($institutionId, $boardId);
}

?>