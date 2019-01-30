<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Entities\{User, Solicitacao, Historico, Role, RoleUser,CursoUser,Cursos};
use Auth;
use DB;
use Gate;

class DashboardController extends Controller{

	protected $user;

	public function __construct(User $user){
		$this->middleware('auth');
		$this->user = $user;
	}

	public function index(){
		
		//Pega uma coleção com todos os papeis atribuido ao usuário logado
		$roles = auth()->user()->roles;

		//Recebe o id do usuário logado caso seja aluno
		$id = null;

		//Percorre a coleção e vê se tem o papel aluno para filtrar as informações exibidas no dashboard
		foreach ($roles as $role){
			if($role->name == 'aluno'){
				$id = Auth::User()->id;
			}
		}


        //recebendo todos os requerimentos solicitados
		$sol = new Solicitacao();
		$dados = $sol->list($id);

		$solicitacoesSetor = $sol->listMinhasSolicitacoes();
		//sdd($solicitacoesSetor);
		
		//salvar requerimentos com status = Protocolado
		$protocolados = new Collection();
		$sol = new Solicitacao();
		if(Auth::User()->hasAnyRoles('sra')){
			$protocolados = $sol->where('status_atual',$sol->getIdAcao('Protocolado'))->get();
		}

        //dd($protocolados);

		return view('dashboard.index',[
			'title' 			 => 'Dashboard',
			'roles' 			 => $roles,
			'dados' 			 => $dados,
			'solicitacoesSetor'  => $solicitacoesSetor,
			'protocolados'       => $protocolados,
		]);
	}

	public function listarTodos(){
		//Pega uma coleção com todos os papeis atribuido ao usuário logado
		$roles = auth()->user()->roles;

		$id = null;

		foreach ($roles as $role){
			if($role->name == 'aluno'){
				$id = Auth::User()->id;
			}
		} 

		$sol = new Solicitacao();
		$dados = $sol->list($id);

        //dd($dados);

		return view('dashboard.todos',[
			'title' => 'Dashboard',
			'roles' 	=> $roles,
			'dados' => $dados,
		]);
	}

	public function perfil(){
		//Pega uma coleção com todos os papeis atribuido ao usuário logado
		$roles = auth()->user()->roles;

		return view('dashboard.perfil',[
			'title' => 'Dashboard',
			'roles' 	=> $roles,
		]);
	}

	public function editPerfil(){

		//Pega uma coleção com todos os papeis atribuido ao usuário logado
		$roles = auth()->user()->roles;

		$funcao_list = Role::where('name','!=','aluno')->orderBy('name')->get();
		$curso_list = Cursos::orderBy('name')->get();

		return view('dashboard.users.editPerfil',[
			'title' => 'Usuários',
			'roles' => $roles,
			'funcao_list' => $funcao_list,
			'curso_list' => $curso_list,
		]);

	}

	public function update(Request $request){
		try{
			//início da transação
			DB::beginTransaction();

			if(empty($request->password)){
				//Validando os dados
				$this->validate($request, $this->user->rulesUpdateSemSenha);
			}else{
				//Validando os dados
				$this->validate($request, $this->user->rulesUpdate);
			}
			//Realiza a inserção na tabela user e retorna o ID do usuário cadastrado
			$id = $this->updateUser($request->all());

			//Sucesso!
			DB::commit();

			//Enviar mensagem para a view através de sessão única sem deixar lixo no código
			session()->flash('success',[
				'success'  => true,
				'messages' => 'Atualização realizado com sucesso!',
				'class'    => 'success',
			]);

			return redirect()->route('dashboard.perfil');

		} catch (ValidatorException $e) {
			//Fail, desfaz as alterações no banco de dados
			DB::rollBack();
			return redirect()->route('dashboard.perfil');
		}
	}

	//Função que realiza a inserção dos dados no banco de dados
	protected function updateUser(array $data){

		$user = User::where('id', Auth::User()->id)->first();
		
		if(empty($data['password'])){
			// $user = User::update([
			// 	'name' => $data['name'],
			// 	'email' => $data['email'],
			// 	'username' => $data['username'],
			// ]);
			$user->name = $data['name'];
			$user->email = $data['email'];
			$user->username = $data['username'];
			$user->save();
		}else{
			// $user = User::update([
			// 	'name' => $data['name'],
			// 	'email' => $data['email'],
			// 	'username' => $data['username'],
			// 	'password' => bcrypt($data['password']),
			// ]);
			$user->name = $data['name'];
			$user->email = $data['email'];
			$user->username = $data['username'];
			$user->password = bcrypt($data['password']);
			$user->save();
		}

		return $user->id;

	}

	public function historico($id){
		//Pega uma coleção com todos os papeis atribuido ao usuário logado
		$roles = auth()->user()->roles;

		//Pegar informações do requerimento atual
		$sol = new Solicitacao();

		$requerimento = $sol->historico($id);

		$historico = Historico::with('acoes')->with('roles')->where('solicitacao_id',$id)->orderBy('created_at')->get();

		$parecer = "Processo em andamento!";

		foreach ($historico as $hist) {
			if($hist->acoes->name == 'Cancelado'){
				$parecer = "Requerimento cancelado!";
			}elseif($hist->acoes->name == 'Finalizado'){
				$parecer = "Requerimento Finalizado";
			}
			if(!empty($hist->resposta)){
				$parecer = $hist->resposta;
			}
		}

		return view('dashboard.historico',[
			'title' 		=> 'Histórico',
			'roles' 		=> $roles,
			'requerimento' 	=> $requerimento,
			'historico' 	=> $historico,
			'parecer' 		=> $parecer,
		]);
	}

	public function listUser(){
		//Verificação de permissão
		if(Gate::denies('gestao_user')){
			return redirect()->back();
		}

		//Pega uma coleção com todos os papeis atribuido ao usuário logado
		$roles = auth()->user()->roles;

		//$users = User::with('roles')->orderBy('name')->get();

		$users = User::whereDoesntHave('roles', function ($query) {
			$query->where('name','=','aluno');
		})->orderBy('name')->get();

		//dd($users);

		return view('dashboard.users.index',[
			'title' => 'Usuários',
			'roles' => $roles,
			'users' => $users,
		]);
	}

	//Funções de cadastro de usuário
	public function showFormUser(){
		//Verificação de permissão
		if(Gate::denies('gestao_user')){
			return redirect()->back();
		}

		//Pega uma coleção com todos os papeis atribuido ao usuário logado
		$roles = auth()->user()->roles;

		$funcao_list = Role::where('name','!=','aluno')->orderBy('name')->get();
		$curso_list = Cursos::orderBy('name')->get();

		return view('dashboard.users.form',[
			'title' => 'Usuários',
			'roles' => $roles,
			'funcao_list' => $funcao_list,
			'curso_list' => $curso_list,
		]);
	}

	public function register(Request $request){
		try {

			//início da transação
			DB::beginTransaction();

			//Variável com o papel definido
			$role;
			$local;

			//dd($request->curso);

			//dd(!isset($request->role));

			//Validando os dados
			$this->validate($request, $this->user->rules);

			//Realiza a inserção na tabela user e retorna o ID do usuário cadastrado
			$id = $this->create($request->all());

			//verificar se existe o campo role
			if(!isset($request->role)){
				//Não existe pesquisa na tabela Role por aluno
				$roles = Role::firstOrCreate(['name' => 'aluno']);
				$role = $roles->id;
				$local = 'login';
			}else{
				//Existe pega do formulário o id do campo $request['role']
				$role = $request->role;
				$local = 'dashboard.user';
			}

			//verificar se existe um curso
			if(isset($request->curso)){
				$this->cadastrarCurso($request->curso, $id);

				//dd('dentro do curso');
			}

			//Attribuir o papel 
			$this->cadastrarRole($role,$id);

			//Sucesso!
			DB::commit();

			//Enviar mensagem para a view através de sessão única sem deixar lixo no código
			session()->flash('success',[
				'success'  => true,
				'messages' => 'Cadastro realizado com sucesso!',
				'class'    => 'success',
			]);

			return redirect()->route($local);

		} catch (ValidatorException $e) {
			//Fail, desfaz as alterações no banco de dados
			DB::rollBack();
			return redirect()->route('cadastrar');
		}
	}

    //Função que realiza a inserção dos dados no banco de dados
	protected function create(array $data){
		
		$user = User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'username' => $data['username'],
			'matricula' => $data['matricula'],
			'cpf' => $data['cpf'],
			'password' => bcrypt($data['password']),
		]);

		return $user->id;

	}

	
	protected function cadastrarRole($role, $user){

		return RoleUser::create([
			'role_id' => $role,
			'user_id' => $user,
		]);

	}

	public function cadastrarCurso($data,$id){

		if($data == "*"){
			$cursos = Cursos::get();
			foreach ($cursos as $curso) {
				CursoUser::create([
					'curso_id' => $curso->id,
					'user_id' => $id,
				]); 
			}
			//dd('dentro de vários');
		}else{
			CursoUser::create([
				'curso_id' => (integer)$data,
				'user_id' => $id,
			]); 
			// echo $data;
			// dd('dentro de 1 curso');
		}

	}

	public function destroy($id){
		try {
			
			$user = $this->user::findOrFail($id);
			
			$user->delete();

			//Enviar mensagem para a view através de sessão única sem deixar lixo no código
			session()->flash('success',[
				'success'  => true,
				'messages' => 'Usuário excluído com sucesso!',
				'class'    => 'success',
			]);
			
			return redirect()->route('dashboard.user');
		} catch (\Exception $e) {
			
		}

	}

}
