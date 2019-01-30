@extends('dashboard.templates.template-dashboard')

@section('content-view')

{{-- Controle de acesso --}}
@can('gestao_requerimento')

<!-- Sessão de cabeçalho -->
<section class="content-header">

  <h1>{{ $title }}</h1>
  <br>
  @if(session('success'))
  <div class="callout callout-{{ session('success')['class'] }}">
    <h4>{{ session('success')['messages'] }}</h4>
  </div>
  @endif

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
          <div class="pull-right">
            {{-- <a href="#" class="btn btn-primary"> <i class="fa fa-filter"></i> Filtrar</a> --}}
          </div>
          <div class="pull-left">
            <a href="{{ route('requerimentos.novo') }}" class="btn btn-primary"> <i class="fa fa-plus"></i> Novo Requerimento</a>
          </div>

        </div>
        <!-- /.box-header -->
        <div class="box-body text-center">
          <h2>Requerimentos Cadastrados do tipo:<br> <b>{{ $nome_requerimento }}</b></h2>
          <br>
          <table class="table table-striped table-bordered">
            <tr>
              {{-- <td><b>Tipo de Requerimento</b></td> --}}
              <td><b>Criador</b></td>
              <td><b>Tabela</b></td>
              <td><b>Passo a Passo</b></td>
              <td><b>Informações</b></td>
              <td><b>Status</b></td>
              <td style="width: 15%;">Opções</td>
            </tr>
            @forelse($requerimentos as $r)
            <tr>
              <td>{{ $r->user->name }}</td>
              <td>{{ $r->table_name }}</td>
              <td>{{ $r->passos }}</td>
              <td>{{ $r->informacoes }}</td>
              <td>{{ $r->status }}</td>
              <td>
                @if($r->status == 'ativo')
                <a href="{{ route('requerimentos.updateStatus',[$r->id,$r->tipo_id]) }}" class="btn btn-danger" title="Definir requerimento como inativo">
                  <i class="fa fa-remove"></i>
                </a>
                @else
                <a href="{{ route('requerimentos.updateStatus',[$r->id,$r->tipo_id]) }}" class="btn btn-success" title="Definir requerimento como ativo">
                  <i class="fa fa-plus"></i>
                </a>
                @endif
                {{-- <a href="{{ route('requerimentos.detalhes', [$r->id,$r->tipo_id]) }}" class="btn btn-info" title="Ver formulário">
                 <i class="fa fa-eye"></i>
               </a> --}}
             </td>
           </tr>
           @empty
           <tr>
            <td colspan="4">Nenhum requerimento cadastrado.</td colspan="6">
            </tr>
            @endforelse
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">

        </div>
        <!-- /.box-footer -->
      </div>
      <!-- /.box -->
      <a href="{{ route('requerimentos.index') }}" class="btn btn-default">
       Voltar
     </a>
   </div>
   <!-- /.col -->

 </div>
</section>
<!-- Fim Sessão de Conteúdo da página -->

{{-- Else controle de acesso --}}
@else

<script>window.location.href = "{{ route('dashboard.index') }}";</script>

{{-- Fim controle de acesso --}}
@endcan
@endsection


