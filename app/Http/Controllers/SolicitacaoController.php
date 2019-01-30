<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\{Tipos,Solicitacao,Cursos};
use PDF;
use Gate;

class SolicitacaoController extends Controller
{	
	
	private $tipos;
	private $solicitacao;
	private $cursos;

	public function __construct(Tipos $tipos, Solicitacao $solicitacao, Cursos $cursos){
		$this->middleware('auth');

		$this->tipos = $tipos;
		$this->solicitacao = $solicitacao;
		$this->cursos = $cursos;
	}

	public function index(){
		//Verificação de permissão
		if(Gate::denies('solicitar_requerimento')){
			return redirect()->back();
		}
		//Pega uma coleção com todos os papeis atribuido ao usuário logado
		$roles = auth()->user()->roles;

		$tipos_list = $this->tipos->selectBoxList();

		return view('dashboard.solicitacoes.index',[
			'title' 	 => 'Solicitar Requerimento',
			'roles' 	 => $roles,
			'tipos_list' => $tipos_list,
		]);
	}

	public function showForm(Request $request){
		if(Gate::denies('solicitar_requerimento')){
			return redirect()->back();
		}
		//Pega uma coleção com todos os papeis atribuido ao usuário logado
		$roles = auth()->user()->roles;

		//Chama a função dentro do model solicitação que retorna um array com os campos do requerimento
		$campos = $this->solicitacao->geraForm($request->tipo);

		//dd($campos);

		if(empty($campos)){
			return redirect()->route('solicitacoes.index');
		}else{

			$cursos_list = $this->cursos->selectBoxList();

			return view('dashboard.solicitacoes.showForm',[
				'title'  	  => 'Solicitar Requerimento',
				'roles'  	  => $roles,
				'campos' 	  => $campos,
				'id' 		  => $request->tipo,
				'cursos_list' => $cursos_list,
			]);
		}
	}

	public function cadastrar(Request $request){

		//dd($request->all());
		if(Gate::denies('solicitar_requerimento')){
			return redirect()->back();
		}

		//dd($request->all());
		//Pega uma coleção com todos os papeis atribuido ao usuário logado
		$roles = auth()->user()->roles;

		$rules = $this->solicitacao->getRules($request->id_tipo);
		//dd($rules);
		$this->validate($request,$rules);

		$success = $this->solicitacao->create($request); 

		//Enviar mensagem para a view através de sessão unica sem deixar lixo no código
        session()->flash('success',[
            'success'  => $success['success'],
            'messages' => $success['messages'],
            'class'    => $success['class'],
        ]); 

        /*//Enviar mensagem para a view através de sessão unica sem deixar lixo no código
        session()->flash('success',[
            'success'  => true,
            'messages' => 'Solicitação realizada com sucesso!',
            'class'    => 'success',
        ]);*/

		return view('dashboard.solicitacoes.print',[
			'title' => 'Imprimir Requerimento',
			'roles' => $roles,
			'id'    => $success['id'],
		]);
	}

	//gera um pdf com os dados de uma solicitação atraves do id da solicitação
	public function getPdf($id){

		$sol = new Solicitacao();

		$data = $sol->getDadosPdf($id);

		$pdf = PDF::loadView('dashboard.pdf.index',['data' => $data]);
		$pdf->stream('Requerimento.pdf');

	}

}
