@props(['bgIcon' => 'bg-gray-900'])

<div class="w-full h-32 bg-white shadow-xl relative flex items-center px-3">
    <div class="p-2 rounded-md -top-5 left-5 absolute {{ $bgIcon }}">
        {{ $icon ?? null }}
    </div>
    <div class="w-full flex flex-col items-end  font-medium">
        <h1 class="text-gray-500 text-base">{{ $title ?? null }}</h1>
        <h4 class="text-xl">{{ $value ?? null }}</h4>
    </div>
</div>