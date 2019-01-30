<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Historico extends Model
{
    protected $tabela = 'historicos';

    protected $fillable = ['solicitacao_id','user_id','acao_id', 'valor', 'resposta'];

    //belongs to porque a chave de acoes está dentro da tabela historico
    public function acoes(){
    	return $this->belongsTo(Acoes::class,'acao_id','id');
    }

    //belongs to porque a chave de cursos está dentro da tabela historico
    public function roles(){
        return $this->belongsTo(Role::class,'valor','id');
    }

    public function getFormattedCreatedAtAttribute(){

		$data = date( 'd/m/Y  H:i' , strtotime($this->attributes['created_at']));

		return $data;
	}
}
