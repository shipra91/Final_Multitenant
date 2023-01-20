<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class ApplicationFeeSetting extends Model implements Auditable   
    {
        use HasFactory;
        use \OwenIt\Auditing\Auditable;
        use SoftDeletes;
        use Uuids;

        protected $table      = 'tbl_application_fee_settings';
        protected $primaryKey = 'id';
        protected $fillable   = [
            'id', 'id_institute', 'id_academic_year', 'id_application_setting', 'id_standard', 'fee_amount', 'receipt_prefix', 'receipt_starting_number', 'created_by', 'modified_by'
        ];

    }

