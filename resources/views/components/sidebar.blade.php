<aside {{ $attributes->merge([
	'id' => 'sidebar',
	'data-component' => 'sidebar',
	'class' => '',
	'style' => '',
	])}}>
    {{ $slot }}
</aside>