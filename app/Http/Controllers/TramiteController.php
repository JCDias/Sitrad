<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\{Solicitacao,Historico};
use Auth;
use Gate;

class TramiteController extends Controller
{

	private $solicitacao;

	public function __construct(Solicitacao $solicitacao){
		$this->middleware('auth');

		$this->solicitacao = $solicitacao;
	}


	public function index($id){
		
		// $dados = Historico::with('acoes')->with('roles')->where('solicitacao_id',22)->orderBy('created_at','desc')->first();
		// dd(Auth::user()->hasAnyRoles('sra'));
		// dd($dados->valor);

		//Verificação de permissão
		if(Gate::denies('tramite')){
			return redirect()->back();
		}
		//Pega uma coleção com todos os papeis atribuido ao usuário logado
		$roles = auth()->user()->roles;

		$dados = $this->solicitacao->historico($id);

		$historico = Historico::with('acoes')->with('roles')->where('solicitacao_id',$id)->orderBy('id')->get();

		//dd($historico);

		return view('dashboard.tramite.index',[
			'title' 		=> 'Trâmite de requerimento',
			'roles' 	 	=> $roles,
			'requerimento' 	=> $dados,
			'historico'  	=> $historico,
			'id'  			=> $id,
		]);
	}

	public function tramite(Request $request){

		$success = $this->solicitacao->realizarTramite($request);

		//Enviar mensagem para a view através de sessão unica sem deixar lixo no código
		session()->flash('success',[
			'success'  => $success['success'],
			'messages' => $success['messages'],
			'class'    => $success['class'],
		]);

		return redirect()->route('dashboard.index');

	}

	public function resposta($id){

		//Verificação de permissão
		if(Gate::denies('tramite')){
			return redirect()->back();
		}
		//Pega uma coleção com todos os papeis atribuido ao usuário logado
		$roles = auth()->user()->roles;

		$dados = $this->solicitacao->historico($id);

		$historico = Historico::with('acoes')->with('roles')->where('solicitacao_id',$id)->orderBy('created_at')->get();

		//dd($dados);

		return view('dashboard.tramite.resposta',[
			'title' 		=> 'Trâmite de requerimento',
			'roles' 	 	=> $roles,
			'requerimento' 	=> $dados,
			'historico'  	=> $historico,
			'id'  			=> $id,
		]);

	}

	public function responder(Request $request){
		
		$success = $this->solicitacao->insereResposta($request);

		//Enviar mensagem para a view através de sessão unica sem deixar lixo no código
		session()->flash('success',[
			'success'  => $success['success'],
			'messages' => $success['messages'],
			'class'    => $success['class'],
		]);

		return redirect()->route('dashboard.index');
	}

}
