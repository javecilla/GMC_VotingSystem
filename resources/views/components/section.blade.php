<section {{ $attributes->merge([
	'id' => '',
	'data-app' => request()->route('version'),
	'data-component' => '',
	'class' => 'app-content',
	'style' => '',
	])}}>
    {{ $slot }}
</section>