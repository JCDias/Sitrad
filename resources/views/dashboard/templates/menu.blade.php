 <!-- sidebar menu: : style can be found in sidebar.less -->
 <ul class="sidebar-menu" data-widget="tree">
  <li class="header">PRINCIPAL</li>
  <li>
    <a href="{{ route('dashboard.index') }}">
      <i class="fa fa-home"></i> <span>Início</span>
    </a>
  </li>
  <li class="header">REQUERIMENTOS</li>
  @can('solicitar_requerimento')
  <li>
    <a href="{{ route('solicitacoes.index') }}">
      <i class="fa fa-edit"></i> <span>Solicitar Requerimento</span>
    </a>
  </li>
  <li>
    <a href="{{ route('dashboard.todos') }}">
      <i class="fa fa-search"></i> <span>Consultar Requerimentos</span>
    </a>
  </li>
  @endcan
  @can('protocolo')
  <li>
    <a href="{{ route('protocolo.index') }}">
      <i class="fa fa-check-square-o"></i> <span>Protocolar Requerimento</span>
    </a>
  </li>
  @endcan
  @can('consultar_requerimento')
  <li>
    <a href="{{ route('dashboard.todos') }}">
      <i class="fa fa-search"></i> <span>Consultar Requerimentos</span>
    </a>
  </li>
  @endcan

  {{-- Filtrando menu --}}
  @can('gestao_requerimento')
  <li>
    <a href="{{ route('requerimentos.index') }}">
      <i class="fa fa-gears"></i> <span>Gerenciar Requerimentos</span>
    </a>
  </li>
  @endcan

  {{-- Filtrando menu --}}
  @can('gestao_user')
  <li class="header">GESTÃO DE USUÁRIOS</li>
  <li>
    <a href="{{ route('dashboard.user') }}">
      <i class="fa fa-users"></i> <span>Usuários</span>
    </a>
  </li>
  <li>
    <a href="{{ route('permission.index') }}">
      <i class="fa fa-unlock-alt"></i> <span>Permissões</span>
    </a>
  </li>
  <li>
    <a href="{{ route('roles.index') }}">
      <i class="fa fa-list-alt"></i> <span>Funções</span>
    </a>
  </li>
  @endcan

  <li class="header">OPÇÕES</li>
  <li>
    <a href="{{ route('dashboard.perfil') }}">
      <i class="fa fa-user"></i> <span>Perfil</span>
    </a>
  </li>
  <li>
    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
      <i class="fa fa-power-off"></i> <span>Sair</span>
    </a>
  </li>
</ul>



<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
  {{ csrf_field() }}
</form> 