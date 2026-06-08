@props([
    'rating' => 0, // nilai 0-5 (boleh desimal, misalnya 4.5)
    'max' => 5,    // default 5 bintang
    'size' => 'w-5 h-5 text-yellow-400', // ukuran + warna
])

<div class="flex items-center">
    @for ($i = 1; $i <= $max; $i++)
        @if ($i <= floor($rating))
            {{-- Bintang penuh --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                class="{{ $size }}">
                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
            </svg>
        @elseif ($i - $rating <= 0.5)
            {{-- Bintang setengah --}}
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                class="{{ $size }}">
                <defs>
                    <linearGradient id="half">
                        <stop offset="50%" stop-color="currentColor"/>
                        <stop offset="50%" stop-color="transparent"/>
                    </linearGradient>
                </defs>
                <path fill="url(#half)" stroke="currentColor" stroke-width="1"
                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 
                       9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
            </svg>
        @else
            {{-- Bintang kosong --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" class="text-yellow-400 w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.928 5.918a1 1 0 00.95.69h6.214
                       c.969 0 1.371 1.24.588 1.81l-5.034 3.66a1 1 0 00-.364 1.118l1.928 
                       5.918c.3.921-.755 1.688-1.54 1.118l-5.034-3.66a1 1 
                       0 00-1.175 0l-5.034 3.66c-.784.57-1.838-.197-1.539-1.118
                       l1.928-5.918a1 1 0 00-.364-1.118l-5.034-3.66c-.783-.57
                       -.38-1.81.588-1.81h6.213a1 1 0 00.951-.69l1.928-5.918z"/>
            </svg>
        @endif
    @endfor
</div>

