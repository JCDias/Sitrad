 @extends('dashboard.templates.template-dashboard')

@section('content-css')

<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('adminlte/bower_components/select2/dist/css/select2.min.css')}}">

@endsection

@section('content-view')

{{-- Controle de acesso --}}
@can('gestao_user')

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
					<h3>Atribuir ou remover funções ao usuário: <b>{{ $nome_user}}</b></h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					{!! Form::open(['route'=> 'user.update','method' => 'post']) !!}
					<div class="form-group">
						<label>Selecione as funções</label>
						<select class="form-control select2" name="funcoes[]" multiple="multiple" data-placeholder="Selecione as permissões." style="width: 100%; height: 100px;" required>
							@foreach($funcoes as $funcao)
							<option value="{{ $funcao['id'] }}" {{ $funcao['atributo'] }}>{{ $funcao['name'] }}</option>
							@endforeach
						</select>
					</div>
					<input type="hidden" name="user" value="{{ $user }}">
				</div>
				<!-- /.box-body -->
				<div class="box-footer text-center">
					<div class="pull-left">
						<a href="{{ route('dashboard.user') }}" class="btn btn-lg btn-default">Voltar</a>
					</div>
						<input type="submit" value="Continuar" class="btn btn-lg btn-success" ata-toggle="modal" data-target="#modal-default">
				</div>
				<!-- /.box-footer -->
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

@section('content-js')

<script src="{{ asset('adminlte/bower_components/select2/dist/js/select2.full.min.js')}}"></script>

<script>
	$(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

})
</script>

@endsection