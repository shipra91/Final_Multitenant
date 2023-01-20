<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class SeminarConductedBy extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use HasFactory;
    use Uuids;

    protected $table      = 'tbl_seminar_conducted_by';
    protected $primaryKey = 'id';
    protected $fillable   = ['id', 'id_seminar', 'conducted_by', 'type', 'obtained_marks', 'remarks', 'created_by', 'modified_by'];
}
