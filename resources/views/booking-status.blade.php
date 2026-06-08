<x-home>
     <x-slot name="overide">
        {!! seo($overide) !!}
    </x-slot>
    
    <div class="min-h-screen max-w-screen-2xl mx-auto">
        <livewire:booking-status :code="$code"/>
    </div>
</x-home>