<style>
.example-modal .modal {
	position: relative;
	top: auto;
	bottom: auto;
	right: auto;
	left: auto;
	display: block;
	z-index: 1;
}

.example-modal .modal {
	background: transparent !important;
}
</style>


<div class="modal fade" id="modal-logout">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Deseja realmente sair?</h4>
				</div>
				
				<div class="modal-footer">
					<form id="logout-form" action="{{ route('logout') }}" method="POST">
						{{ csrf_field() }}
						<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Não</button>
						<button type="submit" class="btn btn-primary">Sim</button>
					</form>
				</div>
				
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
