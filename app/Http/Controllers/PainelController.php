<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class PainelController extends Controller{
    
    //Função que retorna o a página pública do sistema
	public function index(){
		return view('painel.index', [
			'title' => 'Index',
		]);
	}

	//Função que retorna um breve resumo sobre o sistema
	public function sobre(){
		return view('painel.sobre', [
			'title' => 'Sobre',
		]);
	}

}
