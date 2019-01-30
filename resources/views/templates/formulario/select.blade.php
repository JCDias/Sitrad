@php

//$attributes['placeholder'] = $attributes['placeholder'] ?? $label

//dd($attributes);
@endphp

<label>
	<span>{{ $label ?? $select ?? "Erro ao gerar label" }}</span>
</label>  
{!! Form::select($select, $data ?? [], ['placeholder' => 'Selecione um tipo', 'class' => 'form-control'] ) !!}