<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Tipos;
use Gate;

class TiposController extends Controller
{
    public function index(){
    	//Verificação de permissão
        if(Gate::denies('gestao_requerimento')){
            return redirect()->back();
        }
        //Pega uma coleção com todos os papeis atribuido ao usuário logado
		$roles = auth()->user()->roles;

		return view('dashboard.tipos.index',[
			'title' => 'Criar novo tipo',
			'roles' => $roles,
		]);
    }

    public function store(Request $request){
    	//Verificação de permissão
        if(Gate::denies('gestao_requerimento')){
            return redirect()->back();
        }
        $rules = [
    		'name' => 'required|min:3|string|unique:tipos',
    	];
    	$validate = $this->validate($request, $rules);

    	Tipos::create([
    		'name' => $request->name,
    	]);

    	//Enviar mensagem para a view através de sessão unica sem deixar lixo no código
        session()->flash('success',[
            'success'  => true,
            'messages' => 'Novo tipo de requerimento criado com sucesso!',
            'class'    => 'success',
        ]);


    	return redirect()->route('requerimentos.novo');
    }
}
