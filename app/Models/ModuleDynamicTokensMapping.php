<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class ModuleDynamicTokensMapping extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_module_dynamic_tokens_mappings';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'module', 'is_mapped_with', 'created_by', 'modified_by'
    ];
    
}