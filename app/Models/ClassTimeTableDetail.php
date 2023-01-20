<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;


class ClassTimeTableDetail extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use HasFactory;
    use Uuids;

    protected $table      = 'tbl_class_time_table_detail';
    protected $primaryKey = 'id';
    protected $fillable   = ['id', 'id_class_time_table', 'id_subject', 'id_staffs', 'id_room', 'created_by', 'modified_by'];
}
