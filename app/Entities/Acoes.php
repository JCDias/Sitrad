<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Acoes extends Model
{
    protected $table = 'acoes';

   	//Definindo relacionamentos
    public function solicitacao(){
    	return $this->hasMany(Solicitacao::class,'status_atual','id');
    }

    public function historico(){
    	return $this->hasMany(Historico::class,'acao_id','id');
    }
}
