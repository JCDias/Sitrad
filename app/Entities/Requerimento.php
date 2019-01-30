<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
use Exception;

class Requerimento extends Model
{
	protected $fillable = ['tipo_id','user_id','table_name','status','passos','informacoes'];

    //Definindo relacionamentos
	public function solicitacao(){
		return $this->hasMany(Solicitacao::class,'requerimento_id','id');
	}

    //belongs to porque a chave do tipo está dentro da tabela requerimento
	public function tipos(){
		return $this->belongsTo(Tipos::class,'tipo_id','id'); 
	}

	//Método de relacionamento N para N entre Requerimentos e campos
	public function campos(){
		return $this->belongsToMany(Campos::class,'campos_requerimentos','requerimento_id', 'campo_id')->withPivot(['label','placeholder','tamanho','name']);
	}

    //belongs to porque a chave do user está dentro da tabela requerimento
	public function user(){
		return $this->belongsTo(User::class);
	}

    //Função que faz o tratamento dos requerimentos ativos e inativos
	public function mudarStatus($id, $tipo_id){
		try{
    		//início da transação
			DB::beginTransaction();

			//Variável que contém os dados de retorno
			$query = [];

			//Instanciando um novo objeto do tipo Requerimento para ser utilizado nas operações com o banco
			$requerimento = new Requerimento;

    		//Recuparando os dados do requerimento selecionado pelo id e tipo
			$status = $requerimento::where('id',$id)->where('tipo_id',$tipo_id)->first();

			//Verificando se o status do requerimento selecionado é ativo para transformar em inativo
			if($status->status == 'ativo'){
				//Esexutando o update
				$requerimento->where('id', $id)->update(['status' => 'inativo']);
				
				//campos de retorno
				$query['success'] = true;
				$query['class'] = 'success';
				$query['messages'] = 'O requerimento localizado na tabela: '.$status->table_name.' foi inativado com sucesso!';
			}else{
				
				$qtd = $requerimento->where('status', 'ativo')->where('tipo_id', $tipo_id)->count();

				if($qtd == 0){
					//Esexutando o update
					$requerimento->where('id', $id)->update(['status' => 'ativo']);
					
					//campos de retorno
					$query['success'] = true;
					$query['class'] = 'success';
					$query['messages'] = 'O requerimento localizado na tabela: '.$status->table_name.' foi ativado com sucesso!';
				}else{
					//Recuperando o nome da tabela que contem o requerimento ativo
					$ativo = $requerimento->where('status', 'ativo')->where('tipo_id', $tipo_id)->first();
					
					//campos de retorno
					$query['success'] = true;
					$query['class'] = 'warning';
					$query['messages'] = 'Não é possível definir dois requerimentos como ativos. Atualmente o requerimento da tabela: '.$ativo->table_name.' está definido como ativo.';
				}
			}

    		//Sucesso!
			DB::commit();

			return $query;

		} catch(\Exception $e) {
    		//Fail, desfaz as alterações no banco de dados
			DB::rollBack();

			//campos de retorno
			$query['success'] = true;
			$query['class'] = 'danger';
			$query['messages'] = $e->getMessage();
			return $query;
		}

	}

	//Função que insere os dados da tela criar requerimento nas tabelas
	//requerimento
	//campos_requerimentos
	//e faz um create table com o atributo table_name
	public function createRequerimento($request,$passos){
		try{
			//início da transação
			DB::beginTransaction();
			
			//Id do usuário logado
			$user_id = Auth::User()->id;

			//realizar inserção na tabela requerimento

			//Variável que armazena o id do requerimento que foi criado
			$id_requerimento = null;
			$table_name = $this->nomeTable($request->tipo);

			//Array com dados utilizado na função create de requerimentos
			$data = [
				'tipo_id' => (int)$request->tipo,
				'user_id' => $user_id,
				'table_name' => $table_name,
				'status' => 'inativo',
				'passos' => $passos,
				'informacoes' => $request->informacoes,
			];


			//realização da inserção na tabela
			$requerimento = Requerimento::create($data);

			$id_requerimento = $requerimento->id;

			//Tamanho do array com campos dinamicos
			$max = sizeof($request->label);

			//realizar inserção na tabela campos_requerimento
			for ($i=0; $i < $max; $i++) { 
				//Instanciando o helper model para inserir os dados na tabela campos_requerimentos
				$model = new HelperModel('campos_requerimentos');

				$model->requerimento_id = $id_requerimento;
				$model->campo_id = $this->getIdCampo($request->tipo_dado[$i]);
				$model->name = $this->nomeCampo($request->label[$i]);
				$model->label = $request->label[$i];
				$model->placeholder = $request->placeholder[$i];
				if($request->tipo_dado[$i] == "text"){
					$model->tamanho = 65535;
				}else{
					$model->tamanho = 255;
				}
				$a = $model->save();
				$model = null;
			}

			//Criando o campo anexos
			//Instanciando o helper model para inserir os dados na tabela campos_requerimentos
			$model = null;
			$model = new HelperModel('campos_requerimentos');
			$model->requerimento_id = $id_requerimento;
			$model->campo_id = $this->getIdCampo('text');
			$model->name = 'justificativa';
			$model->label = 'Justificativas e/ou Observações';
			$model->placeholder = 'Descreva a justificativa para este requerimento, detalhe as razões e/ou motivações para a aceitação do mesmo.';
			$model->tamanho = 255;
			$model->save();

			
			//criar a tabela table_ name no banco de dados
			$create = "CREATE TABLE ".$table_name." (id int PRIMARY KEY AUTO_INCREMENT NOT NULL,curso_de int not null,curso_para int not null,solicitacao_id int not null, justificativa varchar(255), ";
			$campos = null;
			$chaves = "created_at timestamp, updated_at timestamp,deleted_at timestamp,FOREIGN KEY (curso_de) REFERENCES cursos (id),FOREIGN KEY (curso_para) REFERENCES cursos (id),FOREIGN KEY (solicitacao_id) REFERENCES solicitacoes (id));";

			for ($i=0; $i < $max; $i++) {
				$tam = null;
				if($request->tipo_dado[$i] == 'varchar'){
					$tam = '(255)';
				}
				$campos = $campos.$this->nomeCampo($request->label[$i]).' '.$request->tipo_dado[$i].$tam.' not null, ';
			}

			$sql_create = $create.$campos.$chaves;

			//dd($sql_create);

			DB::statement($sql_create);

			//campos de retorno
			$query['success'] = true;
			$query['class'] = 'success';
			$query['messages'] = 'Requerimento cadastrado com sucesso!';
			$query['id'] = (int)$request->tipo;

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

	//Função que retorna o id do campo através do nome
	public function getIdCampo($name){
		$tipos = Campos::where('tipo',$name)->first();
		return $tipos->id;
	}

	//Função que retorna o nome do campo através do nome
	public function getNomeTipo($id){
		$tipos = Tipos::where('id',$id)->first();
		return $tipos->name;
	}

	public function nomeCampo($name){

		return strtolower(str_replace(" ","_",preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($name)))));
	}

	public function nomeTable($id){

		$nome_tipo = $this->getNomeTipo($id);

		$nome_tipo = $nome_tipo.rand(1, 20);

		$nome_tipo = strtolower(str_replace(" ","_",preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($nome_tipo)))));

		$table = Requerimento::where('table_name',$nome_tipo)->count();

		//dd($table);

		if($table == 0){
			return $nome_tipo;
		}else{
			return $this->nomeTable($id);
		}


	}

}
