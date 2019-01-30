<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\{Role, User};

class RoleUser extends Model
{
    
    protected $table = 'role_user';

    protected $fillable = [
        'role_id', 'user_id', 
    ];
}
    
