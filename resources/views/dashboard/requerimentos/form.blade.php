@extends('dashboard.templates.template-dashboard')

@section('content-css')

<link rel="stylesheet" type="text/css" href="{{ asset('multiselect/css/multi-select.css') }}">

@endsection

@section('content-view')

{{-- Controle de acesso --}}
@can('gestao_requerimento')

<!-- Sessão de cabeçalho -->
<section class="content-header">

  <h1>{{ $title }}</h1>

  {{-- Incluir breadcrumb --}}
  @include('templates.partials.breadcrumb')

  <br>
  @if(session('success'))
  <div class="callout callout-{{ session('success')['class'] }}">
    <h4>{{ session('success')['messages'] }}</h4>
  </div>
  @endif

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

</section>

<!-- Fim Sessão de cabeçalho -->


<!-- Sessão de Conteúdo da página -->
<section class="content">
  <div class="row">

   <div class="col-md-12">
    <div class="box box-info">
      <div class="box-header with-border">
        <div class="pull-right">
          <a href="{{ route('tipos.index') }}" class="btn btn-info">Criar novo tipo de requerimento</a>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">

        {!! Form::open(['route' => 'requerimentos.create', 'method' => 'get', 'class' => 'form-padrao']) !!}
        {{-- Abrir form --}}
        <div class="form-group {{ $errors->has('tipo') ? ' has-error' : '' }}">
          <label>Selecione o tipo de requerimento desejado</label>
          <select name="tipo" id="tipo" class="form-control" required>
            <option value="">Selecione um tipo</option>
            @foreach($tipos_list as $tipo)
            <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
            @endforeach
          </select>
        </div>
        {{-- <div class="form-group {{ $errors->has('table_name') ? ' has-error' : '' }}">
          <label>Nome da tabela</label>
          <input type="text" placeholder="O campo não pode conter espaços, números e/ou caracteres especiais. O uso de _ é permitido." class="form-control" pattern="[a-zA-Z_]+" title="O campo não pode conter espaços, números e/ou caracteres especiais." name="table_name" value="{{ old('table_name') }}" required>
        </div> --}}
       {{--  <div class="form-group {{ $errors->has('passos') ? ' has-error' : '' }}">
          <label>Passo a Passo</label>
          <textarea class="form-control" rows="3" name="passos" placeholder="Digite o passo a passo que o requerimento deve seguir após ser protocolado." value="{{ old('passos') }}" required></textarea>
          <small>Informe os passos separados por ponto e vírgla ( <b>;</b> ).</small>
        </div> --}}

        <div class="form-group {{ $errors->has('passos') ? ' has-error' : '' }}">
          <label>Passos:</label>
          <small>Selecione para quais funções o requerimento deve ser encaminhado durante o processo de trâmite. Mínimo 1.</small>
          <select id='passos' multiple='multiple' name="passos[]" required>
            @foreach($roles_list as $role_list)
            <option value='{{ $role_list->label }}'>{{ $role_list->label }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group {{ $errors->has('informacoes') ? ' has-error' : '' }}">
          <label>Informações importantes</label>
          <textarea class="form-control" rows="3" name="informacoes" placeholder="Digite as orienteções necessárias para aceite do requerimento." value="{{ old('informacoes') }}" required></textarea>
          <small>Informe as orienteções separadas por ponto e vírgla ( <b>;</b> ).</small>
        </div>
        <div class="form-group col-md-4">
          <label>Discente do curso de</label>
          <input type="text" placeholder="Esse campos será criado automaticamente." class="form-control" disabled>
        </div>
        <div class="form-group col-md-4">
          <label>Analisado pelo curso de</label>
          <input type="text" placeholder="Esse campos será criado automaticamente." class="form-control" disabled>
        </div>
        <div class="form-group col-md-4">
          <label>Justificativas e/ou Observações</label>
          <input type="text" placeholder="Esse campos será criado automaticamente." class="form-control" disabled>
        </div>
        <hr>
        <div class="text-center">
          <button type="button" class="btn btn-primary" name="add" id="add"><i class="fa fa-plus"></i> Adicionar campos</button>
        </div>
        <hr>
        <table class="table table-bordered" id="dynamic_field">
          <tr>
            <thead>
              <th>Nome de exibição</th>
              <th>Placeholder</th>
              <th>Tipo de dado</th>
              <th>Opções</th>
            </thead>
          </tr>
        </table>
      </div>
      <!-- /.box-body -->
      <div class="box-footer text-center">

        @include('templates.formulario.submit', ['input' => 'Criar Formulário','class' => 'btn btn-lg  btn-success'])
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

<script>window.location.href = "{{ route('dashboard.index') }}";</script>

{{-- Fim controle de acesso --}}
@endcan
@endsection

@section('content-js')
{{-- Js específico para esta página --}}
{{-- função que adiciona campos dinâmicos --}}
<script>

  $(document).ready(function(){
    var i = 1;
    $('#add').click(function(){
      i++;
      $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" placeholder="Digite o que será exibido no campos" name="label[]" class="form-control" required></td><td><input type="text" placeholder="Digite o texto que servirá de auxílio para o preenchimento do campo" name="placeholder[]" class="form-control" required></td><td><select name="tipo_dado[]" class="form-control" required><option value="varchar">Texto</option><option value="text">Text Área</option></select></td><td><button class="fa fa-close btn btn-danger btn_remove" name="remove" id="'+i+'"></button></td></tr>');
    });
    $(document).on('click','.btn_remove',function(){
      var button_id = $(this).attr("id");
      $("#row"+button_id+"").remove();
    });
  });

</script>

<script src="{{ asset('multiselect/js/jquery.multi-select.js') }}"></script>
<script type="text/javascript">
  // run pre selected options
  $('#passos').multiSelect({
    keepOrder: true,
    selectableHeader: "<div class='custom-header'>Funções</div>",
    selectionHeader: "<div class='custom-header'>Funções Selecionados</div>"
  });
</script>

@endsection
