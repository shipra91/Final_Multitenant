<?php

namespace App\Interfaces;

Interface MessageCreditDetailsRepositoryInterface{
    public function all($institutionId);
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
}

?>