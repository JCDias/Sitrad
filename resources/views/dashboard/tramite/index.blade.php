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
					<div class="row">
						<div class="col-md-4">
							<h4>Trâmite sugerido</h4>
							<ul>
								@foreach($requerimento['passos'] as $passos)
								<li>{{ $passos }};</li>
								@endforeach
							</ul>
						</div>
						<div class="col-md-8">
							<label for="">Histórico de ações</label>
							<table class="table table-bordered table-striped">
								<thead>
									<tr class="text-center">
										<td style="width: 30%"><b>Ação</b></td>
										<td style="width: 30%"><b>Ator</b></td>
										<td style="width: 20%"><b>Resposta</b></td>
										<td style="width: 20%"><b>Data</b></td>
									</tr>
								</thead>
								<tbody>
									@if(empty($historico))
									 vazio
									@else
									não vazio
									@endif
									@foreach($historico as $hist) 
									<tr class="text-center">
										<td><b>{!! $hist->acoes->name !!}</b></td>
										@if(!empty($hist->valor))
										<td><b>{!! $hist->roles->label !!}</b></td>
										@else
										<td><b>-</b></td>
										@endif
										@if(empty($hist->resposta))
										<td><b>-</b></td>
										@else
										<td><b>{!! $hist->resposta!!}</b></td>
										@endif
										<td><b>{!! $hist->formatted_created_at!!}</b></td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="box-footer">
					<form class="form-horizontal" method="POST" action="{{ route('tramite.enviar') }}">
						{{ csrf_field() }}

						<input type="hidden" value="{{ $id }}" name="solicitacao">

						<div class="form-group">
							<label for="name" class="col-md-4 control-label">Encaminhar para: </label>

							<div class="col-md-4">
								<select name="encaminhar" id="encaminhar" class="form-control" required>
									<option value="">Selecione um setor</option>
									@foreach($requerimento['passos'] as $passo)
										<option value="{{ $passo }}">{{ $passo }}</option>
									@endforeach
								</select>
							</div>
							
						</div>
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


