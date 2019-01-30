<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use App\Entities\User;

class LoginController extends Controller
{

	/*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    //Contrutor para verificar se o usuário ja está logado
    public function __construct(){
        $this->middleware('guest')->except('logout');
    }
    
   	//Exibir a view com formulário de login	
	public function index(){
		return view('auth.login',[
            'title' => 'Login',
        ]);
	}

}
