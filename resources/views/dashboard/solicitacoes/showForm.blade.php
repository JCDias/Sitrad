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
          <br>
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

         {!! Form::open(['route' => 'solicitacoes.cadastrar', 'method' => 'post', 'class' => 'form-padrao']) !!}
         {{-- Abrir form --}}
         
         <div class="form-group">
          <label>Sou Discente do curso de...</label>
          <select name="curso_de" id="curso_de" class="form-control" required>
            <option value="">Selecione um curso</option>
           
            @foreach($cursos_list as $curso)
            <option value="{{ $curso['id'] }}">{{ $curso['name'] }}</option>
            @endforeach
            
          </select>
        </div>

        <div class="form-group">
          <label>Este Requerimento deverá ser analisado pelo curso de...</label>
          <select name="curso_para" id="curso_para" class="form-control" required>
            <option value="">Selecione um curso</option>
            
            @foreach($cursos_list as $curso)
            <option value="{{ $curso['id'] }}">{{ $curso['name'] }}</option>
            @endforeach

          </select>
        </div>

        <input name="id_tipo" type="hidden" value="{{ $id }}">

        @foreach($campos as $value)

        <div class="form-group{{ $errors->has('$value["name"]') ? ' has-error' : '' }}">
          
          <label>{{ ucfirst($value['label']) }}</label>
          
          @if($value['tipo'] == 'text-area')
              <textarea class="form-control" rows="3" name="{{ $value['name'] }}" placeholder="{{ ucfirst($value['placeholder']) }}"  value="{{ old('$value["name"]') }}" required></textarea>
          @else
              <input type="{{ $value['tipo'] }}" name="{{ $value['name'] }}" class="form-control" placeholder="{{ ucfirst($value['placeholder']) }}" value="{{ old('$value["name"]') }}">
          @endif
        </div>
        @endforeach
      </div>
      <!-- /.box-body -->
      <div class="box-footer text-center">
        <a href="{{ route('solicitacoes.index') }}" class="pull-left btn btn-lg  btn-default">Voltar</a>
        @include('templates.formulario.submit', ['input' => 'Continuar','class' => 'btn btn-lg  btn-success'])
        <a href="" class="pull-right btn btn-lg  btn-info">Reset</a>
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
<script>window.location = "/dashboard";</script>

{{-- Fim controle de acesso --}}
@endcan

@endsection


