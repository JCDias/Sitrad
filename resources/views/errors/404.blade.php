@extends('templates.painel')

@section('content-view')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

	<!-- Main content -->
	<section class="content">
		<div class="error-page">
			<h2 class="headline text-yellow"> 404</h2>

			<div class="error-content">
				<h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>

				<p>
					Não foi possível encontrar a página que você estava procurando.
				</p>
				<p>
					<a href="{{ route('painel.index') }}" class="btn btn-primary">Retornar para a página inicial</a>.
				</p>
			</div>
			<!-- /.error-content -->
		</div>
		<!-- /.error-page -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection()

