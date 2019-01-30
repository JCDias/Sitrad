@extends('dashboard.templates.template-dashboard')

@section('content-view')

{{-- Controle de acesso --}}
@can('tramite')

<!-- Sessão de cabeçalho -->
<section class="content-header">

	<h1>{{ $title }}</h1>

	{{-- Incluir breadcrumb --}}
	@include('templates.partials.breadcrumb')

</section>

<!-- Fim Sessão de cabeçalho -->


<!-- Sessão de Conteúdo da página -->
<section class="content">
	<div class="row">

		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<div class="row">
						<div class="col-xs-3">
							<label for="">Número de protocolo</label>
							<input type="text" class="form-control" value="{{ $requerimento['protocolo'] }}" disabled>
						</div>
						<div class="col-xs-6">
							<label for="">Acadêmico</label>
							<input type="text" class="form-control" value="{{ $requerimento['aluno'] }}" disabled>
						</div>
						<div class="col-xs-3">
							<label for="">Data de Protocolo</label>
							<input type="text" class="form-control" value="{{  $requerimento['data'] }}" disabled>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-4">
							<label for="">Tipo de Solicitação</label>
							<input type="text" class="form-control" value="{{ $requerimento['requerimento'] }}" disabled>
						</div>
						<div class="col-xs-4">
							<label for="">Do curso de</label>
							<input type="text" class="form-control" value="{{ $requerimento['cursoDe'] }}" disabled>
						</div>
						<div class="col-xs-4">
							<label for="">Para o curso de</label>
							<input type="text" class="form-control" value="{{ $requerimento['cursoPara'] }}" disabled>
						</div>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<form class="form-horizontal" method="POST" action="{{ route('tramite.responder') }}">
						{{ csrf_field() }}
						<input type="hidden" value="{{ $id }}" name="solicitacao">
						<div class="row">
							<div class="col-md-6">
								<label for="">Ação</label>
								<select name="acao" id="acao" class="form-control" required>
									<option value="">Selecione uma Ação</option>
									<option value="Resposta">Respoder</option>
									<option value="Deferido">Deferir</option>
									<option value="Indeferido">Indeferir</option>
								</select>
							</div>
							<div class="col-md-6">
								<label for="">Finalizar?</label>
								<select name="finalizado" id="finalizado" class="form-control" >
									<option value="Não">Não</option>
									<option value="Sim">Sim</option>
								</select>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-12">
								<label for="name">Resposta: </label>

								<input type="text" class="form-control" name="resposta" required>

							</div>
						</div>
					</div>
					<div class="box-footer">

						<div class="form-group text-center">
							<div class="pull-left">
								<a href="{{ route('dashboard.index') }}" class="btn btn-default">Voltar</a>
							</div>
							<button type="submit" class="btn btn-success">
								Enviar
							</button>
							<div class="pull-right">
								<a href="{{ route('protocolo.verSolicitacao',$id) }}" class="btn btn-info" >Ver solicitação</a>
							</div>
						</div>
					</form>
				</div>
				{{-- .box-footer --}}
			</div>
			{{-- .box --}}
		</div>
		{{-- .col --}}
	</div>
</section>
<!-- Fim Sessão de Conteúdo da página -->

{{-- Else controle de acesso --}}
@else

{{-- Redirecionamento para a página dashboard caso nao tenha a permissão especificada --}}
<script>window.location.href = "{{ route('dashboard.index') }}";</script>

{{-- Fim controle de acesso --}}
@endcan

@endsection


