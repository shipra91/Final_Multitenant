<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class EmailTemplate extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_email_templates';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_institute', 'id_module', 'template_name', 'template_detail', 'created_by', 'modified_by'
    ];
}
