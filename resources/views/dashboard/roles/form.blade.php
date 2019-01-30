@extends('dashboard.templates.template-dashboard')

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
			<div class="box box-warning">
				<div class="box-header with-border">
					<div class="pull-left">
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
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					{!! Form::open(['route' => 'roles.store', 'method' => 'post', 'class' => 'form-padrao']) !!}
					{{-- Abrir form --}}

					<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

						<label>Nome da Função</label>

						<input type="text" name="name" class="form-control" placeholder="Digite o nome da nova função. O campo não pode conter caracteres especias, espaços e/ou números." value="{{ old('name') }}" pattern="[a-zA-Z_]+" title="O campo não pode conter caracteres especias, espaços e/ou números." required>
					</div>
					<div class="form-group{{ $errors->has('label') ? ' has-error' : '' }}">

						<label>Descrição da Função</label>

						<input type="text" name="label" class="form-control" placeholder="Digite a descrição da nova função" value="{{ old('label') }}" required>
					</div>
				</div>
				<!-- /.box-body -->
				<div class="box-footer text-center">
					<div class="pull-left">
						<a href="{{ route('roles.index') }}" class="btn btn-lg btn-default">Voltar</a>
					</div>
					<input type="submit" value="Cadastrar" class="btn btn-lg btn-success" />
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


