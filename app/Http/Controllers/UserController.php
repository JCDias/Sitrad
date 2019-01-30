<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\{Role,Permission, RoleUser, User};
use Gate;

class UserController extends Controller
{
    public function __construct(){
		$this->middleware('auth');
	}

	public function editar($id){

		//Verificação de permissão
		if(Gate::denies('gestao_user')){
			return redirect()->back();
		}
		//Pega uma coleção com todos os papeis atribuido ao usuário logado
		$roles = auth()->user()->roles;

		//pegar as funções que já estõ atribuídas e definir como selected
		$funcoes = [];
		$cont = 0;

		//recuperando as fucções do uisuario selecionado
		$funcoes_existentes = RoleUser::where('user_id',$id)->get();

		//dd($funcoes_existentes);

		$nome_user = User::where('id',$id)->first();

		$nome_user = $nome_user->name;

		//dd($nome_funcao);

		//recuperando as permissões do usuário logado
		$todas_funcoes = Role::orderBy('name')->get();


		if(count($funcoes_existentes) == 0){
			
			//percorrendo as funções
			foreach ($todas_funcoes as $funcao) {
				$funcoes[$cont] = ['atributo' => '', 'id' => $funcao->id, 'name' => $funcao->name];
				$cont++;
			}
		}else{

		//percorrendo as funções
			foreach ($todas_funcoes as $funcao) {
				foreach ($funcoes_existentes as $funcao_existente) {
					if($funcao_existente->role_id == $funcao->id){
						$funcoes[$cont] = ['atributo' => 'selected', 'id' => $funcao->id, 'name' => $funcao->name];
						break;
					}else{
						$funcoes[$cont] = ['atributo' => '', 'id' => $funcao->id, 'name' => $funcao->name];
					}
				}
				$cont++;	
			}
		}

		//dd($permissoes);

		return view('dashboard.users.edit',[
			'title' 		=> 'Funções',
			'roles' 		=> $roles,
			'funcoes' 		=> $funcoes,
			'nome_user' 	=> $nome_user,
			'user' 			=> $id,
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

		
		return redirect()->route('dashboard.user');
	}

	public function inserirPermissoes($data){

		//id da função
		$user = $data['user'];

		//Selecionar todas as funções relacionadas ao usuário cadastradas na tabela role_user
		$roles = RoleUser::where('user_id', $user)->get();

		//dd($roles);

		//Variável que contém os dados de retorno
		$query = [];

		//Variáveis
		$roles_array = [];
		$cont = 0;
		$result = null;

		//Convertendo resposta da consulta em um array com os ids
		foreach ($roles as $role) {
			$roles_array[$cont] = (string)$role->role_id;
			$cont++;
		}

		//campos de retorno
		$query['success'] = true;
		$query['class'] = 'success';
		$query['messages'] = 'Funções alteradas com sucesso!';

		//Remover funções
		$result = array_diff($roles_array,$data['funcoes']);
		//dd($result);
		$this->editPermission($result,$user);

		//Adicionar permissões
		$result = array_diff($data['funcoes'],$roles_array);
		$this->editPermission($result,$user);
		return $query;
	}

	//função que realiza a inserção ou remoção das permissões para a função
	//se existir remove se não existir adiciona
	public function editPermission($result,$user){

		foreach ($result as $id_funcao) {
			$qtd = RoleUser::where('user_id',$user)->where('role_id',$id_funcao)->get();
			var_dump($qtd->count());
			if($qtd->count() == 1){
				//echo 'Funcao id ='.$id_funcao.' removida <br>';
				RoleUser::where('user_id',$user)->where('role_id',$id_funcao)->delete();
			}else{
				//echo 'Funcao id ='.$id_funcao.' adicionada <br>';
				RoleUser::create([
					'user_id' 	=> $user,
					'role_id' 	=> $id_funcao,
				]);
			}
		}
	}
}
