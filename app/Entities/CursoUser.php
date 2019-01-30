<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\{Curso, User};

class CursoUser extends Model
{
    
    protected $table = 'curso_user';

    protected $fillable = [
        'curso_id', 'user_id', 
    ];
}
    
