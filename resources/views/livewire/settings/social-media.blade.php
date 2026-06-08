<div>
    {{-- Social Media --}}
    <form wire:submit="save" class="space-y-4 pb-4">
        <div class="text-start">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Sosial Media') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Link Sosial Media') }}
            </p>
        </div>
        <div>
            <x-input-label for="tiktok" :value="__('Tiktok')" />
            <x-text-input wire:model="tiktok" id="tiktok" name="tiktok" type="text" class="mt-1 block w-full" 
                autofocus autocomplete="tiktok" placeholder="tiktok.com" />
            <x-input-error class="mt-2" :messages="$errors->get('tiktok')" />
        </div>
        <div>
            <x-input-label for="instagram" :value="__('Instagram')" />
            <x-text-input wire:model="instagram" id="instagram" name="instagram" type="text"
                class="mt-1 block w-full"  autofocus autocomplete="instagram" placeholder="instagram.com" />
            <x-input-error class="mt-2" :messages="$errors->get('instagram')" />
        </div>
        <div>
            <x-input-label for="facebook" :value="__('Facebook')" />
            <x-text-input wire:model="facebook" id="facebook" name="facebook" type="text" class="mt-1 block w-full"
                 autofocus autocomplete="facebook" placeholder="facebook.com" />
            <x-input-error class="mt-2" :messages="$errors->get('facebook')" />
        </div>
        <div>
            <x-input-label for="whatsapp" :value="__('Whatsapp')" />
            <x-text-input wire:model="whatsapp" id="whatsapp" name="whatsapp" type="text" class="mt-1 block w-full"
                 autofocus autocomplete="whatsapp" placeholder="wa.me/628xxxxxxxxx" />
            <x-input-error class="mt-2" :messages="$errors->get('whatsapp')" />
        </div>
        <div>
            <x-input-label for="youtube" :value="__('Youtube')" />
            <x-text-input wire:model="youtube" id="youtube" name="youtube" type="text" class="mt-1 block w-full"
                 autofocus autocomplete="youtube" placeholder="youtube.com" />
            <x-input-error class="mt-2" :messages="$errors->get('youtube')" />
        </div>
        <div>
            <x-input-label for="telegram" :value="__('Telegrem')" />
            <x-text-input wire:model="telegram" id="telegram" name="telegram" type="text" class="mt-1 block w-full"
                 autofocus autocomplete="telegram" placeholder="telegram.com" />
            <x-input-error class="mt-2" :messages="$errors->get('telegram')" />
        </div>
        <div>
            <x-input-label for="twitter" :value="__('Twitter')" />
            <x-text-input wire:model="twitter" id="twitter" name="twitter" type="text" class="mt-1 block w-full"
                 autofocus autocomplete="twitter" placeholder="x.com" />
            <x-input-error class="mt-2" :messages="$errors->get('twitter')" />
        </div>
         <x-primary-button type="submit" class="disabled:bg-gray-600" wire:loading.attr="disabled">
            <div class="flex items-center space-x-1 w-full">
                <h2>
                    Save
                </h2>
            </div>
        </x-primary-button>
    </form>
</div>
