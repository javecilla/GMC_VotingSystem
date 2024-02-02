<main {{ $attributes->merge([
	'id' => 'main',
	'data-component' => 'main',
	'class' => '',
	'style' => '',
	])}}>
    {{ $slot }}
</main>