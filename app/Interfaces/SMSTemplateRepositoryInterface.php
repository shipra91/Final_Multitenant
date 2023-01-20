<?php

namespace App\Interfaces;

Interface SMSTemplateRepositoryInterface{
    public function all($allSessions);
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
}

?>