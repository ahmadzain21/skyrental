<div x-data="{
    main: false,

    setImage() {
        $dispatch('open-modal', 'add-image');
    },

    removeImg(img) {
        $dispatch('remove-img');
    }
}" @image-selected.window="main = false" @close-modal="show = false">
    <form wire:submit="save">
        <div class="p-3 min-h-[45vh] space-y-3">
            <header class="flex justify-between items-center">
                <h1 class="text-lg font-semibold">Menambahkan Slider</h1>
                <x-primary-button type="submit" class="disabled:bg-gray-600" wire:loading.attr="disabled">
                    <div class="flex items-center space-x-1 w-full">
                        <x-icons.loading wire:loading />
                        <h2>
                            Save
                        </h2>
                    </div>
                </x-primary-button>
            </header>
            <div class="space-y-2">
                <livewire:settings.set-iphone />
                <div class="space-y-1">
                    <x-input-label for="background" :value="__('Backgorund Color')" />
                    <div class="flex items-center">
                        <div class="flex items-center p-1 w-12 rounded-l-sm"
                            style="background-color: {{ $background }}">
                            <input type="color" id="background" wire:model.live="background" class="opacity-0">
                        </div>
                        <input type="text" wire:model.live="background"
                            class="py-[4.5px] w-fit focus:border-blue-500 border rounded-r-sm border-gray-300">
                    </div>
                    @error('background')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                {{-- main --}}
                <div class="space-y-2 pb-2" :class="main ? 'border-b border-gray-300' : ''">
                    <div :class="!main ? ' border-b border-b-gray-300' : ''">
                        <button type="button" @click="main = ! main"
                            class="flex space-x-4 gray w-full py-2 cursor-pointer">
                            <div>
                                <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                                    class="ease-in duration-200" :class="main ? 'rotate-180' : ''"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                    </g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path
                                            d="M15 11L12.2121 13.7879C12.095 13.905 11.905 13.905 11.7879 13.7879L9 11M7 21H17C19.2091 21 21 19.2091 21 17V7C21 4.79086 19.2091 3 17 3H7C4.79086 3 3 4.79086 3 7V17C3 19.2091 4.79086 21 7 21Z"
                                            stroke="rgb(31, 41, 55)" stroke-width="2" stroke-linecap="round">
                                        </path>
                                    </g>
                                </svg>
                            </div>
                            <div class="text-start w-full">
                                <x-input-label for="main">Main img</x-input-label>
                                @error('main')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                                @if ($main)
                                    <div class="max-w-[20%] relative">
                                        @if (Str::startsWith($main, 'http://') || Str::startsWith($main, 'https://'))
                                            <img src="{{ $main }}" alt="" srcset=""
                                                class="w-full h-14 sm:h-20 object-contain object-left">
                                        @else
                                            <img src="{{ asset('storage/' . $main) }}" alt="" srcset=""
                                                class="w-full h-14 sm:h-20 object-contain object-left">
                                        @endif
                                        <div @click="removeImg('main')"
                                            class="absolute h-5 w-5 rounded-lg flex items-center justify-center -top-3 -right-3 sm:right-0 bg-gray-400 text-white hover:bg-rose-500">
                                            x</div>
                                    </div>
                                @endif
                            </div>
                        </button>
                        <div x-cloak x-show="main" x-collapse>
                            <x-primary-button type="button" x-data
                                wire:click="setImg">{{ $main ? 'change' : 'add' }}</x-primary-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="absolute w-20 h-20 bg-red-500 right-0 top-0"></div> --}}
    </form>
</div>
