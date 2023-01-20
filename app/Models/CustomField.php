<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class CustomField extends Model implements Auditable   
    {
        use HasFactory;
        use \OwenIt\Auditing\Auditable;
        use SoftDeletes;
        use Uuids;

        protected $table      = 'tbl_custom_fields';
        protected $primaryKey = 'id';
        protected $fillable   = [
            'id', 'id_institution', 'module', 'field_name', 'field_type', 'field_value', 'is_required', 'grid_length', 'deleted_at', 'created_by', 'modified_by'
        ];

    }
