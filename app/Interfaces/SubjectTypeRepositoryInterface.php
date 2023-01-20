<?php

namespace App\Interfaces;

Interface SubjectTypeRepositoryInterface{
    public function all();
    public function fetch($id);
}

?>