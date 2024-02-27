<main {{ $attributes->merge([
	'id' => 'main',
	'data-component' => 'main',
	'data-vrequest' => request()->route('version'),
	'class' => '',
	'style' => '',
	])}}>
    {{ $slot }}
</main>