<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>
<div x-data="{
    logout() {
        $dispatch('open-modal', 'logout')
    }
}">
    <div @click="logout"
        class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-200 cursor-pointer transition rounded-lg text">
        <!-- Icon Logout -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
        </svg>

        <!-- Label -->
        <span class="text-red-500 text-lg">Logout</span>
    </div>
    <x-modal name="logout" :show="$errors->isNotEmpty()">
        <div class="p-3">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to log out?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once you log out, you will need to enter your credentials again to access your account.') }}
            </p>

            <div class="mt-6 flex justify-end space-x-2">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button type="submit" wire:click="logout">
                    {{ __('Log Out') }}
                </x-danger-button>
            </div>
        </div>

    </x-modal>

</div>
