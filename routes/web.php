<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
|--------------------------------------------------------------------------
| Painel Routes
|--------------------------------------------------------------------------
|
| Rotas da página pública do sistema - Não reque autenticação
|
*/

Route::get('/', ['as' => 'painel.index', 'uses' => 'PainelController@index']);

Route::get('sobre', ['as' => 'painel.sobre', 'uses' => 'PainelController@sobre']);

/*
|--------------------------------------------------------------------------
|Authentication Routes
|--------------------------------------------------------------------------
|
| Rotas para autenticação do usuário
|
*/
// Authentication Routes...
Route::get('login',   ['as' =>'login', 'uses' => 'Auth\LoginController@index' ]);
Route::post('login',  ['uses' => 'Auth\LoginController@login' ]);
Route::post('logout', ['as' =>'logout', 'uses' => 'Auth\LoginController@logout']);


/*// Password Reset Routes...
Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'ResetPasswordController@reset');*/

/*
|--------------------------------------------------------------------------
|Resgister Routes
|--------------------------------------------------------------------------
|
| Rotas para registrar o usuário
|
*/

Route::resource('register', 'Auth\RegisterController');

// Registration Routes...
Route::get('cadastrar', ['as' => 'cadastrar', 'uses' => 'Auth\RegisterController@index'] );
Route::post('cadastrar',['uses' =>'Auth\RegisterController@register']);

/*
|--------------------------------------------------------------------------
|Dashboard Routes
|--------------------------------------------------------------------------
|
| Rotas para usuário autenticado
|
*/

//Route::resource('dashboard', 'DashboardController');
Route::get('dashboard',['as' => 'dashboard.index', 'uses' => 'DashboardController@index']);

Route::get('dashboard/listar',['as' => 'dashboard.todos', 'uses' => 'DashboardController@listarTodos']);

Route::get('dashboard/{id}/historico',['as' => 'dashboard.historico', 'uses' => 'DashboardController@historico']);

Route::get('dashboard/perfil',['as' => 'dashboard.perfil', 'uses' => 'DashboardController@perfil']);

Route::get('dashboard/perfil/{id}/edit',['as' => 'dashboard.editPerfil', 'uses' => 'DashboardController@editPerfil']);

Route::post('dashboard/perfil/',['as' => 'dashboard.updatePerfil', 'uses' => 'DashboardController@update']);

Route::post('dashboard/update',['as' => 'dashboard.update', 'uses' => 'DashboardController@update']);

Route::get('dashboard/user/novo',['as' => 'dashboard.novo','uses' =>'DashboardController@showFormUser']);

/*
|--------------------------------------------------------------------------
|User Routes
|--------------------------------------------------------------------------
|
| Rotas para usuário autenticado
|
*/

Route::get('dashboard/user',['as' => 'dashboard.user','uses' =>'DashboardController@listUser']);

Route::post('dashboard/user/novo',['as' => 'dashboard.register','uses' =>'DashboardController@register']);
Route::get('dashboard/{id}/editar', ['as' => 'user.editar', 'uses' => 'UserController@editar']);

Route::post('dashboard/editar', ['as' => 'user.update', 'uses' => 'UserController@update']);

Route::get('dashboard/{id}/user',['as' => 'dashboard.destroy','uses' =>'DashboardController@destroy']);

/*
|--------------------------------------------------------------------------
|Role Routes
|--------------------------------------------------------------------------
|
| Rotas para editar papéis no sistema - necessita autenticação
|
*/

Route::get('funcoes', ['as' => 'roles.index', 'uses' => 'RoleController@index']);
Route::get('funcoes/novo', ['as' => 'roles.novo', 'uses' => 'RoleController@showForm']);
Route::get('funcoes/{id}/editar', ['as' => 'roles.editar', 'uses' => 'RoleController@editar']);
Route::post('funcoes/editar', ['as' => 'roles.update', 'uses' => 'RoleController@update']);
Route::post('funcoes/store', ['as' => 'roles.store', 'uses' => 'RoleController@store']);

/*
|--------------------------------------------------------------------------
|Requerimentos Routes
|--------------------------------------------------------------------------
|
| Rotas para cadastrar requerimentos no sistema - necessita autenticação
|
*/

Route::resource('requerimentos', 'RequerimentoController');
//Route::get('requerimentos/detalhes',['as' => 'requerimentos.detalhes', 'uses' => 'RequerimentoController@detalhes']);
Route::get('requerimento/novo', ['as' => 'requerimentos.novo', 'uses' => 'RequerimentoController@showForm']);

Route::get('requerimentos/updateStatus/{id}/{tipo_id}', ['as' => 'requerimentos.updateStatus', 'uses' => 'RequerimentoController@updateStatus']);

Route::get('requerimentos/{id}/show',['as' => 'requerimentos.show', 'uses' => 'RequerimentoController@show']);

Route::get('requerimentos/{id}/{table}/detalhes',['as' => 'requerimentos.detalhes', 'uses' => 'RequerimentoController@detalhes']);

/*
|--------------------------------------------------------------------------
|Solicitações Routes
|--------------------------------------------------------------------------
|
| Rotas para solicitar requerimentos no sistema - necessita autenticação
|
*/

//Route::resource('solicitacoes', 'SolicitacaoController');
Route::get('solicitacoes/showForm', ['as'=>'solicitacoes.showForm', 'uses' =>'SolicitacaoController@showForm']);

Route::post('solicitacoes/cadastrar', ['as'=>'solicitacoes.cadastrar', 'uses' =>'SolicitacaoController@cadastrar']);

Route::get('solicitacoes', ['as'=>'solicitacoes.index', 'uses' =>'SolicitacaoController@index']);

Route::get('solicitacoes/{id}/pdf',['as' => 'solicitacoes.getPdf', 'uses' => 'SolicitacaoController@getPdf']);

/*
|--------------------------------------------------------------------------
|Tipos Routes
|--------------------------------------------------------------------------
|
| Rotas para criar tipos de requerimentos no sistema - necessita autenticação
|
*/

Route::resource('tipos', 'TiposController');

/*
|--------------------------------------------------------------------------
|Permissões Routes
|--------------------------------------------------------------------------
|
| Rotas para vizualizar permissões do sistema - necessita autenticação
|
*/

Route::get('permissoes', ['as' => 'permission.index', 'uses' => 'PermissionController@index']);

/*
|--------------------------------------------------------------------------
|Protocolo Routes
|--------------------------------------------------------------------------
|
| Rotas para protocolar requerimentos no sistema - necessita autenticação
|
*/

Route::get('protocolo', ['as' => 'protocolo.index', 'uses' => 'ProtocoloController@index']);

Route::get('protocolo/{id}/cancelar', ['as' => 'protocolo.cancelar', 'uses' => 'ProtocoloController@cancelar']);

Route::get('protocolo/{id}/view',['as' => 'protocolo.verSolicitacao', 'uses' => 'ProtocoloController@verSolicitacao']);
Route::get('protocolo/{id}/protocolar',['as' => 'protocolo.protocolar', 'uses' => 'ProtocoloController@protocolar']);

/*
|--------------------------------------------------------------------------
|Tramite Routes
|--------------------------------------------------------------------------
|
| Rotas para tramite de requerimentos no sistema - necessita autenticação
|
*/

Route::get('tramite/{id}', ['as' => 'tramite.index', 'uses' => 'TramiteController@index']);

Route::post('tramite/enviar', ['as' => 'tramite.enviar', 'uses' => 'TramiteController@tramite']);

Route::get('tramite/{id}/resposta', ['as' => 'tramite.resposta', 'uses' => 'TramiteController@resposta']);
Route::post('tramite/resposta', ['as' => 'tramite.responder', 'uses' => 'TramiteController@responder']);
