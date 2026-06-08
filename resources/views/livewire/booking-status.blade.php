<div class="max-w-4xl mx-auto space-y-6" x-data="{
    expireAt: {{ $expireAt }} * 1000,
    now: Date.now(),
    minutes: 0,
    seconds: 0,
    expired: false,
    updateTimer() {
        let distance = this.expireAt - this.now;
        if (distance <= 0) {
            this.minutes = 0;
            this.seconds = 0;
            if (!this.expired) {
                this.expired = true;
                $wire.cancelBooking(); // panggil Livewire
            }
            return;
        }
        this.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        this.seconds = Math.floor((distance % (1000 * 60)) / 1000);
        console.log(this.expired)
    }
}">
    <div class="w-full ">
        <div class="flex items-center justify-center">
            <span class="text-5xl font-medium font-neulis">Skyrental</span>
        </div>
        <div>

        </div>
    </div>
    <form wire:submit.prevent="checkBooking" class="space-y-6 border-2 border-black p-6 rounded-2xl">
        {{-- Judul --}}
        <h2 class="text-2xl font-bold border-b border-gray-300 pb-2">
            Cek Status Booking<span class="text-orange-500 text-2xl">.</span>
        </h2>

        {{-- Input Kode Booking --}}
        <div>
            <label for="bookingCode" class="block text-sm font-semibold">Kode Booking </label>
            <input type="text" id="bookingCode" wire:model="bookingCode"
                placeholder="Masukkan kode booking Anda (contoh: SKY123456)"
                class="w-full rounded-xl border border-gray-400 px-4 py-2 mt-1 
                   focus:outline-none focus:ring-2 focus:ring-blue-300 
                   placeholder:text-gray-400 bg-white"
                autocomplete="off">
            @error('bookingCode')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Tombol --}}
        <button type="submit"
            class="w-full py-3 rounded-xl bg-orange-500 text-white 
               font-semibold shadow transition sm:text-lg">
            Cek Status
        </button>

        {{-- Note kecil --}}
        <p class="text-xs text-blue-800 italic">
            *Gunakan kode booking yang dikirim melalui WhatsApp/Email.
        </p>
    </form>
    @if ($booking)
        <div class="px-4 py-2 flex flex-col justify-between">
            {{-- Header --}}
            <div class="flex-col-reverse flex md:flex-row md:justify-between items-start mb-8">
                <div class="w-full ">
                    {{-- Tombol Konfirmasi Pembayaran --}}
                    @if ($booking->status != 'confirmed')
                        <div class="mt-3">
                            <button @click="() => $dispatch('open-modal', 'payment')" :disabled="expired"
                                class="w-full md:w-auto px-6 py-3
        bg-gray-900 dark:bg-gray-800
        text-white dark:text-gray-100
        hover:bg-white hover:text-black
        dark:hover:bg-gray-700 dark:hover:text-white
        font-semibold shadow-xl
        transition duration-200 ease-in-out
        flex items-center justify-center gap-2
        disabled:opacity-50 disabled:cursor-not-allowed">

                                <template x-if="expired">
                                    <span>Expired</span>
                                </template>

                                <template x-if="!expired">
                                    <div class="flex space-x-1">
                                        <p>Klik untuk pembayaran</p>
                                    </div>
                                </template>
                            </button>

                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 italic">
                                *Dengan menekan tombol ini, Anda menyatakan sudah melakukan pembayaran.
                            </p>
                        </div>
                    @endif
                </div>
                <div class="text-right text-sm  text-blue-800 dark:text-gray-200 space-y-3 w-full flex flex-col items-end">
                    <p>{{ $booking->booking_code ?? '-' }}</p>
                    <p class="text-blue-800 dark:text-gray-400">
                        {{ \Carbon\Carbon::parse($booking->created)->format('d M Y') }}
                    </p>
                    <div class="flex items-center justify-center gap-2 mt-1">
                        @if ($booking->status == 'pending')
                            <span class="px-3 py-1 rounded  bg-yellow-500 text-white font-medium flex md:items-end items-center gap-1 text-lg">
                                <x-heroicon-o-clock class="w-4 h-4" />
                                Menunggu Pembayaran
                                <span class="text-red-200 dark:text-red-300">
                                    <span x-text="minutes"></span>m
                                    <span x-text="seconds"></span>s
                                </span>
                            </span>
                        @elseif($booking->status == 'confirmed')
                            <span class="px-3 py-1 rounded  bg-green-500 text-white font-medium flex items-center gap-1">
                                <x-heroicon-o-check-circle class="w-4 h-4" />
                                Dikonfirmasi
                            </span>
                        @elseif($booking->status == 'returned')
                            <span class="px-3 py-1 rounded bg-blue-500 text-white font-medium flex items-center gap-1">
                                <x-heroicon-o-arrow-uturn-left class="w-4 h-4" />
                                Dikembalikan
                            </span>
                        @elseif($booking->status == 'cancelled')
                            <span class="px-3 py-1 rounded bg-red-500 text-white font-medium flex items-center gap-1">
                                <x-heroicon-o-x-circle class="w-4 h-4" />
                                Dibatalkan
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Billed To --}}
            <div class="mb-6">
                <h2 class="text-sm font-bold text-blue-800 dark:text-blue-300">
                    BILLED TO
                </h2>
                <p class="text-blue-800 dark:text-gray-200">
                    {{ $booking->customer_name ?? '-' }}
                </p>
                <p class="text-blue-800 dark:text-gray-300">
                    {{ $booking->customer_email ?? '-' }}
                </p>
                <p class="text-blue-800 dark:text-gray-300">
                    {{ $booking->customer_phone ?? '-' }}
                </p>
            </div>

            {{-- Tabel --}}
            <table class="w-full border-t border-b border-gray-400 dark:border-gray-600 text-sm mb-8">
                <thead>
                    <tr class="font-bold text-blue-800 dark:text-blue-300">
                        <th class="text-left py-2">DESKRIPSI</th>
                        <th class="text-right py-2">DETAIL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-blue-800 dark:text-gray-200">
                        <td class="py-2">Mulai Booking</td>
                        <td class="text-right">
                            {{ \Carbon\Carbon::parse($booking->start_booking_date)->format('d M Y') }}
                            {{ $booking->start_time }}
                        </td>
                    </tr>

                    <tr class="text-blue-800 dark:text-gray-200">
                        <td class="py-2">Selesai Booking</td>
                        <td class="text-right">
                            {{ \Carbon\Carbon::parse($booking->end_booking_date)->format('d M Y') }}
                            {{ $booking->end_time }}
                        </td>
                    </tr>

                    <tr class="text-blue-800 dark:text-gray-200">
                        <td class="py-2">Durasi</td>
                        <td class="text-right">{{ $booking->duration }} Jam</td>
                    </tr>

                    <tr class="text-blue-800 dark:text-gray-200">
                        <td class="py-2">Pembayaran</td>
                        <td class="text-right">{{ $booking->payment?->name }}</td>
                    </tr>

                    <tr
                        class="font-bold text-blue-800 dark:text-blue-300 border-t border-gray-400 dark:border-gray-600">
                        <td class="py-2">TOTAL</td>
                        <td class="text-right">
                            Rp {{ number_format($booking->price, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>

            {{-- Payment --}}
            <div class="flex justify-between items-start text-sm">
                <div class="space-y-2">
                    <h2 class="font-bold text-blue-800 dark:text-blue-300">
                        PAYMENTS
                    </h2>

                    <p class="text-blue-800 dark:text-gray-300">
                        Scan QRIS pembayaran otomatis.
                    </p>

                    <a href="{{ route('contacts') }}" wire:navigate>
                        <h2 class="font-bold text-orange-600 dark:text-orange-400 mt-4">
                            PERTANYAAN?
                        </h2>
                    </a>

                    <p class="text-blue-800 dark:text-gray-300">
                        Hubungi kami di <br>
                        <span class="text-orange-600 dark:text-orange-400">
                            gwennrepair@gmail.com
                        </span>
                    </p>
                </div>
            </div>

        </div>
        @if ($booking->payment)
            <x-modal name="payment" :show="$errors->isNotEmpty()">
                <div class="max-w-md mx-auto bg-white overflow-hidden " x-init="setInterval(() => {
                    now = Date.now();
                    updateTimer()
                }, 1000)"
                    @close-modal.window="show = false">
                    <!-- Header -->
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">Konfirmasi Pembayaran</h2>
                            <p class="text-sm text-gray-500">Booking #{{ $booking->booking_code }}</p>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="px-6 py-4 space-y-3">
                        <!-- Timer -->
                        <div class="text-center">
                            <template x-if="!expired">
                                <span class="text-red-600 font-bold text-lg">
                                    <span x-text="minutes"></span>m <span x-text="seconds"></span>s
                                </span>
                            </template>
                            <template x-if="expired">
                                <span class="text-gray-400 font-semibold text-lg">⏰ Expired</span>
                            </template>
                        </div>

                        <!-- Info Booking -->
                        <div class="text-sm text-gray-700 space-y-1">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Tanggal</span>
                                <span
                                    class="font-medium">{{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Durasi</span>
                                <span class="font-medium">{{ $booking->duration }} Jam</span>
                            </div>
                            <div class="flex justify-between border-t pt-2 mt-2">
                                <span class="font-semibold">Total</span>
                                <span
                                    class="font-bold text-gray-900">Rp{{ number_format($booking->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <img src="{{ asset('storage/' . $booking->payment->icon) }}" alt="Payment Icon"
                            class="w-full h-full object-contain">
                    </div>
                    <div x-show="!expired">
                        <x-mary-file wire:model="payment_proof" label="Bukti pembayaran"
                            hint="Upload bukti pembayaran" accept="image/jpeg, image/png, image/webp" />
                    </div>
                    <!-- Footer -->
                    <div class="px-6 py-4 bg-gray-50 flex justify-between items-center">
                        <button :disabled="expired" wire:click="confirmPayment({{ $booking->id }})"
                            class="flex-1 mr-2 px-5 py-3 bg-blue-600 text-white font-semibold 
                   hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-blue-300"
                            wire:loading.attr="disabled">
                            Konfirmasi
                        </button>
                        <button class="flex-1 ml-2 px-5 py-3 text-gray-600 font-medium hover:text-red-600"
                            @click="show = false">
                            Batalkan
                        </button>
                    </div>
                </div>

            </x-modal>
        @endif
    @endif
</div>
