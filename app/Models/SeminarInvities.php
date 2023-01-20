<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class SeminarInvities extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use HasFactory;
    use Uuids;

    protected $table      = 'tbl_seminar_invities';
    protected $primaryKey = 'id';
    protected $fillable   = ['id', 'id_seminar', 'recipient_type', 'id_staff_category', 'id_staff_subcategory', 'id_standard', 'id_subject', 'created_by', 'modified_by'];
}
