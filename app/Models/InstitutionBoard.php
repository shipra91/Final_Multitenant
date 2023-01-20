<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class InstitutionBoard extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_institution_boards';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_institution', 'id_board', 'created_by', 'modified_by', 'deleted_at'
    ];
}
