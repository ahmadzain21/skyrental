<div x-data="{
    editFaq(id) {
        let input = document.getElementById(id);
        console.log(input)
    },
}">
    <div class="w-full flex justify-end">
        <x-primary-button class="mb-4" @click="$dispatch('open-modal', 'faq-create')">
            <div class="flex items-center space-x-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor"
                    class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4-1h-3V4a1 1 0 0 0-2 0v3H4a1 1 0 0 0 0 2h3v3a1 1 0 0 0 2 0V9h3a1 1 0 0 0 0-2z" />
                </svg>
                <h4>
                    faqs
                </h4>
            </div>
        </x-primary-button>
    </div>
    <div class="space-y-4 mb-4">
        @foreach ($faqs as $faq)
            <div class="flex items-center relative">
                <x-mary-collapse collapse-plus-minus>
                    <x-slot:heading class="bg-linear-to-r from-cyan-500 to-blue-500"
                        id="heading-{{ $faq->id }}">
                        {{ $faq->question }}

                    </x-slot:heading>
                    <x-slot:content class="bg-primary/10">
                        <div class="mt-5">{{ $faq->answer }}</div>
                    </x-slot:content>
                </x-mary-collapse>
                <div class="absolute -top-2 -left-4">
                    <button wire:click="toggleStatus({{ $faq->id }}, {{ $faq->is_active }})"
                        class="px-3 py-1 rounded text-xs font-semibold 
        {{ $faq->is_active ? 'bg-green-200 text-green-600 hover:bg-green-500' : 'bg-red-200 text-red-600 hover:bg-red-500' }}" wire:loading.attr="disabled">
                        {{ $faq->is_active ? 'Enable' : 'Disable' }}
                    </button>

                </div>

                <div>
                    <x-mary-dropdown>
                        <x-slot:trigger>
                            <button type="button">
                                <svg fill="#000000" width="20px" height="20px" viewBox="0 0 32 32" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path
                                            d="M12.15 28.012v-0.85c0.019-0.069 0.050-0.131 0.063-0.2 0.275-1.788 1.762-3.2 3.506-3.319 1.95-0.137 3.6 0.975 4.137 2.787 0.069 0.238 0.119 0.488 0.181 0.731v0.85c-0.019 0.056-0.050 0.106-0.056 0.169-0.269 1.65-1.456 2.906-3.081 3.262-0.125 0.025-0.25 0.063-0.375 0.094h-0.85c-0.056-0.019-0.113-0.050-0.169-0.056-1.625-0.262-2.862-1.419-3.237-3.025-0.037-0.156-0.081-0.3-0.119-0.444zM20.038 3.988l-0 0.85c-0.019 0.069-0.050 0.131-0.056 0.2-0.281 1.8-1.775 3.206-3.538 3.319-1.944 0.125-3.588-1-4.119-2.819-0.069-0.231-0.119-0.469-0.175-0.7v-0.85c0.019-0.056 0.050-0.106 0.063-0.162 0.3-1.625 1.244-2.688 2.819-3.194 0.206-0.069 0.425-0.106 0.637-0.162h0.85c0.056 0.019 0.113 0.050 0.169 0.056 1.631 0.269 2.863 1.419 3.238 3.025 0.038 0.15 0.075 0.294 0.113 0.437zM20.037 15.575v0.85c-0.019 0.069-0.050 0.131-0.063 0.2-0.281 1.794-1.831 3.238-3.581 3.313-1.969 0.087-3.637-1.1-4.106-2.931-0.050-0.194-0.094-0.387-0.137-0.581v-0.85c0.019-0.069 0.050-0.131 0.063-0.2 0.275-1.794 1.831-3.238 3.581-3.319 1.969-0.094 3.637 1.1 4.106 2.931 0.050 0.2 0.094 0.394 0.137 0.588z">
                                        </path>
                                    </g>
                                </svg>

                            </button>
                        </x-slot:trigger>
                        <button
                            @click="() => {
                            $dispatch('open-modal', 'faq-edit');
                            $dispatch('edit', { value: {{ $faq->id }} });    
                        }"
                            class="w-full">
                            <x-mary-menu-item title="edit" />

                        </button>
                        <button wire:click="destroyAlert({{ $faq->id }}, 'delete')" class="w-full">
                            <x-mary-menu-item title="delete" />
                        </button>
                    </x-mary-dropdown>

                </div>

            </div>
        @endforeach
    </div>
    <x-modal name="faq-create" :show="$errors->isNotEmpty()">
        <livewire:faq.create />
    </x-modal>
    <x-modal name="faq-edit" :show="$errors->isNotEmpty()">
        <livewire:faq.edit />
    </x-modal>
    {{-- The Master doesn't talk, he acts. --}}
</div>
