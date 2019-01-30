@extends('dashboard.templates.template-dashboard')

@section('content-view')

<!-- Cabeçalho da página com mensagem de boas vindas -->
<section class="content-header">

  <div class="callout callout-success">
    <h4>Bem-vindo ao SiTraD!</h4>
  </div>

</section>

<!-- Sessão de Conteúdo da página -->
<section class="content">
  <div class="row">
    @can('protocolo')
    <a href="{{ route('protocolo.index') }}">
      <div class="col-md-6 col-sm-1 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-aqua"><i class="fa fa-check-square-o"></i></span>

          <div class="info-box-content">
            <h3>Protocolar requerimentos</h3>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
    </a>
    @endcan
    <!-- /.col -->
    @can('consultar_requerimento')
    <a href="{{ route('dashboard.todos') }}">
      <div class="col-md-6 col-sm-1 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-red"><i class="fa fa-search"></i></span>

          <div class="info-box-content">
            <h3>Consultar requerimentos</h3>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
    </a>
    @endcan
    <!-- /.col -->
    @can('gestao_requerimento')
    <a href="{{ route('requerimentos.index') }}">
      <div class="col-md-6 col-sm-1 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-green"><i class="fa fa-gears"></i></span>

          <div class="info-box-content">
            <h3>Gerenciar requerimentos</h3>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
    </a>
    @endcan
    {{-- @can('gestao_user')
    <a href="{{ route('dashboard.user') }}">
      <div class="col-md-6 col-sm-1 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-yellow"><i class="fa fa-user"></i></span>

          <div class="info-box-content">
            <h3>Gerenciar usuários</h3>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
    </a>
    @endcan --}}
    <!-- /.col -->
  </div>

  <!-- Sessão de Conteúdo da página -->
  @can('solicitar_requerimento')
  <div class="row">

    <div class="col-md-3">
      <div class="box box-info">
        <div class="box-header with-border">
          {{-- Colocar título na box --}}
        </div>
        <!-- /.box-header -->
        <div class="box-body text-center">
          <a href="{{ route('solicitacoes.index') }}" class="btn btn-lg btn-primary"><i class="fa fa-edit"></i> Solicitar Requerimento</a>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">

        </div>
        <!-- /.box-footer -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->

    <div class="col-md-9">
      <div class="box box-warning">
        <div class="box-header with-border">
          <div class="pull-left">
            <h3 class="box-title">Minhas Solicitações</h3>
          </div>
          <div class="pull-right"><a href="{{ route('dashboard.todos') }}" class="uppercase btn btn-primary">Ver todos</a></div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="todos_aluno" class="table table-striped table-hover">
            <thead>
              <tr>
                <th>Protocolo</th>
                <th>Requerimento</th>
                <th>Data Solicitação</th>
                <th>Situação</th>
                <th >Opções</th>
              </tr>
            </thead>
            <tbody>
              @forelse($dados as $dado)
              <tr>
                <td>{!! $dado->getProtocolo($dado->id) !!}</td>
                <td>{!! $dado->requerimentos->tipos->name !!}</td>
                <td>{!! $dado->formatted_created_at !!}</td>
                <td>{!! $dado->acoes->name !!}</td>
                <td>
                  @if($dado->acoes->name == 'Novo')
                  <a href="{{ route('solicitacoes.getPdf', $dado->id) }}" target="_blank" title="Imprimir Requerimento"> <i class="fa fa-print btn btn-primary"></i></a>
                  @endif
                  <a href="{{ route('protocolo.verSolicitacao', $dado->id) }}" class="btn" title="Ver solicitação."><i class="fa fa-eye btn btn-info"></i></a>
                  <a href="{{ route('dashboard.historico', $dado->id) }}" class="btn" title="Ver histórico"><i class="fa fa-history btn btn-success"></i></a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5"> Não há solicitações.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-center">
          {{-- <a href="#" class="uppercase btn btn-primary">Ver todos</a> --}}
        </div>
        <!-- /.box-footer -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
  {{-- Fim do can SOLICITAR_REQUERIMENTO --}}
  @endcan
  
  {{-- Verificação para mostrar painel de com dados por setor --}}
  @can('tramite')
  @if(session('success'))
  <br>
  <div class="callout callout-{{ session('success')['class'] }}">
    <h4>{{ session('success')['messages'] }}</h4>
  </div>
  <br>
  @endif
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header with-border text-center">
          <div class="text-center">
            <p><h4><b>Legenda</b></h4></p>
            <div class="pull-left">
              <i class="fa fa-history btn btn-success"></i> Histórico da Solicitação.
            </div>
            <i class="fa fa-eye btn btn-info"></i> Ver solicitação.
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <i class="fa fa-refresh btn btn-primary"></i> Tramite solicitação.
            <div class="pull-right">
              <i class="fa fa-edit btn btn-warning"></i> Responder solicitação.
            </div>
          </div>
          <br>
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
              @forelse($solicitacoesSetor as $solicitacao_setor)
              <tr>
                <td>{!! $solicitacao_setor['protocolo'] !!}</td>
                <td>{!! $solicitacao_setor['requerimento'] !!}</td>
                <td>{!! $solicitacao_setor['aluno'] !!}</td>
                <td>{!! $solicitacao_setor['data_solicitacao'] !!}</td>
                <td>{!! $solicitacao_setor['status_atual'] !!}</td>
                <td>
                  <a href="{{ route('dashboard.historico', $solicitacao_setor['id_solicitacao']) }}" > 
                    <i class="fa fa-history btn btn-success"></i>
                  </a>
                  &nbsp; 
                  <a href="{{ route('protocolo.verSolicitacao', $solicitacao_setor['id_solicitacao']) }}" > 
                    <i class="fa fa-eye btn btn-info"></i>
                  </a>
                  &nbsp;  
                  <a href="{{ route('tramite.index', $solicitacao_setor['id_solicitacao']) }}" > 
                    <i class="fa fa-refresh btn btn-primary"></i>
                  </a>
                  &nbsp; 
                  <a href="{{ route('tramite.resposta',$solicitacao_setor['id_solicitacao']) }}" >
                    <i class="fa fa-edit btn btn-warning"></i>
                  </a>
                </td>
              </tr>
              @if($protocolados != null)
              @foreach($protocolados as $protocolado)
              <tr>
                <td>{!! $protocolado->getProtocolo($protocolado->id) !!}</td>
                <td>{!! $protocolado->requerimentos->tipos->name!!}</td>
                <td>{!! $protocolado->users->name !!}</td>
                <td>{!! $protocolado->formatted_created_at !!}</td>
                <td>{!! $protocolado->acoes->name !!}</td>
                <td>
                  <a href="{{ route('dashboard.historico', $protocolado->id) }}" > 
                    <i class="fa fa-history btn btn-success"></i>
                  </a>
                  &nbsp; 
                  <a href="{{ route('protocolo.verSolicitacao', $protocolado->id) }}" > 
                    <i class="fa fa-eye btn btn-info"></i>
                  </a>
                  &nbsp;  
                  <a href="{{ route('tramite.index', $protocolado->id) }}" > 
                    <i class="fa fa-refresh btn btn-primary"></i>
                  </a>
                  &nbsp; 
                  <a href="{{ route('tramite.resposta',$protocolado->id) }}" >
                    <i class="fa fa-edit btn btn-warning"></i>
                  </a>
                </td>
              </tr>
              @endforeach
              @endif
              @empty
              @if($protocolados != null)
              @foreach($protocolados as $protocolado)
              <tr>
                <td>{!! $protocolado->getProtocolo($protocolado->id) !!}</td>
                <td>{!! $protocolado->requerimentos->tipos->name!!}</td>
                <td>{!! $protocolado->users->name !!}</td>
                <td>{!! $protocolado->formatted_created_at !!}</td>
                <td>{!! $protocolado->acoes->name !!}</td>
                <td>
                  <a href="{{ route('dashboard.historico', $protocolado->id) }}" > 
                    <i class="fa fa-history btn btn-success"></i>
                  </a>
                  &nbsp; 
                  <a href="{{ route('protocolo.verSolicitacao', $protocolado->id) }}" > 
                    <i class="fa fa-eye btn btn-info"></i>
                  </a>
                  &nbsp;  
                  <a href="{{ route('tramite.index', $protocolado->id) }}" > 
                    <i class="fa fa-refresh btn btn-primary"></i>
                  </a>
                  &nbsp; 
                  <a href="{{ route('tramite.resposta',$protocolado->id) }}" >
                    <i class="fa fa-edit btn btn-warning"></i>
                  </a>
                </td>
              </tr>
              @endforeach
              @else
              <tr>
                <td colspan="6"> Não há solicitações.</td>
              </tr>
              @endif
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
  @endcan

  {{-- Fim Verificação para mostrar painel de com dados por setor --}}
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
    $('#todos_aluno').DataTable({
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
@endsection