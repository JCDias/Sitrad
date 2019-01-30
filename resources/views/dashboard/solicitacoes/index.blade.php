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

          <h4>
            <b>Aluno: </b>{{ Auth::user()->name }}
          </h4>
          <h4>
            <b>Matrícula: </b>{{ Auth::user()->matricula }}
          </h4>

        </div>
        <!-- /.box-header -->
        <div class="box-body">
         
         {!! Form::open(['route' => 'solicitacoes.showForm', 'method' => 'get', 'class' => 'form-padrao']) !!}
          {{-- Abrir form --}}
          <div class="form-group">
            <label>Selecione o tipo de requerimento desejado</label>
            <select name="tipo" id="tipo" class="form-control" required>
              <option value="">Selecione um tipo</option>
             @foreach($tipos_list as $tipo)
                <option value="{{ $tipo->tipos->id }}">{{ $tipo->tipos->name }}</option>
             @endforeach
            </select>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-center">
          @include('templates.formulario.submit', ['input' => 'Continuar','class' => 'btn btn-lg  btn-success'])
        </div>
        <!-- /.box-footer -->
        {{-- Finalizar form --}}
      {!! Form::close() !!}
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


