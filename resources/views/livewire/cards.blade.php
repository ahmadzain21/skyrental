<div class="mt-10 p-3" wire:init="getIphones">
    <div>
        {{-- Title --}}
        <h2
            class="text-2xl lg:text-5xl font-extrabold font-neulis leading-tight
               text-gray-900 dark:text-gray-100">
            {{ $title }}<span class="text-orange-500">.</span>
        </h2>

        {{-- Grid --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-x-3 gap-y-8 mt-6 lg:mt-12">

            @empty(!$iphones)
                @forelse ($iphones as $iphone)
                    <!-- Card -->
                    <div
                        class="group rounded-[28px] p-3 flex flex-col
                           bg-white dark:bg-gray-800
                           shadow-md dark:shadow-none
                           hover:shadow-xl dark:hover:shadow-lg
                           transition">

                        {{-- Image --}}
                        <div class="flex justify-center items-center mb-4 h-64">
                            <img data-src="{{ asset('storage/' . $iphone->gallery->image) }}" alt="{{ $iphone->name }}"
                                class="lazy max-h-full object-contain
                                   group-hover:scale-105 transition duration-300">
                        </div>

                        {{-- Content --}}
                        <div class="text-center flex flex-col flex-1">
                            <h3
                                class="text-base lg:text-lg font-medium font-neulis mb-1
                                   text-gray-900 dark:text-gray-100">
                                {{ $iphone->name }}
                            </h3>

                            {{-- optional subtitle --}}
                            {{-- <p class="text-sm mb-4 text-gray-500 dark:text-gray-400">
                                {{ $iphone->serial_number }}
                            </p> --}}

                            {{-- CTA --}}
                            <a href="{{ route('detail', $iphone->slug) }}" wire:navigate
                                class="mt-auto inline-flex items-center justify-center w-full py-3 rounded-xl
                                   text-sm font-medium font-neulis
                                   bg-slate-900 text-white
                                   hover:bg-orange-500 transition

                                   dark:bg-gray-100 dark:text-gray-900
                                   dark:hover:bg-orange-500 dark:hover:text-white">
                                Sewa Sekarang →
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-center col-span-4
                           text-gray-500 dark:text-gray-400"
                        wire:loading.remove>
                        No iPhones available at the moment.
                    </p>
                @endforelse
            @endempty

            {{-- Loading Spinner --}}
            <div class="w-full min-h-[50vh] flex justify-center items-center col-span-4" wire:loading.flex>

                <svg width="64" height="64" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="none"
                    class="animate-spin
                       text-rose-500 dark:text-orange-400">

                    <g fill="currentColor" fill-rule="evenodd" clip-rule="evenodd">
                        <path d="M8 1.5a6.5 6.5 0 100 13 6.5 6.5 0 000-13zM0 8a8 8 0 1116 0A8 8 0 010 8z"
                            opacity=".2" />
                        <path
                            d="M7.25.75A.75.75 0 018 0a8 8 0 018 8 .75.75 0 01-1.5 0A6.5 6.5 0 008 1.5a.75.75 0 01-.75-.75z" />
                    </g>
                </svg>

                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</div>
