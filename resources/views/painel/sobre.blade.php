@extends('templates.painel')

@section('content-view')

<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="box box-success">
		<div class="box-body">
			{{-- <h1 class="display-4">Seja bem vindo ao Sistema de Gestão de Requerimentos!</h1> --}}
			<h2 class="display-4">Sistema para Tramitação de Documentos do Departamento de Ensino Superior!</h2>
			<br/>
			<p class="lead">O SITRAD é um sistema que permite o acompanhamento de todo o processo de gerenciamento da solicitação de documentos, o processo de tramitação dessas solicitações entre os setores administrativos, disponibilizando o seu acompanhamento para os atores envolvidos. </p>
			<p class="lead">O sistema foi desenvolvido pelo acadêmico Jean Carlos Dias da Silva como trabalho de conclusão de curso como parte das exigências para obtenção do grau de Tecnólogo em Análise e Desenvolvimento de Sistemas do IFNMG – Campus Januária, sob orientação da professora Cleiane Gonçalves Oliveira.</p>
		</div>
	</div>
</section>

<!-- Main content -->
<section class="content">

	<div class="row">
		<a href="{{ asset('arquivos/manual_sitrad.pdf')}}" target="_blank">
			<div class="col-md-6 col-sm-1 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-aqua"><i class="fa fa-file"></i></span>

					<div class="info-box-content">
						<h2>Manual de instruções</h2>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
		</a>
		<!-- /.col -->
		<a href="{{ asset('arquivos/artigo_jean_carlos.pdf')}}" target="_blank">
			<div class="col-md-6 col-sm-1 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-red"><i class="fa fa-file-text-o"></i></span>

					<div class="info-box-content">
						<h2>Artigo</h2>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
		</a>
		<!-- /.col -->
	</div>
</section>
<!-- /.content -->
</div>
<!-- /.container -->
</div>
<!-- /.content-wrapper -->

@endsection