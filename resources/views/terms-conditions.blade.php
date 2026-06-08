<x-home>
    <x-slot name="overide">
        {!! seo($overide) !!}
    </x-slot>
    <div class="max-w-screen-xl mx-auto p-4">
        <div
            class="prose prose-base lg:prose-lg prose-invert prose-p:text-black prose-li:text-black prose-a:text-blue-600 max-w-none">
            {!! $terms_conditions !!}
        </div>
    </div>

</x-home>
