@php

	$attributes['placeholder'] = $attributes['placeholder'] ?? $label

@endphp

{!! Form::text($input, $value ?? null, $attributes) !!}

{{-- <label class="{{ $class ?? null }}">
	<span>{{ $label ?? $input ?? "Erro ao gerar label" }}</span>
	{!! Form::text($input, $value ?? null, $attributes) !!}
</label>  --}}