<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class ETPLUsers extends Authenticatable implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $guard = 'webadmin';

    protected $table      = 'tbl_etpl_users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'emp_id',
        'fullname',
        'contact',
        'email',
        'password',
        'is_email_verified' //add this
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    
}

