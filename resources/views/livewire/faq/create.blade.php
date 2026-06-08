<div class="p-3" @close-modal="show = false">
    {{-- Success is as dangerous as failure. --}}
    <form wire:submit="save">
        <div>
            <x-input-label for="question" :value="__('Question')" />
            <x-text-input wire:model="question" id="question" name="question" type="text" class="mt-1 block w-full"
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('question')" class="mt-2" />
        </div>
        <div>
            <x-mary-textarea label="Answer" wire:model="answer" placeholder="Here ..." hint="Max 1000 chars"
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
