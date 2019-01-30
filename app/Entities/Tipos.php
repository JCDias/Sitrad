<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Tipos extends Model
{
    //Definindo nome da tabela 
    protected $table = 'tipos';

    protected $fillable = ['name'];

    //hasmany porque a chave do tipo está dentro da tabela requerimento
    public function requerimentos(){
    	return $this->hasMany(Requerimento::class,'requerimento_id','id');
    }

    //Retornar array formatado para select box
    public static function selectBoxList(string $descricao = 'name', string $chave = 'id'){
        $requerimentos = Requerimento::with('tipos')->where('status','ativo')->orderBy('tipo_id')->get();
        
        //return Tipos::pluck($descricao, $chave)->all();
        return $requerimentos;
    }

}
