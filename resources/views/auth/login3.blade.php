@extends('templates.painel')

@section('content-view')

<section class="content-header">
	@if(session('success'))
	<div class="callout callout-{{ session('success')['class'] }}">
		<h4>{{ session('success')['messages'] }}</h4>
	</div>
	@endif
</section>

<div class="login-box">
	<div class="login-logo">
		<a href="{{ route('painel.index') }}"><b>SITRAD</b></a>
	</div>
	<!-- /.login-logo -->
	<div class="login-box-body">
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
		<br>
		<p class="login-box-msg">Entre para iniciar sua sessão.</p>

		<form class="form-horizontal" method="POST" action="{{ route('login') }}">
			{{ csrf_field() }}
			<div class="form-group has-feedback {{ $errors->has("username") ? ' has-error' : '' }}">
				<input id="username" type="input" class="form-control" name="username" value="{{ old("username") }}" required autofocus placeholder="Nome de Usuário">
				<span class="glyphicon glyphicon-user form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
				<input id="password" type="password" class="form-control" name="password" placeholder="Senha" required>
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>

			<!-- /.col -->
			<div class="col-xs-12">
				<button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
			</div>
			<!-- /.col -->
		</div>
	</form>

	<div class="social-auth-links text-center">
		<p>- OU -</p>

		<a href="{{ route('cadastrar') }}" class="text-center">Cadastre-se</a>
	</div>
	<!-- /.social-auth-links -->



</div>
<!-- /.login-box-body -->
</div>
<!-- /.login-box -->


@endsection