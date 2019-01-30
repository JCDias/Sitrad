<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\{User, RoleUser, Role};
use DB;

class RegisterController extends Controller
{

	protected $user;
	
	public function __construct(User $user)
	{
		$this->middleware('guest');
		$this->user  = $user;
	}

	public function index(){
		return view('auth.register',[
			'title' => 'Cadastrar',
		]);
	}

	public function register(Request $request){
		try {

			//início da transação
			DB::beginTransaction();

			//Variável com o papel definido
			$role;
			$local;

			//Validando os dados
			$this->validate($request, $this->user->rules);

			//Realiza a inserção na tabela user e retorna o ID do usuário cadastrado
			$id = $this->create($request->all());

			//verificar se existe o campo role
			if(!array_key_exists('role', $request)){
				//Não existe pesquisa na tabela Role por aluno
				$roles = Role::firstOrCreate(['name' => 'aluno']);
				$role = $roles->id;
				$local = 'login';
			}else{
				//Existe pega do formulário o id do campo $request['role']
				$role = $request['role'];
				$local = 'dashboard.user';
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

}
