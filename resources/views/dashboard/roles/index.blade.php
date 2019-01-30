@extends('dashboard.templates.template-dashboard')

@section('content-view')

{{-- Controle de acesso --}}
@can('gestao_user')

<!-- Sessão de cabeçalho -->
<section class="content-header">

	<h1>{{ $title }}</h1>
	<br>

	{{-- Incluir breadcrumb --}}
	@include('templates.partials.breadcrumb')

	@if(session('success'))
	<div class="callout callout-{{ session('success')['class'] }}">
		<h4>{{ session('success')['messages'] }}</h4>
	</div>
	@endif

</section>

<!-- Fim Sessão de cabeçalho -->


<!-- Sessão de Conteúdo da página -->
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-warning">
				<div class="box-header with-border">
					<div class="pull-left">
						<a href="{{ route('roles.novo') }}" class="btn btn-primary"> <i class="fa fa-plus"></i> Nova função</a>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table id="todos_users" class="table table-bordered table-striped table-hover">
						<thead>
							<tr class="text-center">
								<th style="width: 10%">Nome</th>
								<th style="width: 25%">Descrição</th>
								<th style="width: 50%;">Permissões Atribuídas</th>
								<th style="width: 15%;">Opções</th>
							</tr>
						</thead>
						<tbody>
							@forelse($funcoes as $funcao)
							<tr>
								<td>{!! $funcao->name !!}</td>
								<td>{!! $funcao->label !!}</td>
								<td>
									<ul>
										@foreach($funcao->permissions as $permission)
										<li><b>{!! $permission->name !!}:</b> {!! $permission->label !!}</li>
										@endforeach
									</ul>
								</td>
								<td>
									<a href="{{ route('roles.editar',$funcao->id) }}" title="" class="btn btn-info"><i class="fa fa-edit"></i> Editar permissões</a>
								</td>
							</tr>
							@empty
							<tr>
								<td colspan="3"> Não há funções cadastrados.</td>
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