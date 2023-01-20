<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class EventApplicableTo extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_event_applicable_to';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_event', 'recipient_type', 'id_staff_category', 'id_staff_subcategory', 'id_standard', 'id_subject', 'created_by', 'modified_by'
    ];
}
