@extends('dashboard.templates.template-dashboard')

@section('content-view')

<!-- Cabeçalho da página com mensagem de boas vindas -->
<section class="content-header">

	<h4>Perfil</h4>

</section>

<!-- Sessão de Conteúdo da página -->
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-warning">
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
				<div class="box-body">
					<form class="form-horizontal" method="POST" action="{{ route('dashboard.update') }}">
						{{ csrf_field() }}

						<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
							<label for="name" class="col-md-4 control-label">Nome</label>

							<div class="col-md-6">
								<input id="name" type="text" class="form-control" name="name" value="{{ Auth::User()->name }}" required autofocus>

								@if ($errors->has('name'))
								<span class="help-block">
									<strong>{{ $errors->first('name') }}</strong>
								</span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							<label for="email" class="col-md-4 control-label">E-Mail </label>

							<div class="col-md-6">
								<input id="email" type="email" class="form-control" name="email" value="{{ Auth::User()->email }}" required>

								@if ($errors->has('email'))
								<span class="help-block">
									<strong>{{ $errors->first('email') }}</strong>
								</span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
							<label for="username" class="col-md-4 control-label">Nome de Usuário</label>

							<div class="col-md-6">
								<input id="username" type="input" class="form-control" name="username" value="{{ Auth::User()->username }}" required>

								@if ($errors->has('username'))
								<span class="help-block">
									<strong>{{ $errors->first('username') }}</strong>
								</span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('cpf') ? ' has-error' : '' }}">
							<label for="cpf" class="col-md-4 control-label">CPF</label>

							<div class="col-md-6">
								<input id="cpf" type="input" class="form-control" name="cpf" value="{{ Auth::User()->formatted_cpf }}" disabled>

								@if ($errors->has('cpf'))
								<span class="help-block">
									<strong>{{ $errors->first('cpf') }}</strong>
								</span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('matricula') ? ' has-error' : '' }}">
							<label for="matricula" class="col-md-4 control-label">Matrícula</label>

							<div class="col-md-6">
								<input id="matricula" type="input" class="form-control" name="matricula" value="{{ Auth::User()->matricula }}" disabled="">

								@if ($errors->has('matricula'))
								<span class="help-block">
									<strong>{{ $errors->first('matricula') }}</strong>
								</span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
							<label for="password" class="col-md-4 control-label">Senha</label>

							<div class="col-md-6">
								<input id="password" type="password" class="form-control" name="password" >

								@if ($errors->has('password'))
								<span class="help-block">
									<strong>{{ $errors->first('password') }}</strong>
								</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label for="password-confirm" class="col-md-4 control-label">Confirmar senha</label>

							<div class="col-md-6">
								<input id="password-confirm" type="password" class="form-control" name="password_confirmation" >
							</div>
						</div>


						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Atualizar
								</button>
							</div>
						</div>
					</form>
				</div>
				<div class="box-footer text-center">
				</div>
			</div>
		</div>
	</div>
	<!-- /.row -->
</section>
@endsection