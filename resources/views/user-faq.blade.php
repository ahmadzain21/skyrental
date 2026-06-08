<x-home>
    <div class="space-y-4 max-w-4xl mx-auto mt-5 p-3 sm:p-0">
        <div class="text-lg font-semibold">
            FAQ
        </div>
        @foreach ($faqs as $faq)
            <div class="flex items-center relative">
                <x-mary-collapse collapse-plus-minus>
                    <x-slot:heading class="bg-linear-to-r from-cyan-500 to-blue-500" id="heading-{{ $faq->id }}">
                        {{ $faq->question }}

                    </x-slot:heading>
                    <x-slot:content class="bg-primary/10">
                        <div class="mt-5">{{ $faq->answer }}</div>
                    </x-slot:content>
                </x-mary-collapse>
            </div>
        @endforeach
    </div>
</x-home>
