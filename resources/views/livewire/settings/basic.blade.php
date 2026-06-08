<div class="sm:w-2/3 w-full" x-data="{
    logo_cms: false,
    logo: false,
    favicon: false,
    how_to_rent: false,

    setImage(img) {
        $dispatch('wich-image', { props: img });
        $dispatch('open-modal', 'add-logo');
    },

    removeImg(img) {
        $dispatch('wich-image', { props: img });
        $dispatch('remove-img');
    }
}">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Setelan dasar') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Perbarui setelan website kamu disini') }}
        </p>
    </header>
    <form wire:submit="update" class="mt-6 space-y-6">
        
        <div>
            <x-input-label for="site_name" :value="__('Nama website')" />
            <x-text-input wire:model="site_name" id="site_name" name="site_name" type="text" class="mt-1 block w-full"
                required autofocus autocomplete="site_name" />
            <x-input-error class="mt-2" :messages="$errors->get('site_name')" />
        </div>
        <div>
            <x-input-label for="tagline" :value="__('Tagline')" />
            <x-text-input wire:model="tagline" id="tagline" name="tagline" type="text" class="mt-1 block w-full"
                required autofocus autocomplete="tagline" />
            <x-input-error class="mt-2" :messages="$errors->get('tagline')" />
        </div>
        <div>
            <x-input-label for="description" :value="__('Deskripsi website')" />
            <textarea id="description" rows="4"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Write your description here..." wire:model="description"></textarea>

            <x-input-error class="mt-2" :messages="$errors->get('site_description')" />

        </div>
        <div>
            <x-input-label for="colorPicker" :value="__('Primary color')" />
            <div class="flex items-center">
                <div class="flex items-center p-1 w-12 rounded-l-sm" style="background-color: {{ $primary_color }}">
                    <input type="color" id="colorPicker" wire:model.live="primary_color" class="opacity-0">
                </div>
                <input type="text" wire:model.live="primary_color"
                    class="py-[4.5px] w-fit focus:border-blue-500 border rounded-r-sm border-gray-300">
            </div>
        </div>
        {{-- logo cms --}}
        <div>
            <div class="space-y-2 pb-2" :class="logo_cms ? 'border-b border-gray-300' : ''">
                <div :class="!logo_cms ? ' border-b border-b-gray-300' : ''">
                    <button type="button" @click="logo_cms = ! logo_cms"
                        class="flex space-x-4 gray w-full py-2 cursor-pointer">
                        <div>
                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                                class="ease-in duration-200" :class="logo_cms ? 'rotate-180' : ''"
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
                            <div class="flex space-x-2 items-center">
                                <x-input-label id="logo" for="logo_cms">Logo cms</x-input-label>
                                <p class="font-comicBold text-sm text-gray-500">recomended 56px * 144 px</p>
                            </div>
                            @error('logo_cms')
                                <span class="error">{{ $message }}</span>
                            @enderror
                            @if ($logo_cms)
                                <div class="max-w-[20%] relative">
                                    @if (Str::startsWith($logo_cms, 'http://') || Str::startsWith($logo_cms, 'https://'))
                                        <img src="{{ $logo_cms }}" alt="" srcset=""
                                            class="w-full h-14 sm:h-20 object-contain object-left">
                                    @else
                                        <img src="{{ asset('storage/' . $logo_cms) }}" alt="" srcset=""
                                            class="w-full h-14 sm:h-20 object-contain object-left">
                                    @endif
                                    <div @click="removeImg('logo_cms')"
                                        class="absolute h-5 w-5 rounded-lg flex items-center justify-center -top-3 -right-3 sm:right-0 bg-gray-400 text-white hover:bg-rose-500">
                                        x</div>
                                </div>
                            @endif
                        </div>
                    </button>
                    <div x-show="logo_cms" x-collapse>
                        <x-primary-button type="button" x-data
                            x-on:click="setImage('logo_cms')">{{ $logo_cms ? 'change' : 'add' }}</x-primary-button>
                    </div>
                </div>
            </div>
        </div>
        {{-- logo --}}
        <div>
            <div class="space-y-2 pb-2" :class="logo ? 'border-b border-gray-300' : ''">
                <div :class="!logo ? ' border-b border-b-gray-300' : ''">
                    <button type="button" @click="logo = ! logo"
                        class="flex space-x-4 gray w-full py-2 cursor-pointer">
                        <div>
                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                                class="ease-in duration-200" :class="logo ? 'rotate-180' : ''"
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
                            <div class="flex space-x-2">
                                <x-input-label for="logo">Logo web</x-input-label>
                                <p class="font-comicBold text-sm text-gray-500">recomended 56px * 144 px</p>
                            </div>
                            @error('logo')
                                <span class="error">{{ $message }}</span>
                            @enderror
                            @if ($logo)
                                <div class="max-w-[20%] relative">
                                    @if (Str::startsWith($logo, 'http://') || Str::startsWith($logo, 'https://'))
                                        <img src="{{ $logo }}" alt="" srcset=""
                                            class="w-full h-14 sm:h-20 object-contain object-left">
                                    @else
                                        <img src="{{ asset('storage/' . $logo) }}" alt="" srcset=""
                                            class="w-full h-14 sm:h-20 object-contain object-left">
                                    @endif
                                    <div @click="removeImg('logo')"
                                        class="absolute h-5 w-5 rounded-lg flex items-center justify-center -top-3 -right-3 sm:right-0 bg-gray-400 text-white hover:bg-rose-500">
                                        x</div>
                                </div>
                            @endif
                        </div>
                    </button>
                    <div x-show="logo" x-collapse>
                        <x-primary-button type="button" x-data
                            x-on:click="setImage('logo')">{{ $logo ? 'change' : 'add' }}</x-primary-button>
                    </div>
                </div>
            </div>
        </div>
        {{-- favicon --}}
        <div>
            <div class="space-y-2 pb-2" :class="favicon ? 'border-b border-gray-300' : ''">
                <div :class="!favicon ? ' border-b border-b-gray-300' : ''">
                    <button type="button" @click="favicon = ! favicon"
                        class="flex space-x-4 gray w-full py-2 cursor-pointer">
                        <div>
                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                                class="ease-in duration-200" :class="favicon ? 'rotate-180' : ''"
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
                            <div class="flex space-x-2">
                                <x-input-label for="favicon">favicon</x-input-label>
                                <p class="font-comicBold text-sm text-gray-500">recomended 100px * 100 px</p>
                            </div>
                            @error('favicon')
                                <span class="error">{{ $message }}</span>
                            @enderror
                            @if ($favicon)
                                <div class="max-w-[20%] relative">
                                    @if (Str::startsWith($favicon, 'http://') || Str::startsWith($favicon, 'https://'))
                                        <img src="{{ $favicon }}" alt="" srcset=""
                                            class="w-full h-14 sm:h-20 object-contain object-left">
                                    @else
                                        <img src="{{ asset('storage/' . $favicon) }}" alt="" srcset=""
                                            class="w-full h-14 sm:h-20 object-contain object-left">
                                    @endif
                                    <div @click="removeImg('favicon')"
                                        class="absolute h-5 w-5 rounded-lg flex items-center justify-center -top-3 -right-3 sm:right-0 bg-gray-400 text-white hover:bg-rose-500">
                                        x</div>
                                </div>
                            @endif
                        </div>
                    </button>
                    <div x-show="favicon" x-collapse>
                        <x-primary-button type="button" x-data
                            x-on:click="setImage('favicon')">{{ $favicon ? 'change' : 'add' }}</x-primary-button>
                    </div>
                </div>
            </div>
        </div>
   
        
        {{-- IZIN --}}
        <div>
            <div>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Izin') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Beri izin siapa saja yang dapat merubah website') }}
                </p>
            </div>
            <button type="button" class="mt-4" @click="$dispatch('open-modal', 'set-permission')">
                <h2 class="font-medium">
                    Admin dan Penulis Blog
                </h2>
                <div class="text-gray-400">
                    Super admin dan 1 lainya
                </div>
            </button>
        </div>
        <div class="flex items-center gap-4">
            <x-primary-button type="submit" class="disabled:bg-gray-600" wire:loading.attr="disabled">
                <div class="flex items-center space-x-1 w-full">
                    <x-icons.loading wire:loading />
                    <h2>
                        Save
                    </h2>
                </div>
            </x-primary-button>
        </div>
    </form>
    <x-modal name="set-permission" :show="$errors->isNotEmpty()" maxWidth="lg">
        <livewire:settings.permissions />
    </x-modal>
    <x-modal name="add-logo" :show="$errors->isNotEmpty()">
        <livewire:galleries.gallery />
    </x-modal>

</div>
