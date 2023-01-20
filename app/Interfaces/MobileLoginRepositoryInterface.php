<?php

namespace App\Interfaces;

Interface MobileLoginRepositoryInterface{
    public function getLoginStatus($mobile_number);
    public function store($data);
    public function fetch($id);
    public function update($data);
    public function delete($id);
}

?>