<section {{ $attributes->merge([
	'data-aos' => 'fade-in',
	'data-app' => request()->route('version'),
	'data-iurl' => '',
	'data-component' => '',
	'id' => '',
	'class' => 'app-content',
	'style' => '',
	])}}>
    {{ $slot }}
</section>