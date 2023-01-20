<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class DynamicTemplate extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_dynamic_templates';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'template_category', 'template_name', 'template_content', 'created_by', 'modified_by'
    ];
    
}
