@extends('dashboard.templates.template-dashboard')

@section('content-view')

<!-- Cabeçalho da página com mensagem de boas vindas -->
<section class="content-header">
	<div class="text-center">
    <p><h4><b>Legenda</b></h4></p>
    <div class="pull-left">
      <i class="fa fa-print btn btn-primary"></i> Imprimir solicitação.
    </div>
    <i class="fa fa-eye btn btn-info"></i> Ver solicitação.
    <div class="pull-right">
      <i class="fa fa-history btn btn-success"></i> Ver histórico da solicitação.
    </div>
  </div>
</section>

<!-- Sessão de Conteúdo da página -->
<section class="content">
 <div class="row">
  <div class="col-md-12">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Solicitações</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        @include('dashboard.list')
      </div>
      <!-- /.box-body -->
      <div class="box-footer text-center">
        {{-- <a href="#" class="uppercase btn btn-primary">Ver todos</a> --}}
        
      </div>
      <!-- /.box-footer -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
</section>

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


@endsection