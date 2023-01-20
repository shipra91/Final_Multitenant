<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class InstitutionModule extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_institution_modules';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_institution', 'id_module', 'display_order', 'id_parent', 'created_by', 'modified_by', 'deleted_at'
    ];
}
