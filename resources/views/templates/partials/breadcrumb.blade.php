
<ol class="breadcrumb">
	@foreach($segments = request()->segments() as $index => $segment)

	<li>
		<a href="{{ url(implode(array_slice($segments, 0, $index), '/')) }}">
			{{ title_case($segment) }}
		</a>
	</li>

	@endforeach
</ol>
