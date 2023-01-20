<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class MessageGroupName extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_message_group_name';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_institute', 'id_academic', 'group_name', 'created_by', 'modified_by'
    ];
}