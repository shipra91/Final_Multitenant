<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Gallery extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use HasFactory;
    use Uuids;

    protected $table      = 'tbl_gallery';
    protected $primaryKey = 'id';
    protected $fillable   = ['id', 'id_institution', 'id_academic_year', 'title', 'date', 'description', 'cover_image', 'created_by', 'modified_by'];
}
