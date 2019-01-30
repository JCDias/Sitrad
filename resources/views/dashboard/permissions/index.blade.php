@extends('dashboard.templates.template-dashboard')

@section('content-view')

{{-- Controle de acesso --}}
@can('gestao_user')

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
			<div class="box box-warning">
				<div class="box-header with-border">
					<h2>Lista de permissões apenas para consulta.</h2>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table id="todos_users" class="table table-striped table-hover">
						<thead>
							<tr class="text-center">
								<th style="width: 25%">Permissões</th>
								<th>Descrição</th>
								<th style="width: 25%;">Funções</th>
							</tr>
						</thead>
						<tbody>
							@forelse($permissions as $permission)
							<tr>
								<td>{!! $permission->name !!}</td>
								<td>{!! $permission->label !!}</td>
								<td>
									<ul>
										@foreach($permission->roles as $role)
										<li>{!! $role->label !!}</li>
										{{-- <p>{!! $role->label !!}</p> --}}
										@endforeach
									</ul>
								</td>
							</tr>
							@empty
							<tr>
								<td colspan="3"> Não há permissões cadastrados.</td>
							</tr>
							@endforelse
						</tbody>
					</table>
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<a href="{{ route('dashboard.index') }}" class="btn btn-lg btn-default">Voltar</a>
				</div>
				<!-- /.box-footer -->
			</div>
			<!-- /.box -->
		</div>
		<!-- /.col -->
	</div>
	<!-- /.box-body -->
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

<!-- DataTables -->
<script src="{{ asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>

<script>
	$(function() {
		$('#todos_users').DataTable({
			"language": {
				"lengthMenu": "Exibir _MENU_ registros por página",
				"sEmptyTable": "Nenhum registro encontrado",
				"sInfo": "Exibindo de _START_ até _END_ de _TOTAL_ registros",
				"sInfoEmpty": "Exibindo 0 até 0 de 0 registros",
				"sLoadingRecords": "Carregando...",
				"sProcessing": "Processando...",
				"sZeroRecords": "Nenhum registro encontrado",
				"sSearch": "Pesquisar: ",
				"oPaginate": {
					"sNext": "Próximo",
					"sPrevious": "Anterior",
					"sFirst": "Primeiro",
					"sLast": "Último"
				},
				"oAria": {
					"sSortAscending": ": Ordenar colunas de forma ascendente",
					"sSortDescending": ": Ordenar colunas de forma descendente"
				}
			}
		})
	})
</script>

{{-- Fim data table --}}

<script src="{{ asset('adminlte/bower_components/jquery/dist/jquery.js')}}"></script>
<script src="{{ asset('adminlte/bower_components/bootstrap/dist/js/bootstrap.js')}}"></script>
<script src="{{ asset('adminlte/bootstrap-confirmation.js')}}"></script>

<script>

	$('[data-toggle=confirmation]').confirmation({
		rootSelector: '[data-toggle=confirmation]',
		container: 'body',
		title: "Deseja realmente excluir? Essa ação não pode ser desfeita.",
		placement: 'left',
		btnOkLabel: 'Sim',
		btnOkClass: 'btn-success',
		btnCancelLabel: 'Não',
		btnCancelClass: 'btn-danger'

	});
	
</script>

@endsection