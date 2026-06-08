<div class="space-y-6">
    @foreach($iphones as $iphone)
        <div class="p-4 border rounded-lg shadow-sm">
            <h2 class="text-xl font-bold">{{ $iphone->name }}</h2>
            <p class="text-gray-600">{{ $iphone->description }}</p>

            <h3 class="mt-2 font-semibold">Harga per Durasi:</h3>
            <ul class="list-disc list-inside">
                @foreach($iphone->durations as $duration)
                    <li>
                        {{ $duration->hours }} jam
                        - Rp{{ number_format($duration->pivot->price, 0, ',', '.') }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>
