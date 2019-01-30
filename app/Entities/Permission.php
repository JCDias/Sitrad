<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Role;

class Permission extends Model{
    
    //retorna todas as permissões que estão ligadas ao papel
    public function roles(){
    	return $this->belongsToMany(Role::class);
    }

}
