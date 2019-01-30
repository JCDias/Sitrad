<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class HelperModel extends Model
{
    protected $table;

    public function __construct($table){
    	$this->table = $table;
    }

    //Definindo relacionamentos
    public function cursoDe(){
    	return $this->belongsTo(Cursos::class,'curso_de','id');
    }

    public function cursoPara(){
    	return $this->belongsTo(Cursos::class,'curso_para','id');
    }

    public function solicitacao(){
        return $this->belongsTo(Solicitacao::class,'solicitacao_id','id');
    }
}
