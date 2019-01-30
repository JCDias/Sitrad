@extends('dashboard.templates.template-dashboard')

@section('content-view')

{{-- Controle de acesso --}}
@can('view_solicitacao')
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
				</div>
				<!-- /.box-header -->
				<div class="box-body">

					<table class="table table-striped">
						<tr>
							<td width="30%" class="tipo"><b>Acadêmico:</b></td>
							<td>{!! $data['aluno'] !!}</td>
						</tr>
						<tr>
							<td width="30%" class="tipo"><b>Matrícula:</b></td>
							<td>{!! $data['matricula'] !!}</td>
						</tr>
						<tr>
							<td width="30%" class="tipo"><b>Protocolo:</b></td>
							<td>{!! $data['protocolo'] !!}</td>
						</tr>
						<tr>
							<td width="30%" class="tipo"><b>Requerimento:</b></td>
							<td>{!! $data['requerimento'] !!}</td>
						</tr>
						<tr>
							<td width="30%" class="tipo"><b>Acadêmico do curso:</b></td>
							<td>{!! $data['cursoDe'] !!}</td>
						</tr>
						<tr>
							<td width="30%" class="tipo"><b>Encaminhado para:</b></td>
							<td>{!! $data['cursoPara'] !!}</td>
						</tr>
						<tr>
							<td width="30%" class="tipo"><b>Justificativa:</b></td>
							<td>{!! $data['justificativa'] !!}</td>
						</tr>
						<tr>
							<td width="30%" class="tipo"><b>Documento(s) Anexo(s):</b></td>
							<td>{!! $data['anexos'] !!}</td>
						</tr>
					</table>
					<!-- /.box-body -->
					<div class="box-footer text-center">
						<div class="pull-left">
							<a href="{{ url()->previous() }}" class="btn btn-default">Voltar</a>
						</div>
						{{-- Controle de acesso --}}
						@can('protocolo')
							@if($data['status_atual'] == 'Novo')
								<a href="{{ route('protocolo.protocolar',$id) }}" class="btn btn-success" data-toggle="confirmation_1" >Protocolar</a>
								<div class="pull-right">
									<a href="{{ route('protocolo.cancelar',$id) }}" class="btn btn-danger" data-toggle="confirmation_2">Cancelar solicitação</a>
								</div>
							@endif
						@endcan
					</div>
					<!-- /.box-footer -->
				</div>
				<!-- /.box -->
			</div>
			<!-- /.col -->

		</div>
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


@section('content-js')

<script src="{{ asset('adminlte/bower_components/jquery/dist/jquery.js')}}"></script>
<script src="{{ asset('adminlte/bower_components/bootstrap/dist/js/bootstrap.js')}}"></script>
<script src="{{ asset('adminlte/bootstrap-confirmation.js')}}"></script>

<script>

	$('[data-toggle=confirmation_2]').confirmation({
		rootSelector: '[data-toggle=confirmation]',
		container: 'body',
		title: "Deseja realmente cancelar a solicitação? Essa ação não pode ser desfeita.",
		placement: 'left',
		btnOkLabel: 'Sim',
		btnOkClass: 'btn-success',
		btnCancelLabel: 'Não',
		btnCancelClass: 'btn-danger'

	});
	$('[data-toggle=confirmation_1]').confirmation({
		rootSelector: '[data-toggle=confirmation]',
		container: 'body',
		title: "Deseja protocolar a solicitação?",
		placement: 'left',
		btnOkLabel: 'Sim',
		btnOkClass: 'btn-success',
		btnCancelLabel: 'Não',
		btnCancelClass: 'btn-danger'

	});
	
</script>


@endsection