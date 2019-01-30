@extends('templates.painel')

@section('content-view')

<section class="content-header">
	@if(session('success'))
	<div class="callout callout-{{ session('success')['class'] }}">
		<h4>{{ session('success')['messages'] }}</h4>
	</div>
	@endif
</section>

<section class="content">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">Login</div>

					<div class="panel-body">
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
						<form class="form-horizontal" method="POST" action="{{ route('login') }}">
							{{ csrf_field() }}

							<div class="form-group{{ $errors->has("username") ? ' has-error' : '' }}">
								<label for="username" class="col-md-4 control-label">Nome de Usuário</label>

								<div class="col-md-6">
									<input id="username" type="input" class="form-control" name="username" value="{{ old("username") }}" required autofocus>
								</div>
							</div>

							<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
								<label for="password" class="col-md-4 control-label">Senha</label>

								<div class="col-md-6">
									<input id="password" type="password" class="form-control" name="password" required>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-8 col-md-offset-4">
									<button type="submit" class="btn btn-primary">
										Login
									</button>
								</div>
							</div>
						</form>
					</div>
					<div class="social-auth-links text-center">
						<a href="{{ route('cadastrar') }}" class="text-center">Cadastre-se</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


@endsection