<div class="p-3 space-y-3" @re-render.window="show = false">
    <header class="flex justify-between items-center">
        <h1 class="text-lg font-semibold">Menambahkan Genre</h1>
    </header>
    <form wire:submit="save">
        <div class="space-y-3">
            <div class="w-full">
                <x-input-label :value="__('Username')" for="name" />
                <input type="text" id="name"
                    class="border-x-0 border-t-0 w-full placeholder:text-gray-400 border-b-2 border-b-gray-300 focus:ring-0 py-2 px-1 focus:border-t-0"
                    wire:model="name">
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="w-full">
                <x-input-label :value="__('Email')" for="email" />
                <input type="email" id="email"
                    class="border-x-0 border-t-0 w-full placeholder:text-gray-400 border-b-2 border-b-gray-300 focus:ring-0 py-2 px-1 focus:border-t-0"
                    wire:model="email">
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="w-full">
                <x-input-label :value="__('Password')" for="email" />
                <input type="password" id="password"
                    class="border-x-0 border-t-0 w-full placeholder:text-gray-400 border-b-2 border-b-gray-300 focus:ring-0 py-2 px-1 focus:border-t-0"
                    wire:model="password">
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <x-primary-button type="submit" class="mt-3 disabled:bg-gray-600" wire:loading.attr="disabled">
            <div class="flex items-center space-x-1 w-full">
                <x-icons.loading wire:loading />
                <h2>
                    Save
                </h2>
            </div>
        </x-primary-button>
    </form>
</div>
