<?php

namespace App\Interfaces;

Interface MessageGroupMembersRepositoryInterface{
    public function all($groupId, $allSessions);
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
}

?>