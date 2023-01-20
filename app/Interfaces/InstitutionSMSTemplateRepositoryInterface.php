<?php

namespace App\Interfaces;

Interface InstitutionSMSTemplateRepositoryInterface{
    public function all();
    public function store($data);
    public function fetch($id, $allSessions);
    public function update($data);
    public function delete($id);
}

?>