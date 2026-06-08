<x-home>
    <x-slot name="overide">
        {!! seo($overide) !!}
    </x-slot>
    <livewire:detail :iphone="$iphone" :date="$date" :hour="$hour" :minute="$minute" />
</x-home>
