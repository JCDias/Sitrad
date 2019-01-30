<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\{Role,Permission, PermissionRole};
use Gate;

class RoleController extends Controller
{

	public function __construct(){
		$this->middleware('auth');
	}


	public function index(){

		//Verificação de permissão
		if(Gate::denies('gestao_user')){
			return redirect()->back();
		}
		//Pega uma coleção com todos os papeis atribuido ao usuário logado
		$roles = auth()->user()->roles;

		$funcoes = Role::with('permissions')->orderBy('name')->get();

		return view('dashboard.roles.index',[
			'title' 	=> 'Funções',
			'roles' 	=> $roles,
			'funcoes' 	=> $funcoes,
		]);
	}

	public function showForm(){

		//Verificação de permissão
		if(Gate::denies('gestao_user')){
			return redirect()->back();
		}
		//Pega uma coleção com todos os papeis atribuido ao usuário logado
		$roles = auth()->user()->roles;

		return view('dashboard.roles.form',[
			'title' 	=> 'Criar nova função',
			'roles' 	=> $roles,
		]);
	}

	public function store(Request $request){

		$rules = [
			'name' => 'required|string|min:3',
			'label' => 'required|string|min:6',
		];

		$messages = [
			'name.required' => 'O campo nome da função é obrigatório',
			'name.min' => 'O campo nome da função deve conter no mínimo 3 caracteres',
			'label.required' => 'O campo descrição da função é obrigatório',
			'label.min' => 'O campo descrição da função deve conter no mínimo 6 caracteres',
		];

		$this->validate($request,$rules,$messages);

		$id = Role::create([
			'name'  => $request->name,
			'label' => $request->label,
		]);

		return redirect()->route('roles.editar',$id);

	}

	public function editar($id){

		//Verificação de permissão
		if(Gate::denies('gestao_user')){
			return redirect()->back();
		}
		//Pega uma coleção com todos os papeis atribuido ao usuário logado
		$roles = auth()->user()->roles;

		//pegar as funções que já estõ atribuídas e definir como selected
		$permissoes = [];
		$cont = 0;

		//recuperando as permissões do usuário logado
		$permissoes_existentes = PermissionRole::where('role_id',$id)->get();

		$nome_funcao = Role::where('id',$id)->first();

		$nome_funcao = $nome_funcao->label;

		//recuperando as permissões do usuário logado
		$todas_permissoes = Permission::orderBy('name')->get();


		if(count($permissoes_existentes) == 0){
			
			//percorrendo as funções
			foreach ($todas_permissoes as $permission) {
				$permissoes[$cont] = ['atributo' => '', 'id' => $permission->id, 'name' => $permission->name];
				$cont++;
			}
		}else{

		//percorrendo as funções
			foreach ($todas_permissoes as $permission) {
				foreach ($permissoes_existentes as $permissao_existente) {
					if($permissao_existente->permission_id == $permission->id){
						$permissoes[$cont] = ['atributo' => 'selected', 'id' => $permission->id, 'name' => $permission->name];
						break;
					}else{
						$permissoes[$cont] = ['atributo' => '', 'id' => $permission->id, 'name' => $permission->name];
					}
				}
				$cont++;	
			}
		}

		//dd($permissoes);

		return view('dashboard.roles.edit',[
			'title' 		=> 'Funções',
			'roles' 		=> $roles,
			'permissoes' 	=> $permissoes,
			'nome_funcao' 	=> $nome_funcao,
			'role' 			=> $id,
		]);
	}

	public function update(Request $request){

		//Verificação de permissão
		if(Gate::denies('gestao_user')){
			return redirect()->back();
		}
		//Pega uma coleção com todos os papeis atribuido ao usuário logado
		$roles = auth()->user()->roles;

		$retorno = $this->inserirPermissoes($request->all());

		//Enviar mensagem para a view através de sessão única sem deixar lixo no código
		session()->flash('success',[
			'success'  => $retorno['success'],
			'messages' => $retorno['messages'],
			'class'    => $retorno['class'],
		]);

		return redirect()->route('roles.index');
	}

	public function inserirPermissoes($data){

		//id da função
		$role = $data['role'];

		//Selecionar todas as permissões relacionadas à funçãocadastradas na tabela permission_role
		$perms = PermissionRole::where('role_id', $role)->get();

		//Variável que contém os dados de retorno
		$query = [];

		//Variáveis
		$permissoes = [];
		$cont = 0;
		$result = null;

		//Convertendo resposta da consulta em um array com os ids
		foreach ($perms as $perm) {
			$permissoes[$cont] = (string)$perm->permission_id;
			$cont++;
		}

		//campos de retorno
		$query['success'] = true;
		$query['class'] = 'success';
		$query['messages'] = 'Permissões alteradas com sucesso!';

		/*//verificando o tamanho do array para retornar a diferença entre os arrays
		if(count($data['permissoes']) > count($permissoes)){
			$result = array_diff($data['permissoes'],$permissoes);
			$this->editPermission($result,$role);
			return $query;
		}elseif(count($data['permissoes']) < count($permissoes)){
			$result = array_diff($permissoes,$data['permissoes']);
			$this->editPermission($result,$role);
			return $query;
		}else{
			$result = array_diff($permissoes,$data['permissoes']);
			$this->editPermission($result,$role);
			$result = array_diff($data['permissoes'],$permissoes);
			$this->editPermission($result,$role);
			return $query;
		}*/

		//Remover permissões
		$result = array_diff($permissoes,$data['permissoes']);
		$this->editPermission($result,$role);

		//Adicionar permissões
		$result = array_diff($data['permissoes'],$permissoes);
		$this->editPermission($result,$role);
		return $query;
	}

	//função que realiza a inserção ou remoção das permissões para a função
	//se existir remove se não existir adiciona
	public function editPermission($result,$role){

		foreach ($result as $id_permission) {
			$qtd = PermissionRole::where('role_id',$role)->where('permission_id',$id_permission)->get();

			if($qtd->count() == 1){
				//echo 'Permissão id ='.$id_permission.' removida <br>';
				PermissionRole::where('role_id',$role)->where('permission_id',$id_permission)->delete();
			}else{
				//echo 'Permissão id ='.$id_permission.' adicionada <br>';
				PermissionRole::create([
					'role_id' 		=> $role,
					'permission_id' => $id_permission,
				]);
			}
		}
	}
}
