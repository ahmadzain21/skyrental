@props([
    'id' => 'bottomSheet',
    'title' => null,
    'glass' => 'bg-white/20 dark:bg-gray-800/30 
            backdrop-blur-xl border border-white/20 
            rounded-2xl shadow-xl'
])

<div 
    x-data="{ open: false }" 
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 flex items-end justify-center sm:hidden"
    id="{{ $id }}"
    @open-bottom-sheet.window="
        if ($event.detail.id === '{{ $id }}') {
            open = true
        }
    "
>
    <!-- Overlay -->
    <div 
        class="absolute inset-0 bg-black/30 "
        @click="open = false"
    ></div>

    <!-- Bottom Sheet Container -->
    <div 
        class="relative w-full {{ $glass }} rounded-t-2xl p-3 shadow-lg transform transition-all duration-300 overflow-y-auto max-h-[90vh] "
        x-show="open"
        x-transition:enter="translate-y-full"
        x-transition:enter-end="translate-y-0"
        x-transition:leave="translate-y-0"
        x-transition:leave-end="translate-y-full"
    >
        <!-- Tombol close -->
        <button 
            class="absolute top-2 right-2 text-gray-500"
            @click="open = false"
        >
            ✕
        </button>

        <!-- Slot isi konten -->
        {{ $slot }}
    </div>
</div>

