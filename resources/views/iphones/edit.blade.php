<x-create>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('New iPhone') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="lg:max-w-[77vw] max-w-4xl sm:px-6 lg:px-8 flex justify-center">
            <div class="bg-white lg:w-3/4 w-full dark:bg-gray-800 shadow-sm sm:rounded-md min-h-[64vh]">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <livewire:iphones.edit :iphone="$iphone" />
                </div>
            </div>
        </div>
    </div>
</x-create>