<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Cursos extends Model
{
    //Retornar array formatado para select box
    public static function selectBoxList(string $descricao = 'name', string $chave = 'id'){

        $cursos = Cursos::orderBy('name')->get();
        
        //return Tipos::pluck($descricao, $chave)->all();
        return $cursos;
    }

    public function HelperModelDe(){
    	return $this->hasMany(HelperModel::class,'id','curso_de');
    }

    public function HelperModelPara(){
    	return $this->hasMany(HelperModel::class,'id','curso_para');
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

}
