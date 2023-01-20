<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class RoomMaster extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_room_master';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_institute', 'id_academic_year', 'building_name', 'block_name', 'floor_number', 'room_number', 'display_name','regular_capacity', 'exam_capacity', 'created_by', 'modified_by'
    ];
}
