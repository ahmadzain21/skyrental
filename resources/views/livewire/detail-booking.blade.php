<div class="max-w-4xl mx-auto p-4 space-y-6" @close-modal="show = false">
    <div class="bg-white rounded-xl shadow-sm p-5 sm:p-6 space-y-6">

        {{-- HEADER --}}
        <div class="flex items-start justify-between gap-3 ">
            <div>
                <h1 class="text-lg font-semibold text-gray-900">Detail Booking</h1>
                <p class="text-xs text-gray-500 font-mono">
                    {{ $detailBookingIphones?->booking_code ?? '-' }}
                </p>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-end space-y-2 sm:space-y-0 sm:space-x-2">
                <div>
                    <button class="px-3 py-1.5 rounded-full text-xs sm:text-sm font-semibold bg-orange-500 text-white hover:bg-white hover:text-black hover:border-black border-2 ease-in duration-100" @click="$dispatch('open-modal', 'tambah-durasi')">Tambah Durasi</button>
                </div>
                <x-mary-dropdown>
                    <x-slot:trigger>
                        <button
                            class="px-3 py-1.5 rounded-full text-xs sm:text-sm font-semibold
                        {{ $detailBookingIphones?->status === 'pending'
                            ? 'bg-yellow-500 text-white'
                            : ($detailBookingIphones?->status === 'confirmed'
                                ? 'bg-green-600 text-white'
                                : ($detailBookingIphones?->status === 'returned'
                                    ? 'bg-purple-600 text-white'
                                    : 'bg-red-600 text-white')) }}">
                            {{ ucfirst($detailBookingIphones?->status) }}
                        </button>
                    </x-slot:trigger>
    
                    <div class="p-1 space-y-1">
                        @foreach (['pending', 'confirmed', 'returned', 'cancelled'] as $status)
                            <button {{ $detailBookingIphones?->status === $status ? 'disabled' : '' }}
                                wire:click="updateStatusBooking({{ $detailBookingIphones?->id }}, '{{ $status }}')"
                                class="w-full px-3 py-2 text-left text-sm rounded-md
                                   hover:bg-gray-100 disabled:opacity-50">
                                {{ ucfirst($status) }}
                            </button>
                        @endforeach
                    </div>
                </x-mary-dropdown>
            </div>
        </div>

        {{-- PERANGKAT --}}
        @if ($detailBookingIphones?->iphone)
            <div x-data="{ copied: false }" class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                <img src="{{ asset('storage/' . $detailBookingIphones->iphone->gallery->image) }}"
                    class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg object-cover">

                <div class="flex-1 space-y-1">
                    <p class="text-xs text-gray-500">Perangkat</p>
                    <p class="text-sm sm:text-base font-semibold text-gray-900">
                        {{ $detailBookingIphones->iphone->name }}
                    </p>

                    {{-- SERIAL NUMBER --}}
                    @if ($detailBookingIphones?->iphone?->serial_number)
                        <div x-data="{
                            copied: false,
                            copy(text) {
                                if (navigator.clipboard && window.isSecureContext) {
                                    navigator.clipboard.writeText(text);
                                } else {
                                    const textarea = document.createElement('textarea');
                                    textarea.value = text;
                                    textarea.style.position = 'fixed';
                                    textarea.style.opacity = '0';
                                    document.body.appendChild(textarea);
                                    textarea.select();
                                    document.execCommand('copy');
                                    document.body.removeChild(textarea);
                                }
                        
                                this.copied = true;
                                setTimeout(() => this.copied = false, 1500);
                            }
                        }" class="flex items-center gap-2">
                            <span class="text-xs text-gray-500">SN:</span>

                            <span @click="copy('{{ $detailBookingIphones->iphone->serial_number }}')"
                                class="relative font-mono text-sm text-gray-900 cursor-pointer select-all hover:text-blue-600">
                                {{ $detailBookingIphones->iphone->serial_number }}

                                {{-- TOOLTIP --}}
                                <span x-show="copied" x-transition
                                    class="absolute -top-6 left-1/2 -translate-x-1/2
                   px-2 py-1 rounded-md text-xs
                   bg-black text-white whitespace-nowrap">
                                    Copied
                                </span>
                            </span>
                        </div>
                    @endif
                </div>
                {{-- REVENUE DETAIL (MOBILE FRIENDLY) --}}
                @if ($detailBookingIphones?->revenue)
                    <div class="hidden sm:flex sm:flex-col">
                        <p class=" font-bold text-green-600">
                            Rp {{ number_format($sumRevenues, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-gray-400">
                            {{ \Carbon\Carbon::parse($detailBookingIphones->revenue->created)->translatedFormat('d M Y H:i') }}
                        </p>
                    </div>
                @endif
            </div>
        @endif


        {{-- INFO BOOKING --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">

            <div>
                <p class="text-xs text-gray-500">Nama Customer</p>
                <p class="font-medium text-gray-900">
                    {{ $detailBookingIphones->customer_name ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-500">Alamat</p>
                <p class="font-medium text-gray-900">
                    {{ $detailBookingIphones->address ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-500">Email</p>
                <p class="font-medium text-gray-900">
                    {{ $detailBookingIphones->customer_email ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-500">Jaminan</p>
                <p class="font-medium text-gray-900">
                    {{ $detailBookingIphones->jaminan_type ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-500">Telepon</p>
                <p class="font-mono text-gray-900">
                    {{ $detailBookingIphones->customer_phone ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-500">Mulai</p>
                <p class="font-medium text-gray-900">
                    {{ \Carbon\Carbon::parse($detailBookingIphones?->start_booking_date)->format('d M Y') }}
                    {{ $detailBookingIphones?->start_time }}
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-500">Selesai</p>
                <p class="font-medium text-gray-900">
                    {{ \Carbon\Carbon::parse($detailBookingIphones?->end_booking_date)->format('d M Y') }}
                    {{ $detailBookingIphones?->end_time }}
                </p>
            </div>

        </div>

        {{-- REVENUE DETAIL (MOBILE FRIENDLY) --}}
        @if ($detailBookingIphones?->revenue)
            <div class="sm:hidden border-t pt-4">
                <p class="text-xs text-gray-500">Revenue</p>
                <p class="text-lg font-bold text-green-600">
                    Rp {{ number_format($detailBookingIphones->revenue->amount, 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-400">
                    {{ \Carbon\Carbon::parse($detailBookingIphones->revenue->created)->translatedFormat('d M Y H:i') }}
                </p>
            </div>
        @endif

    </div>

    {{-- Pembayaran --}}
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-base font-semibold text-gray-800 mb-3">Pembayaran</h2>

        @if ($detailBookingIphones?->payment)
            <div class="flex items-center gap-4">
                <img src="{{ asset('storage/' . $detailBookingIphones->payment->icon) }}"
                    class="w-12 h-12 rounded-md object-cover">
                <div>
                    <p class="text-sm font-medium text-gray-800">
                        {{ $detailBookingIphones->payment->name }}
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ $detailBookingIphones->payment->description }}
                    </p>
                </div>
            </div>
        @else
            <p class="text-sm text-gray-400 italic">Belum ada metode pembayaran</p>
        @endif
    </div>

    {{-- Pengembalian --}}
    <div class="bg-white rounded-xl shadow-sm p-6 space-y-4">
        <h2 class="text-base font-semibold text-gray-800">Pengembalian</h2>

        <form wire:submit="save" class="space-y-3">
            <textarea wire:model="condition" class="w-full p-3 text-sm border rounded-lg focus:ring focus:ring-blue-200"
                placeholder="Catatan kondisi iPhone"></textarea>

            <button class="w-full py-2.5 bg-blue-600 text-white rounded-lg font-semibold text-sm">
                Simpan Pengembalian
            </button>
        </form>

        @forelse($returns ?? [] as $return)
            <div class="p-4 bg-gray-50 rounded-lg text-sm space-y-1">
                <p class="font-semibold text-gray-800">
                    {{ \Carbon\Carbon::parse($return->returned_at)->translatedFormat('d M Y H:i') }}
                </p>
                <p>Denda: <span class="font-medium">
                        Rp {{ number_format($return->calculatePenalty(), 0, ',', '.') }}
                    </span></p>
                <p class="text-gray-600">Kondisi: {{ $return->condition ?? '-' }}</p>
            </div>
        @empty
            <p class="text-sm text-gray-400 italic">Belum ada data pengembalian</p>
        @endforelse
    </div>

    <x-modal name="tambah-durasi" :show="$errors->IsNotEmpty()" maxWidth="sm">
        <div class="p-3" @modal-durasi.window="show = false">
            <!-- Duration options -->
            <div class="space-y-3">
                <p class="text-sm font-semibold">Pilih Durasi</p>

                <div class="grid grid-cols-3 gap-2">
                    @if ($durations && $durations->count())
                        @foreach ($durations as $duration)
                            <button wire:click="$set('selectedDurationId', {{ $duration->id }})"
                                class="border rounded-lg p-3 text-center {{ $selectedDurationId === $duration->id ? 'bg-black text-white' : 'hover:bg-gray-100' }}">
                                <div class="font-semibold">{{ $duration->hours }} Jam</div>
                                @if ($duration->pivot)
                                    <div class="text-xs opacity-70"> Rp
                                        {{ number_format($duration->pivot->price, 0, ',', '.') }} </div>
                                @endif
                            </button>
                        @endforeach
                    @endif

                </div>
            </div>

            <!-- Multiplier -->
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Jumlah
                </label>

                <div class="flex items-center gap-3">
                    <!-- Decrease -->
                    <button wire:click="changeMultiplier('decrease')" @disabled($multiplier <= 1)
                        class="w-9 h-9 flex items-center justify-center
                   rounded-lg border border-gray-300
                   text-lg font-semibold
                   transition
                   {{ $multiplier <= 1 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-gray-100 active:scale-95' }}">
                        −
                    </button>

                    <!-- Value -->
                    <span class="min-w-[3rem] text-center text-lg font-semibold">
                        {{ $multiplier }}
                    </span>

                    <!-- Increase -->
                    <button wire:click="changeMultiplier('increase')"
                        class="w-9 h-9 flex items-center justify-center
                   rounded-lg border border-orange-500
                   hover:bg-orange-500 hover:text-white
                   active:scale-95 transition">
                        +
                    </button>
                </div>
            </div>

            <!-- Preview -->
            @if ($totalHours > 0)
                <div class="mt-4 rounded-lg border p-4 text-sm space-y-1">
                    <p>Total Jam: <strong>{{ $totalHours }}</strong></p>
                    <p>Selesai Baru: <strong>{{ $newEnd }}</strong></p>

                    @if (!$available)
                        <p class="text-red-600">❌ Tidak tersedia</p>
                    @endif
                </div>
            @endif

            <!-- Action -->
            <button wire:click="extend"
                class="mt-4 w-full bg-orange-500 text-white py-2 rounded-lg
        disabled:opacity-50"
                @disabled(!$available)>
                Tambah Durasi
            </button>

        </div>
    </x-modal>

</div>
