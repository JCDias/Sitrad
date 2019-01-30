@extends('dashboard.templates.template-dashboard')

@section('content-view')

<section class="content-header">

</section>

<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $title }}</div>

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

                        <form class="form-horizontal" method="POST" action="{{ route('dashboard.register') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Nome</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Nome completo" required autofocus>

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
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder='exemplo@email.com' required>

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
                                    <input id="username" type="input" class="form-control" name="username" value="{{ old('username') }}" pattern="[a-zA-Z0-9]+" title="Informe apenas letras e números." placeholder="exemplo" required>

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
                                    <input id="cpf" type="input" class="form-control" name="cpf" value="{{ old('cpf') }}" maxlength="11" placeholder="Digite apenas números." required>

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
                                    <input id="matricula" type="input" class="form-control" name="matricula" value="{{ old('matricula') }}" required>

                                    @if ($errors->has('matricula'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('matricula') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                                <label for="role" class="col-md-4 control-label">Função</label>

                                <div class="col-md-6">

                                    <select name="role" id="role" class="form-control" required>
                                        <option value="">Selecione uma função</option>
                                        @foreach($funcao_list as $funcao)
                                        <option value="{{ $funcao->id }}">{{ $funcao->label }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('role'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('curso') ? ' has-error' : '' }}">
                                <label for="curso" class="col-md-4 control-label">Curso</label>

                                <div class="col-md-6">

                                    <select name="curso" id="curso" class="form-control" required>
                                        <option value="*">Todos os cursos</option>
                                        @foreach($curso_list as $curso)
                                        <option value="{{ $curso->id }}">{{ $curso->name }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('curso'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('curso') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Senha</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>

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
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Cadastrar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection