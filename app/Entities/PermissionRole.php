<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\{Role, User};

class PermissionRole extends Model
{
    
    protected $table = 'permission_role';

    protected $fillable = [
        'role_id', 'permission_id', 
    ];
}