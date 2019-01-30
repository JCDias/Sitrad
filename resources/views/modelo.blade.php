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
  <div class="container">
    <div class="row">

      Conteúdo Can

    </div>
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


