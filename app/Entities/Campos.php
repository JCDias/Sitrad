<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Campos extends Model
{
    protected $table = 'campos';

    protected $fillable   = ['name','type'];

    //Método de relacionamento N para N entre Requerimentos e campos
    public function requerimentos(){
        return $this->belongsToMany(Requerimento::class,'campos_requerimentos','campo_id','requerimento_id')->withPivot(['label','placeholder','tamanho','ordem','mascara','name']);
    }
}
