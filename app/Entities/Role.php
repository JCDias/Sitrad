<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Permission;

class Role extends Model
{
    public function permissions(){
    	return $this->belongsToMany(Permission::class);
    }

     public function historico(){
    	return $this->belongsToMany(Historico::class);
    }

    protected $fillable = ['name','label'];
}
