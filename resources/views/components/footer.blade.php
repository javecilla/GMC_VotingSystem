<footer {{ $attributes->merge([
	'id' => 'footer',
	'data-component' => 'footer',
	'class' => '',
	'style' => '',
	])}}>
    {{ $slot }}
</footer>