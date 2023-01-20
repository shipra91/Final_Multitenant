<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class AssignmentViewedDetails extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_assignment_viewed_details';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_assignment', 'id_student', 'view_count', 'created_by', 'modified_by'
    ];
}
