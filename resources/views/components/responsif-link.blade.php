@props([
    'active' => false,
])

<li class=" {{ $active ? 'text-orange-500 dark:underline font-medium font-neulis' : '' }}">
    <a {{ $attributes->merge([
            'class' => 'block',
            '@click' => 'setNav = false'
        ]) }}>
            {{ $slot }}
    </a>
</li>
