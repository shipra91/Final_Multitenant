<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;


class InstitutionPoc extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use Uuids;

    protected $table      = 'tbl_institution_pocs';
    protected $primaryKey = 'id';
    protected $fillable   = ['id', 'id_institute', 'name', 'designation', 'email', 'mobile_number', 'created_by', 'modified_by'];
}
