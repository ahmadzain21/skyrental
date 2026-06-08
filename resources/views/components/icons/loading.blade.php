@props(['default' => '14px'])

<svg width="{{ $default }}" height="{{ $default }}" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="none" {{ $attributes->merge(['class' => 'animate-spin']) }}>
    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
    <g id="SVGRepo_iconCarrier">
        <g fill="#ffffff" fill-rule="evenodd" clip-rule="evenodd">
            <path d="M8 1.5a6.5 6.5 0 100 13 6.5 6.5 0 000-13zM0 8a8 8 0 1116 0A8 8 0 010 8z" opacity=".2">
            </path>
            <path d="M7.25.75A.75.75 0 018 0a8 8 0 018 8 .75.75 0 01-1.5 0A6.5 6.5 0 008 1.5a.75.75 0 01-.75-.75z">
            </path>
        </g>
    </g>
</svg>
