<?php

namespace App\Interfaces;

Interface CustomFieldRepositoryInterface{
    public function all();
    public function store($data);
    public function fetch($id);
    public function update($data, $id);
    public function delete($id);
    public function getCustomFieldValue($column_name, $Id, $idCustomField, $model);
}

?>