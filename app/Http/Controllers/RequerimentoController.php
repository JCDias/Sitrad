<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\{Requerimento,Tipos,Role,Solicitacao};
use Gate;

class RequerimentoController extends Controller
{
	
	private $requerimento;
	private $tipos;
	private $paginate = 7;

	public function __construct(Requerimento $requerimento, Tipos $tipos){
		$this->requerimento = $requerimento;
		$this->tipos = $tipos;
		$this->middleware('auth');
	}


	public function index(){

		//Verificação de permissão
		if(Gate::denies('gestao_requerimento')){
			return redirect()->back();
		}

    	//Pega uma coleção com todos os papeis atribuido ao usuário logado
		$roles = auth()->user()->roles;

		//Pegar todos requerimentos cadastrados e ordenar por tipo
		//$requerimentos = $this->requerimento::with('tipos')->orderBy('tipo_id')->get();
		$requerimentos = $this->requerimento::with('tipos')->distinct('tipo_id')->paginate($this->paginate);
		
    	//'Tela que lista os requerimentos existentes dentro de uma tabela';
		return view('dashboard.requerimentos.index',[
			'title' => 'Requerimentos',
			'roles' => $roles,
			'requerimentos' => $requerimentos,
		]);
	}

	public function show($id){
		
		//Verificação de permissão
		if(Gate::denies('gestao_requerimento')){
			return redirect()->back();
		}

		//Pega uma coleção com todos os papeis atribuido ao usuário logado
		$roles = auth()->user()->roles;

		$req = $this->requerimento::with('tipos')->where('tipo_id', $id)->orderBy('status')->get();


		//Retornar o nome do requerimento selecionado
		$tipos = Tipos::find($id);

		return view('dashboard.requerimentos.show',[
			'title' => 'Requerimentos',
			'roles' => $roles,
			'requerimentos' => $req,
			'nome_requerimento' => $tipos->name,
		]);
	}

	public function detalhes($id, $table){
		return 'exibir campos de formulário da tabela selecionada com base no tipo de requerimento. id= '.$id.' tabela_id= '.$table;
	}

	public function create(Request $request){
		//Verificação de permissão
		if(Gate::denies('gestao_requerimento')){
			return redirect()->back();
		}
		//Pega uma coleção com todos os papeis atribuido ao usuário logado
		$roles = auth()->user()->roles;

		$rules = [
			'tipo' => 'required',
			'informacoes' => 'required',
			'passos' => 'required',
		];

		$solicitacao = new Solicitacao();

		$passos = implode(';',$request->passos).';';

		//dd($solicitacao->explode(';',$passos));

		//dd($passos);

		$this->validate($request,$rules);

		$success = $this->requerimento->createRequerimento($request,$passos);

		//dd($success);

		//Enviar mensagem para a view através de sessão unica sem deixar lixo no código
        session()->flash('success',[
            'success'  => $success['success'],
            'messages' => $success['messages'],
            'class'    => $success['class'],
        ]);
		
		return redirect()->route('requerimentos.show', $success['id']);
	}

	public function showForm(){
		//Verificação de permissão
		if(Gate::denies('gestao_requerimento')){
			return redirect()->back();
		}
		//Pega uma coleção com todos os papeis atribuido ao usuário logado
		$roles = auth()->user()->roles;

		$tipos_list = $this->tipos->orderBy('name')->get();

		$roles_list = Role::orderBy('label')->where('name','!=','aluno')->where('name','!=','admin')->get();
		//dd($roles_list);
		return view('dashboard.requerimentos.form',[
			'title' => 'Criar Requerimentos',
			'roles' => $roles,
			'tipos_list' => $tipos_list,
			'roles_list' => $roles_list,
		]);
	}

	public function updateStatus($id, $tipo_id){
		//Verificação de permissão
		if(Gate::denies('gestao_requerimento')){
			return redirect()->back();
		}
		$error = $this->requerimento->mudarStatus($id, $tipo_id);

		//Enviar mensagem para a view através de sessão unica sem deixar lixo no código
		session()->flash('success',[
			'success'  => $error['success'],
			'messages' => $error['messages'],
			'class'    => $error['class'],
		]);

		return redirect()->route('requerimentos.show',['id' => $tipo_id]);
	}

}
