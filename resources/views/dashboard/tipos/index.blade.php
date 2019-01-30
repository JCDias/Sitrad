@extends('dashboard.templates.template-dashboard')

@section('content-view')

{{-- Controle de acesso --}}
@can('gestao_requerimento')

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
          @if($errors->any())
          <div class="callout callout-danger">
            <h4><i class="icon fa fa-warning"></i>  Atenção</h4>
            <ul>
              @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif

        </div>
        <!-- /.box-header -->
        <div class="box-body">

         {!! Form::open(['route' => 'tipos.store', 'method' => 'post', 'class' => 'form-padrao']) !!}
         {{-- Abrir form --}}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
          
          <label>Tipo</label>
          
              <input type="text" name="name" class="form-control" placeholder="Digite o nome do requerimento" value="{{ old('name') }}" required="">
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer text-center">
        <a href="{{ route('requerimentos.novo') }}" class="pull-left btn btn-lg  btn-default">Voltar</a>
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


