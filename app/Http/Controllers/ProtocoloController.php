<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Solicitacao;
use Gate;

class ProtocoloController extends Controller
{	

	protected $solicitacao;

	public function __construct(Solicitacao $solicitacao){
		$this->middleware('auth');

		$this->solicitacao = $solicitacao;
	}


	public function index(){

		//Verificação de permissão
		if(Gate::denies('protocolo')){
			return redirect()->back();
		}
		//Pega uma coleção com todos os papeis atribuido ao usuário logado
		$roles = auth()->user()->roles;

		$dados = $this->solicitacao->listProtocolo();

		return view('dashboard.protocolo.index',[
			'title' 	=> 'Protocolar Requerimentos',
			'roles' 	=> $roles,
			'dados' 	=> $dados,
		]);
	}

	public function cancelar($id){

		$success = $this->solicitacao->protocolarCancelar($id,'Cancelado');

		//Enviar mensagem para a view através de sessão unica sem deixar lixo no código
		session()->flash('success',[
			'success'  => $success['success'],
			'messages' => $success['messages'],
			'class'    => $success['class'],
		]);

		return redirect()->route('protocolo.index');

	}

	public function verSolicitacao($id){

		//Verificação de permissão
		if(Gate::denies('view_solicitacao')){
			return redirect()->back();
		}
		//Pega uma coleção com todos os papeis atribuido ao usuário logado
		$roles = auth()->user()->roles;

		$sol = new Solicitacao();

		$data = $sol->getDadosPdf($id);

		return view('dashboard.protocolo.viewSolicitacao',[
			'title' => 'Ver Solicitação',
			'roles' => $roles,
			'data' 	=> $data,
			'id' 	=> $id,
		]);
	}

	public function protocolar($id){

		$success = $this->solicitacao->protocolarCancelar($id,'Protocolado');

		//Enviar mensagem para a view através de sessão unica sem deixar lixo no código
		session()->flash('success',[
			'success'  => $success['success'],
			'messages' => $success['messages'],
			'class'    => $success['class'],
		]);

		return redirect()->route('protocolo.index');

	}
}
