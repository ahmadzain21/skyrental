<div @close-modal="show = false">
    {{-- Care about people's approval and you will be their prisoner. --}}
    <form wire:submit="update" class="p-4 space-y-3">
        <div class="flex space-x-2">
            <div class="w-[80%]">
                <label for="name" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Nama
                    Bank</label>
                <input type="text" id="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="John" wire:model="name" />
                @error('name')
                    <span class="error">Nama tida bole kosong 😒</span>
                @enderror
            </div>
            <div class="flex-col">
                <x-mary-dropdown>
                    <x-slot:trigger>
                        <button
                            class="px-2 py-1 rounded text-xs font-semibold {{ $is_active === 1 ? 'bg-green-300 text-green-600' : 'bg-red-200 text-red-600' }} ">{{ $is_active === 1 ? 'active' : 'inactive' }}
                        </button>
                    </x-slot:trigger>

                    <div class="p-1">
                         <button wire:click="updateActive({{ $payment?->id}}, true)"
                            class="px-2 py-1 rounded text-xs font-semibold hover:bg-green-300 hover:text-green-600 ease-in duration-200 w-full">Active
                        </button>
                    </div>
                    <div class="p-1">
                        <button wire:click="updateActive({{ $payment?->id}}, false)"
                           class="px-2 py-1 rounded text-xs font-semibold hover:bg-red-200 hover:text-red-600 ease-in duration-200 w-full">Inactive
                       </button>
                    </div>
                </x-mary-dropdown>
            </div>
        </div>
        <div>
            <label for="icon" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Icon</label>
            @if ($icon)
                <x-mary-file wire:model="icon" accept="image/png, image/jpeg">
                    <img src="{{ $icon ? asset('storage/' . $icon) : 'https://placehold.co/600x400?text=placeholder' }}"
                        class="h-40 rounded-lg" />
                </x-mary-file>
            @endif
        </div>
        <div>
            <x-mary-textarea label="Description" wire:model="description" placeholder="Here ..." hint="Max 1000 chars"
                rows="5" />
        </div>
        <div class="w-full flex justify-end">
            <x-primary-button type="submit" wire:loading.attr="disabled">
                <div class="flex items-center space-x-1 w-full">
                    <x-icons.loading wire:loading />
                    <h2>
                        Save
                    </h2>
                </div>
            </x-primary-button>
        </div>
    </form>
</div>
