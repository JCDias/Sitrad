@extends('dashboard.templates.template-dashboard')

@section('content-view')

<!-- Cabeçalho da página com mensagem de boas vindas -->
<section class="content-header">
	
</section>

<!-- Sessão de Conteúdo da página -->
<section class="content">
 <div class="row">
  <div class="col-md-12">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Histórico da solicitação</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
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
          <div class="col-xs-6">
            <label for="">Do curso de</label>
            <input type="text" class="form-control" value="{{ $requerimento['cursoDe'] }}" disabled>
          </div>
          <div class="col-xs-6">
            <label for="">Para o curso de</label>
            <input type="text" class="form-control" value="{{ $requerimento['cursoPara'] }}" disabled>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-xs-4">
            <label for="">Tipo de Solicitação</label>
            <input type="text" class="form-control" value="{{ $requerimento['requerimento'] }}" disabled>
          </div>
          <div class="col-xs-5">
            <label for="">Status Atual</label>
            <input type="text" class="form-control" value="{{ $requerimento['status_atual'] }}" disabled>
          </div>
          <div class="col-xs-3">
            <label for="">Última Atualização</label>
            <input type="text" class="form-control" value="{{ $requerimento['update'] }}" disabled>
          </div>
        </div>
        <br>
        <div>
          <label for="">Parecer</label>
          <input type="text" class="form-control" value="{{ $parecer }}" disabled>
        </div>
        <br>
        <div>
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
      <!-- /.box-body -->
      <div class="box-footer">
        <a href="{{ url()->previous() }}" class="btn btn-lg btn-default">Voltar</a>
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