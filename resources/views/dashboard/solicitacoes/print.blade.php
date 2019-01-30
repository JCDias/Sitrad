@extends('dashboard.templates.template-dashboard')

@section('content-view')

{{-- Controle de acesso --}}
@can('solicitar_requerimento')

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
          @if(session('success'))
          <div class="callout callout-{{ session('success')['class'] }}">
            <h4>{{ session('success')['messages'] }}</h4>
          </div>
          @endif

        </div>
        <!-- /.box-header -->
        <div class="box-body">

         <div class="callout callout-warning">
          <h3>Atenção!</h3>
          <p>Este requerimento só terá validade A PARTIR da data de sua impressão, assinatura e PROTOCOLO na Secretaria de Registros Acadêmicos / Departamento de Ensino Superior.</p>
        </div>

      </div>
      <!-- /.box-body -->
      <div class="box-footer text-center">
        <div class="pull-left">
          <a href="{{ route('dashboard.index') }}" class="btn btn-default">Voltar</a>
        </div>
        <div>
          <a href="{{ route('solicitacoes.getPdf', $id) }}" class="btn btn-primary" target="_blank">Imprimir requerimento</a>
        </div>
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
<script>window.location = "/dashboard";</script>

{{-- Fim controle de acesso --}}
@endcan

@endsection


