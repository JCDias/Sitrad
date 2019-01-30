<label class="{{ $class ?? null }}">
	<span>{{ $label ?? $input ?? "Erro ao gerar label" }}</span>
	{!! Form::password($input, $attributes) !!}
</label>