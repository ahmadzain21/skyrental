@props(['active'])

@php
$classes = ($active ?? false)
            ? 'p-2 border-b-2 border-orange-500 dark:border-slate-200 text-slate-900 dark:text-slate-200 font-medium font-neulis hover:bg-slate-100 dark:hover:bg-slate-800 transition duration-150 ease-in-out'
            : '';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
