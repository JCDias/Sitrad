<table id="todos" class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Protocolo</th>
      <th>Requerimento</th>
      <th>Acadêmico</th>
      <th>Data Solicitação</th>
      <th>Situação</th>
      <th>Opções</th>
    </tr>
  </thead>
  <tbody>
    @forelse($dados as $dado)
    <tr>
      <td>{!! $dado->getProtocolo($dado->id) !!}</td>
      <td>{!! $dado->requerimentos->tipos->name !!}</td>
      <td>{!! $dado->users->name !!}</td>
      <td>{!! $dado->formatted_created_at !!}</td>
      <td>{!! $dado->acoes->name !!}</td>
      <td>
        @if($dado->acoes->name == 'Novo')
        <a href="{{ route('solicitacoes.getPdf', $dado->id) }}" target="_blank" title="Imprimir Requerimento"> <i class="fa fa-print btn btn-primary"></i></a>
        @endif
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="{{ route('protocolo.verSolicitacao', $dado->id) }}" title="Ver solicitação."> <i class="fa fa-eye btn btn-info"></i></a>
        
        <a href="{{ route('dashboard.historico', $dado->id) }}" class="btn" title="Ver histórico"><i class="fa fa-history btn btn-success"></i></a>
      </td>
    </tr>
    @empty
    <tr>
      <td colspan="6"> Não há solicitações.</td>
    </tr>
    @endforelse
  </tbody>
</table>