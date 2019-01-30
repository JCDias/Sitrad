@extends('dashboard.templates.template-dashboard')

@section('content-view')

<!-- Sessão de cabeçalho -->
<section class="content-header">

  <h1>Dados de Perfil</h1>

  {{-- Incluir breadcrumb --}}
  @include('templates.partials.breadcrumb')

  @if(session('success'))
  <br>
  <div class="callout callout-{{ session('success')['class'] }}">
    <h4>{{ session('success')['messages'] }}</h4>
  </div>
  <br>
  @endif

</section>

<!-- Fim Sessão de cabeçalho -->


<!-- Sessão de Conteúdo da página -->
<section class="content">
  <div class="container">
    <div class="row">

      <table class="table table-bordered table-striped">
        <tbody>
          <tr>
            <td style="width: 15%;text-align: right;"><h4><b>Nome:</b></h4></td>
            <td><h4>{{ Auth::User()->name }}</h4></td>
          </tr>
          <tr>
            <td style="width: 15%;text-align: right;"><h4><b>CPF:</b></h4></td>
            <td><h4>{{ Auth::User()->formatted_cpf }}</h4></td>
          </tr>
          <tr>
            <td style="width: 15%;text-align: right;"><h4><b>Matrícula:</b></h4></td>
            <td><h4>{{ Auth::User()->matricula }}</h4></td>
          </tr>
          <tr>
            <td style="width: 15%;text-align: right;"><h4><b>E-mail:</b></h4></td>
            <td><h4>{{ Auth::User()->email }}</h4></td>
          </tr>
          <tr>
            <td style="width: 15%;text-align: right;"><h4><b>Nome de Usuário:</b></h4></td>
            <td><h4>{{ Auth::User()->username }}</h4></td>
          </tr>
          <tr>
            <td style="width: 15%;text-align: right;"><h4><b>Funções:</b></h4></td>
            <td>
              <ul>
                @foreach($roles as $role)
                  <li><h4>{{ $role->label }}</h4></li>
                @endforeach
              </ul>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="pull-left">
          <a href="{{ route('dashboard.index') }}" class="btn btn-lg btn-default">Voltar</a>
      </div>
      <div class="text-center">
        <a href="{{ route('dashboard.editPerfil', Auth::User()->id ) }}" class="btn btn-lg btn-success">Editar</a>
      </div>
    </div>
  </div>
</section>
<!-- Fim Sessão de Conteúdo da página -->

@endsection


