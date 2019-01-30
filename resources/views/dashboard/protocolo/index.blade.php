@extends('dashboard.templates.template-dashboard')

@section('content-view')

{{-- Controle de acesso --}}
@can('protocolo')

<!-- Sessão de cabeçalho -->
<section class="content-header">

	<h1>{{ $title }}</h1>

	{{-- Incluir breadcrumb --}}
	@include('templates.partials.breadcrumb')

	@if(session('success'))
	<br>
	<div class="callout callout-{{ session('success')['class'] }}">
		<h4>{{ session('success')['messages'] }}</h4>
	</div>
	<br>
	@endif
	
	<div class="text-center">
		<p><h4><b>Legenda</b></h4></p>
		<div class="pull-left">
			<i class="fa fa-print btn btn-primary"></i> Imprimir solicitação.
		</div>
		<i class="fa fa-eye btn btn-info"></i> Ver solicitação.
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<i class="fa fa-check-square-o btn btn-success"></i> Protocolar solicitação.
		<div class="pull-right">
			<i class="fa fa-ban btn btn-danger"></i> Cancelar solicitação.
		</div>
	</div>
</section>

<!-- Fim Sessão de cabeçalho -->


<!-- Sessão de Conteúdo da página -->
<section class="content">
	<div class="row">

		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border text-center">

				</div>
				<!-- /.box-header -->
				<div class="box-body">

					<!-- <div class="form-group">
						<label>Pesquisa por nome: </label>
						<input type="text" class="form-control" placeholder="Digite o nome do solicitante.">
					</div> -->
					<table id="todos" class="table table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th>Protocolo</th>
								<th>Requerimento</th>
								<th>Acadêmico</th>
								<th>Data Solicitação</th>
								<th>Situação</th>
								<th style="width: 20%/">Opções</th>
							</tr>
						</thead>
						<tbody>
							@forelse($dados as $dado)
							<tr>
								<td>{!! $dado->getProtocolo($dado->id) !!}</td>
								<td>{!! $dado->requerimentos->tipos->name !!}</td>
								<td>{!! $dado->users->name !!}</td>
								<td>{!! $dado->formatted_created_at !!}</td>
								<td>{!! $dado->acoes->name !!}</td>
								<td>
									<a href="{{ route('solicitacoes.getPdf', $dado->id) }}"  title="Imprimir solicitação" target="_blank"> <i class="fa fa-print btn btn-primary"></i></a>
									&nbsp; &nbsp; &nbsp; &nbsp;
									<a href="{{ route('protocolo.verSolicitacao', $dado->id) }}"  title="Ver solicitação"> <i class="fa fa-eye btn btn-info"></i></a>
									&nbsp;	
									<a href="{{ route('protocolo.protocolar',$dado->id) }}" class="btn" data-toggle="confirmation_2"><i class="fa fa-check-square-o btn btn-success"></i></a>

									<a href="{{ route('protocolo.cancelar',$dado->id) }}" class="btn" data-toggle="confirmation_1"><i class="fa fa-ban btn btn-danger"></i></a>
								</td>
							</tr>
							@empty
							<tr>
								<td colspan="6"> Não há solicitações.</td>
							</tr>
							@endforelse
						</tbody>
					</table>
					
				</div>
				<!-- /.box-body -->
				<div class="box-footer text-center">

				</div>
				<!-- /.box-footer -->
			</div>
			<!-- /.box -->
		</div>
		<!-- /.col -->

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

<!-- DataTables -->
<script src="{{ asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>

<script>
	$(function() {
		$('#todos').DataTable({
			"language": {
				"lengthMenu": "Exibir _MENU_ registros por página",
				"sEmptyTable": "Nenhum registro encontrado",
				"sInfo": "Exibindo de _START_ até _END_ de _TOTAL_ registros",
				"sInfoEmpty": "Exibindo 0 até 0 de 0 registros",
				"sLoadingRecords": "Carregando...",
				"sProcessing": "Processando...",
				"sZeroRecords": "Nenhum registro encontrado.",
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
    /*$('#example1').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
  })*/
})
</script>

{{-- <script src="{{ asset('adminlte/bower_components/jquery/dist/jquery.js')}}"></script> --}}
<script src="{{ asset('adminlte/bower_components/bootstrap/dist/js/bootstrap.js')}}"></script>
<script src="{{ asset('adminlte/bootstrap-confirmation.js')}}"></script>

<script>

	$('[data-toggle=confirmation_2]').confirmation({
		rootSelector: '[data-toggle=confirmation]',
		container: 'body',
		title: "Deseja protocolar a solicitação?",
		placement: 'left',
		btnOkLabel: 'Sim',
		btnOkClass: 'btn-success',
		btnCancelLabel: 'Não',
		btnCancelClass: 'btn-danger'

	});

	$('[data-toggle=confirmation_1]').confirmation({
		rootSelector: '[data-toggle=confirmation]',
		container: 'body',
		title: "Deseja realmente cancelar a solicitação? Essa ação não pode ser desfeita.",
		placement: 'left',
		btnOkLabel: 'Sim',
		btnOkClass: 'btn-success',
		btnCancelLabel: 'Não',
		btnCancelClass: 'btn-danger'

	});
	
</script>


@endsection
