<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Permission;
use Gate;

class PermissionController extends Controller
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

		$permissions = Permission::orderBy('name')->get();

		return view('dashboard.permissions.index',[
			'title' => 'Permissões',
			'roles' => $roles,
			'permissions' => $permissions,
		]);
	}

	
}
