<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Solicitacao extends Model
{

	protected $table = 'solicitacoes';

	protected $fillable = ['requerimento_id', 'user_id', 'status_atual'];

	protected $paginate = 7;

	public function getFormattedCreatedAtAttribute(){

		$data = date( 'd/m/Y  H:i' , strtotime($this->attributes['created_at']));

		return $data;
	}

	public function getFormattedUpdatedAtAttribute(){

		$data = date( 'd/m/Y  H:i' , strtotime($this->attributes['updated_at']));

		return $data;
	}

	//Dfinido os relacionamentos
	
	//belongs to porque a chave de acoes está dentro da tabela solicitacao
	public function acoes(){
		return $this->belongsTo(Acoes::class,'status_atual','id');
	}

    //belongs to porque a chave de users está dentro da tabela solicitacao
	public function users(){
		return $this->belongsTo(User::class,'user_id','id');
	}

	public function requerimentos(){
		return $this->belongsTo(Requerimento::class,'requerimento_id','id');
	}

	public function helperModel(){
     					  //(relacao, chave estrangeira, primary key)
		return $this->hasOne(HelperModel::class,'solicitacao_id','id');
	}

    //Retorna array com as validação necessárias para os campos do formulário utilizada com $this->validate()
	public function getRules($id){

    	//Selecionar nome da tabela que contem os campos
		$table = $this->getNomeTable($id);

    	//Recebe o nome da tabela
		$table_name = $table->table_name;

    	//Consulta sql que sera executada no banco
		$sql_table = "SELECT table_name,column_name,`TABLE_SCHEMA`, `IS_NULLABLE`, `DATA_TYPE`,`CHARACTER_MAXIMUM_LENGTH`,`COLUMN_KEY` FROM information_schema.columns WHERE table_name = '".$table_name."' and `TABLE_SCHEMA` = 'cleianec_esse'";

		//Variável que recebe o resultado da cosulta - Uma matriz 
		$result = DB::select($sql_table);

		//Array que recebe o nome do result e o tipo de dados
		$validate = [];

		//Foreach que percorre a matriz armazenada no $result
		foreach($result as $campo){
			//variáveis que armazenam os valores de nome da coluna e tipo de dados usadas nos ifs
			//Resetando variáveis
			$column_name = null;
			$data_type = null;
			$is_nullable = null;
			$column_key = null;
			$max = null;
			foreach ($campo as $key => $value) {
				
				// Tratando as validações
				if($key == 'column_name'){
					$column_name = (string)$value;
				}
				if($key == 'DATA_TYPE'){
					$data_type = (string)$value;
				}

				if($key == 'IS_NULLABLE' && $value == 'NO'){
					$is_nullable = 'required';
				}

				if($key == 'COLUMN_KEY' && $value == "UNI"){
					$column_key = "unique:".$table_name;
				}elseif($key == 'COLUMN_KEY' && $value == "MUL"){
					$column_key = '';
				}

				if($key == 'CHARACTER_MAXIMUM_LENGTH' && $value != null){
					$max = "|max:".$value;
				}

				switch($data_type){
					case 'varchar':
					$data_type = 'string';
					break;
					// case 'char':
					// $data_type  = 'numeric';
					// break;
					// case 'int':
					// $data_type  = 'integer';
					break;
					case 'text':
					$data_type = 'string';
					break;
				}
				
			}

			//Atribuição dos atributos ao array campos
			$validate += [$column_name => $data_type.$max.'|'.$is_nullable];
		}

		unset($validate['id']);
		unset($validate['solicitacao_id']);
		unset($validate['anexos']);
		unset($validate['created_at']);
		unset($validate['updated_at']);
		unset($validate['deleted_at']);

		return $validate;
	}

	//Retorna array com campos e tipos para geração do formulário de solicitação com base no id recebido
	public function geraForm($id){
		//Selecionar nome da tabela que contem os campos
		$table = $this->getNomeTable($id);
		
		//verificar se a tabela informada existe
		if ($table != null) {
			//Recebe o nome da tabela
			$table_name = $table->table_name;
			
			//Array que recebe o nome do result e o tipo de dados
			$campos = [];
			$cont = 0;

			//Selecinando os campos da tabela campos_requerimentos
			$a = Requerimento::find($table->id);
			foreach ($a->campos as $value) {
				switch($value->tipo){
					case 'varchar':
					$value->tipo = 'text';
					break;
					// case 'char':
					// $value->tipo = 'number';
					// break;
					// case 'int':
					// $value->tipo = 'number';
					// break;
					case 'text':
					$value->tipo = 'text-area';
					break;
				}
				//Cria um array com um subarray chave=>valor
				//atributo pivot pega os atributos extras que estão na tabela gerada pelo n:n
				$campos[$cont] = [
					'label' => $value->pivot->label, 
					'placeholder' => $value->pivot->placeholder, 
					'tipo' => $value->tipo,
					'name' => $value->pivot->name,
				];
				$cont++;
			}
		}//endif

		//dd($campos);

		return $campos;

	}

	//Função que busca os dados na tabela requerimento
	public function getNomeTable($id){

		return Requerimento::where('tipo_id',$id)->where('status','ativo')->first();

	}

	//Funcão que retorna o id de uma ação através do nome
	public function getIdAcao($name){
		$acao = Acoes::where('name',$name)->first();
		return $acao->id;
	}

	//Funcão que retorna o nome de uma ação através do id
	public function getNameAcao($id){
		$acao = Acoes::where('id',$id)->first();

		return $acao->name;
	}

	//Funcão que retorna o id de uma funcão através do nome
	public function getIdFuncao($name){
		$role = Role::where('name',$name)->orWhere('label',$name)->first();
		return $role->id;
	}

	//inserir dados recebidos do formulário nas tabelas: solicitação, table_name (instanciada no HelperModel) e histórico
	public function create($request){
		try{
			//início da transação
			DB::beginTransaction();

			//Recuperando os dados da tabela requerimento
			$table = $this->getNomeTable($request->id_tipo);

			//Recebe o nome da tabela
			$table_name = $table->table_name;

			$id_user = Auth::User()->id;
			
			//id ação novo
			$id_acao = $this->getIdAcao('Novo');


			//Inserir dados na tabela Solicitação
			$this->requerimento_id = $table->id;
			$this->user_id = $id_user;
			$this->status_atual = $id_acao;
			$solicitacao = $this->save();

			$id_solicitacao = $this->id;

			//Instanciando um model genérico que recebe o nome de uma tabela
			$model = new HelperModel($table_name);

			//executando a inserção no banco na tabela $table_name
			foreach ($request->except('_token', 'id_tipo') as $key => $value) {
				$model->$key = $value;
			}
			$model->solicitacao_id = $id_solicitacao;
			$result = $model->save();
			
			//Inserindo registro na tabela histórico
			$historico = Historico::create([
				'solicitacao_id' => $id_solicitacao,
				'user_id' => $id_user,
				'acao_id' => $id_acao,
			]);

			//campos de retorno
			$query['success'] = true;
			$query['class'] = 'success';
			$query['messages'] = 'Requerimento solicitado com sucesso!';
			$query['id'] = $id_solicitacao;

			//Sucesso!
			DB::commit();

			return $query;

		}catch(\Exception $e){

			//Fail, desfaz as alterações no banco de dados
			DB::rollBack();

			//campos de retorno
			$query['success'] = false;
			$query['class'] = 'danger';
			$query['messages'] = $e->getMessage();
			$query['id'] = null;
			return $query;
		}
	}

	//Retorna os dados para geração do pdf através do id da solicitação
	public function getDadosPdf($id){

		//Fazer um campo para adicinar disciplinas 

		//Consultando a solicitação e todos os relacionamentos através do id recebido
		$solicitacao = $this->with('acoes')->with('requerimentos')->with('users')->where('id',$id)->first();
		
		//instaciando a tabela que contém os dados preenchidos pelo usuário
		$dados = new HelperModel($solicitacao->requerimentos->table_name);
		//dd($dados);

		//Buscando os dados preenchidos pelo usuário
		$tabela = $dados->where('solicitacao_id',$solicitacao->id)->first();
		
		//Selecionando todas as informaçõe do requerimentoe transformando em array e removendo espaço em branco
		$informacoes = $this->explode(';',$solicitacao->requerimentos->informacoes);

		$ultimo_status = Historico::with('acoes')->with('roles')->where('solicitacao_id',$id)->orderBy('created_at','desc')->first();

		$status_atual = $this->getNameAcao($ultimo_status->acao_id);
		
		//montando estrutura de retorno
		$result = [
			'aluno' => $solicitacao->users->name,
			'matricula' => $solicitacao->users->matricula,
			'requerimento' => $solicitacao->requerimentos->tipos->name,
			'cursoDe' =>$tabela->cursoDe->name,
			'cursoPara' => $tabela->cursoPara->name,
			'justificativa' => $tabela->justificativa,
			'anexos' => $tabela->anexos,
			'informacoes' => $informacoes,
			'protocolo' => $this->getProtocolo($solicitacao->id),
			'status_atual' => $status_atual,
		];
		
		return $result;

	}

	//Função para remover um delimitador específico e espaço em branco 
	public function explode($delimitador,$data){

		$dados = null;

		if(strpos($data, $delimitador) !== false){
			$dados = explode("$delimitador", $data,-1);
		}else{
			$dados = explode("$delimitador", $data);
		}
		
		$dados = array_map('trim', $dados);

		return $dados;
	}

	//Função que filtra as informações apresentadas para o aluno no dashboard.index
	public function list($id = null){

		$dados = null;

		//dd($id);
		
		if($id != null){
			$dados = $this->where('user_id',$id)->paginate($this->paginate);
		}else{
			$dados = $this->where('status_atual','!=',$this->getIdAcao('Cancelado'))->where('status_atual','!=',$this->getIdAcao('Novo'))->orderBy('created_at','desc')->get();
		}

		//dd($dados);

		return $dados;

	}

	//Função que filtra as informações apresentadas no dashboard.index
	public function listProtocolo(){

		$dados = $this->where('status_atual', $this->getIdAcao('Novo'))->orderBy('created_at','desc')->get();

		return $dados;

	}

	//Função que rotorna o protocolo para a view. Formato: prefixo+solicitacao_id
	public function getProtocolo($id){
		return '2248'.$id;
	}

	public function historico($id){
		$solicitacao = $this->with('acoes')->with('requerimentos')->with('users')->where('id',$id)->first();

		//instaciando a tabela que contém os dados preenchidos pelo usuário
		$dados = new HelperModel($solicitacao->requerimentos->table_name);
		//dd($dados);

		//Buscando os dados preenchidos pelo usuário
		$tabela = $dados->where('solicitacao_id',$solicitacao->id)->first();
		
		//Selecionando todas as informaçõe do requerimentoe transformando em array e removendo espaço em branco
		$passos = $this->explode(';',$solicitacao->requerimentos->passos);
		
		//montando estrutura de retorno
		$result = [
			'aluno' => $solicitacao->users->name,
			'requerimento' => $solicitacao->requerimentos->tipos->name,
			'cursoDe' =>$tabela->cursoDe->name,
			'cursoPara' => $tabela->cursoPara->name,
			'protocolo' => $this->getProtocolo($solicitacao->id),
			'passos' => $passos,
			'status_atual' => $solicitacao->acoes->name,
			'data' => $solicitacao->formatted_created_at,
			'update' => $solicitacao->formatted_updated_at,
			'parecer' => 'Processo em andamento.',
		];
		
		//dd($result);
		return $result;
	}

	//Função que define solicitação como cancelada ou protocolada
	public function protocolarCancelar($id, $status){

		$solicitacao = $this->where('id',$id)->where('status_atual', $this->getIdAcao('Novo'))->first();


			//$historico
		$historico = Historico::create([
			'solicitacao_id' => $id,
			'user_id' => $solicitacao->user_id,
			'acao_id' => $this->getIdAcao($status),
			'valor'   => $this->getIdFuncao('atendimento_sra'),
		]);

		$solicitacao->status_atual = $this->getIdAcao($status);
		$solicitacao->save();

		//campos de retorno
		$query['success'] = true;
		$query['class'] = 'success';
		$query['messages'] = 'Requerimento '.$status.' com sucesso!';
		


		return $query;

	}

	//Função que define solicitação como cancelada ou protocolada
	public function realizarTramite($data){

		$solicitacao = Historico::where('solicitacao_id',$data->solicitacao)->orderBy('created_at','desc')->first();

		//dd($data->encaminhar);
		$status_atual = $this->getIdFuncao($data->encaminhar);

		//dd($status_atual);
		//$historico
		$historico = Historico::create([
			'solicitacao_id' => $data->solicitacao,
			'user_id' => $solicitacao->user_id,
			'acao_id' => $this->getIdAcao('Tramite'),
			'valor'   => $this->getIdFuncao($data->encaminhar),
		]);

		$historico2 = Historico::create([
			'solicitacao_id' => $data->solicitacao,
			'user_id' => $solicitacao->user_id,
			'acao_id' => $this->getIdAcao('Em Análise'),
			'valor'   => $this->getIdFuncao($data->encaminhar),
			
		]);
		
		$sol = $this->where('id',$data->solicitacao)->first();
		$sol->status_atual = $this->getIdAcao('Em Análise');
		$sol->save();

		//campos de retorno
		$query['success'] = true;
		$query['class'] = 'success';
		$query['messages'] = 'Tramite realizado com sucesso!';



		return $query;

	}

	//Retorno de dados para trâmite
	public function getDadosTramite($id){

		//Fazer um campo para adicinar disciplinas 

		//Consultando a solicitação e todos os relacionamentos através do id recebido
		$solicitacao = $this->with('acoes')->with('requerimentos')->with('users')->where('id',$id)->first();

		//instaciando a tabela que contém os dados preenchidos pelo usuário
		$dados = new HelperModel($solicitacao->requerimentos->table_name);
		//dd($dados);

		//Buscando os dados preenchidos pelo usuário
		$tabela = $dados->where('solicitacao_id',$solicitacao->id)->first();

		//Selecionando todas as informaçõe do requerimentoe transformando em array e removendo espaço em branco
		$passos = $this->explode(';',$solicitacao->requerimentos->passos);

		$ultimo_status = Historico::with('acoes')->with('roles')->where('solicitacao_id',$id)->orderBy('created_at','desc')->first();

		$status_atual = $this->getNameAcao($ultimo_status->acao_id);

		//montando estrutura de retorno
		$result = [
			'aluno' => $solicitacao->users->name,
			'matricula' => $solicitacao->users->matricula,
			'requerimento' => $solicitacao->requerimentos->tipos->name,
			'cursoDe' =>$tabela->cursoDe->name,
			'cursoPara' => $tabela->cursoPara->name,
			'justificativa' => $tabela->justificativa,
			'anexos' => $tabela->anexos,
			'passos' => $passos,
			'protocolo' => $this->getProtocolo($solicitacao->id),
			'data_solicitacao' => $solicitacao->formatted_created_at,
			'id_solicitacao' => $id,
			'status_atual' => $status_atual,
		];

		return $result;

	}

	//listas solicitações relacionadas aos setores que estão vinculados a todos os cursos
	public function listMinhasSolicitacoes(){
		//Pegar todas as funções atribuídas ao usuário
		$roles = Auth::User()->roles;

		//variáveis
		$id_roles = [];
		$result = [];
		$cont = 0;

		foreach ($roles as $role) {
			$id_roles += [$role->id];
		}

		//Retorna a quantidade de cursos vinculadas ao usuário
		// $qtd_cursos = CursoUser::where('user_id',Auth::User()->id)->get();

		// if($qtd_cursos->count() > 1){
		// 	foreach ($id_roles as $id) {
		// 		$historico = Historico::with('acoes')->with('roles')->where('valor',$id)->where('acao_id',$this->getIdAcao('Em Análise'))->orderBy('created_at','desc')->get();
		// 		var_dump($historico);
		// 	}
		// }

		//Selecionar todas solicitações que possuem status_ atual = Em análise
		$solicitacoes = $this->where('status_atual',$this->getIdAcao('Em Análise'))->orWhere('status_atual',$this->getIdAcao('Resposta'))->get();

		//fazer for com resposta de solicitações
		foreach ($solicitacoes as $solicitacao) {
			$historico = Historico::where('solicitacao_id',$solicitacao->id)->orderBy('id','desc')->first();
			foreach ($id_roles as $id) {
				//var_dump($historico->acao_id == $this->getIdAcao('Resposta'));
				if(($historico->acao_id == $this->getIdAcao('Em Análise')
					|| $historico->acao_id == $this->getIdAcao('Resposta'))
					&& $historico->valor == $id){

					// echo 'em analise'.($historico->acao_id == $this->getIdAcao('Em Análise')).'<br>';
					// echo 'resposta'.($historico->acao_id == $this->getIdAcao('Resposta')).'<br>';
					// echo 'id'.($historico->valor == $id).'<br><hr>';

					$result[$cont] = $this->getDadosTramite($solicitacao->id);
			}
		}
		$cont++;

	}

	//Retorna a quantidade de cursos vinculadas ao usuário
	$qtd_cursos = CursoUser::where('user_id',Auth::User()->id)->get();
	$cont = 0;
	//var_dump($qtd_cursos->count() == 1);
	if($qtd_cursos->count() == 1){
		$cursos = CursoUser::where('user_id',Auth::User()->id)->first();
		//dd($cursos);
		$cursos = $cursos->curso_id;
		foreach ($result as $curso) {
				// echo $curso['cursoPara'].'<br>';
				// echo $cursos.'<br>';

			if($curso['cursoPara'] == $cursos){
				$result[$cont] = $this->getDadosTramite($solicitacao->id);
			}
			$cont++;

		}
	}

	return $result;
}

public function insereResposta($data){

	$solicitacao = Historico::where('solicitacao_id',$data->solicitacao)->orderBy('created_at','desc')->first();

		//dd($solicitacao);
	$status_atual = $this->getIdAcao($data->acao);

		//dd($status_atual);
		//$historico
	$historico = Historico::create([
		'solicitacao_id' => $data->solicitacao,
		'user_id' => $solicitacao->user_id,
		'acao_id' => $this->getIdAcao($data->acao),
		'valor'   => $solicitacao->valor,
		'resposta'   => $data->resposta,
	]);

	if($data->finalizado == 'Sim'){
		$historico2 = Historico::create([
			'solicitacao_id' => $data->solicitacao,
			'user_id' => $solicitacao->user_id,
			'acao_id' => $this->getIdAcao('Finalizado'),
			'valor'   => $solicitacao->valor,
		]);
		$status_atual =$this->getIdAcao('Finalizado');
	}

	$sol = $this->where('id',$data->solicitacao)->first();
	$sol->status_atual = $status_atual;
	$sol->save();

		//campos de retorno
	$query['success'] = true;
	$query['class'] = 'success';
	$query['messages'] = 'Resposta inserida com sucesso!';



	return $query;
}


}
