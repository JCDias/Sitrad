@extends('templates.painel')

@section('content-view')

<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="box box-success">
		<div class="box-body">
			{{-- <h1 class="display-4">Seja bem vindo ao Sistema de Gestão de Requerimentos!</h1> --}}
			<h2 class="display-4">Sistema para Tramitação de Documentos do Departamento de Ensino Superior!</h2>
			<br/>
			<p class="lead">O SITRAD permite o acompanhamento de todo o processo de gerenciamento da  solicitação de documentos, o processo de  tramitação dessas solicitações entre os setores administrativos, disponibilizando o seu acompanhamento para os atores envolvidos.</p>
		</div>
	</div>
	@include('templates.partials.breadcrumb')
</section>

<!-- Main content -->
<section class="content">

	<div class="row">
		<a href="{{ route('solicitacoes.index') }}">
			<div class="col-md-6 col-sm-1 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-aqua"><i class="fa fa-edit"></i></span>

					<div class="info-box-content">
						<h2>Solicitar requerimento</h2>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
		</a>
		<!-- /.col -->
		<a href="{{ route('dashboard.todos') }}">
			<div class="col-md-6 col-sm-1 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-red"><i class="fa fa-search"></i></span>

					<div class="info-box-content">
						<h2>Consultar requerimento</h2>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
		</a>
		<!-- /.col -->
	</div>
	<br>
	<div class="box box-warning">
		<div class="box-body">
			<h1 class="display-4">Importante!</h1>
			<br/>
			<p class="lead">Para solicitar ou consultar um requerimento no sistema você precisa estar logado. Faça login ou Cadastre-se!</p>
		</div>
	</div>

</section>
<!-- /.content -->
</div>
<!-- /.container -->
</div>
<!-- /.content-wrapper -->

@endsection