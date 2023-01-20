<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Uuids;

class DocumentDetail extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use Uuids;

    protected $table      = 'tbl_document_detail';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id', 'id_document', 'id_document_header', 'unique_id', 'doc_count', 'created_by', 'modified_by'
    ];
}
