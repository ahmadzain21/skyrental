<div x-data="{
    open: false,
    showDatepicker: false,
    selectedDateFormatted: @entangle('selectedDateFormatted').live,
    month: null,
    year: null,
    daysInMonth: [],
    blankdays: [],
    monthNames: [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ],

    selectedDate: @entangle('selectedDate').live,
    selectedHour: @entangle('selectedHour').live,
    selectedMinute: @entangle('selectedMinute').live,
    hours: Array.from({ length: 24 }, (_, i) => String(i).padStart(2, '0')),
    minutes: ['00', '15', '30', '45'],


    init() {
        const today = new Date();
        this.month = today.getMonth();
        this.year = today.getFullYear();
        this.selectedDate = today;
        this.selectedDateFormatted = this.formatDate(this.selectedDate);
        this.calculateDays();
        console.log(this.selectedDate);
    },

    isToday(date) {
        const today = new Date();
        const d = new Date(this.year, this.month, date);
        return today.toDateString() === d.toDateString();
    },

    formatDate(date) {
        if (!(date instanceof Date)) {
            date = new Date(date);
        }

        const day = date.getDate();
        const month = this.monthNames[date.getMonth()];
        const year = date.getFullYear();
        const time = `${this.selectedHour}:${this.selectedMinute}`;
        return `${day} ${month} ${year}, ${time}`;
    },


    pickDate(date) {
        this.selectedDate = new Date(this.year, this.month, date);
        this.selectedDateFormatted = this.formatDate(this.selectedDate);
    },

    calculateDays() {
        const daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
        const firstDayOfMonth = new Date(this.year, this.month, 1).getDay(); // 0 = Minggu

        this.blankdays = Array(firstDayOfMonth).fill(null);
        this.daysInMonth = Array.from({ length: daysInMonth }, (_, i) => i + 1);
    },

    prevMonth() {
        this.month--;
        if (this.month < 0) {
            this.month = 11;
            this.year--;
        }
        this.calculateDays();
    },

    nextMonth() {
        this.month++;
        if (this.month > 11) {
            this.month = 0;
            this.year++;
        }
        this.calculateDays();
    },

    isSelectedDate(date) {
        const d = new Date(this.year, this.month, date);
        const selected = new Date(this.selectedDate); // konversi string → Date
        return selected.toDateString() === d.toDateString();
    },

    pickDate(date) {
        const picked = new Date(this.year, this.month, date);
        const today = new Date();
        today.setHours(0, 0, 0, 0); // buang jam agar akurat membandingkan tanggal

        if (picked < today) return; // blokir jika tanggal sebelum hari ini

        this.selectedDate = picked;
        this.selectedDateFormatted = this.formatDate(this.selectedDate);
    },

    isPastDate(date) {
        const picked = new Date(this.year, this.month, date);
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        return picked < today;
    },
    searchIphones() {
        this.$dispatch('open-modal', 'ipip');
        $wire.getIphoneByDate();
    },

    formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(number).replace(/\s+/g, ' ');
    }


}" x-init="$watch('selectedHour', () => selectedDateFormatted = formatDate(selectedDate));
$watch('selectedMinute', () => selectedDateFormatted = formatDate(selectedDate));">
    <div class="items-center w-full relative" x-cloak>
        <div class="space-y-2 w-[83%] lg:w-[92%]">
            <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                <div @click="open = ! open">
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center p-3 pointer-events-none">
                            <svg width="30px" height="30px" viewBox="0 0 24.00 24.00" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M20 10V7C20 5.89543 19.1046 5 18 5H6C4.89543 5 4 5.89543 4 7V10M20 10V19C20 20.1046 19.1046 21 18 21H6C4.89543 21 4 20.1046 4 19V10M20 10H4M8 3V7M16 3V7"
                                    stroke="#000000" stroke-width="1.344" stroke-linecap="round"></path>
                                <rect x="6" y="12" width="3" height="3" rx="0.5" fill="#000000" />
                                <rect x="10.5" y="12" width="3" height="3" rx="0.5" fill="#000000" />
                                <rect x="15" y="12" width="3" height="3" rx="0.5" fill="#000000" />
                            </svg>
                        </div>
                        <input
                            class="block w-full pl-12 p-4 ps-10 text-gray-900 border border-gray-300 bg-gray-50 rounded-lg focus:ring-slate-900 focus:border-slate-900 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-slate-900 dark:focus:border-slate-900"
                            placeholder="Pilih tanggal" x-model="selectedDateFormatted" readonly
                            @click="window.dispatchEvent(new CustomEvent('open-bottom-sheet', { detail: { id: 'sheetTanggalA' } }))" />
                    </div>
                </div>

                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95" class="absolute z-50 mt-2 hidden sm:flex "
                    style="display: none;">
                    <div class="rounded-md ring-1 ring-black ring-opacity-5">

                        <!-- Kalender -->
                        <div
                            class="p-2 lg:p-4 bg-white dark:bg-gray-800 text-lg z-10 w-full xl:w-[25vw] border-2 border-slate-900 shadow-xl rounded-xl font-neulis">
                            <div class="border-b-2 border-gray-300 pb-4">
                                <div class="flex items-center  text-lg">
                                    <!-- Hour Picker -->
                                    <div>
                                        <input type="number" x-model="selectedHour" min="0" max="23"
                                            class="w-16 text-center bg-transparent border border-transparent focus:border-gray-400 focus:outline-none px-2 py-1 rounded text-2xl font-bold"
                                            placeholder="HH">
                                    </div>

                                    <div class="font-bold">:</div>

                                    <!-- Input Menit -->
                                    <div>
                                        <input type="number" x-model="selectedMinute" min="0" max="59"
                                            step="1"
                                            class="w-16 text-center bg-transparent border border-transparent focus:border-gray-400 focus:outline-none px-2 py-1 rounded text-2xl font-bold"
                                            placeholder="MM">
                                    </div>
                                </div>
                                <div class="text-lg font-medium text-gray-700 dark:text-gray-200"
                                    x-text="monthNames[month] + ' ' + year"></div>
                            </div>
                            <!-- Header navigasi bulan -->
                            <div class="flex mb-2">
                                <button type="button" @click="prevMonth()"
                                    class="px-2 py-1 text-gray-600 hover:bg-gray-200 rounded">&lt;</button>

                                <button type="button" @click="nextMonth()"
                                    class="px-2 py-1 text-gray-600 hover:bg-gray-200 rounded">&gt;</button>
                            </div>

                            <!-- Hari -->
                            <div class="grid grid-cols-7 text-gray-500 mb-1">
                                <template x-for="day in ['Min','Sen','Sel','Rab','Kam','Jum','Sab']">
                                    <div x-text="day" class="text-center"></div>
                                </template>
                            </div>

                            <!-- Tanggal -->
                            <div class="grid grid-cols-7 gap-2 font-medium text-sm">
                                <!-- Sisipkan hari kosong -->
                                <template x-for="blank in blankdays">
                                    <div></div>
                                </template>

                                <!-- Tanggal -->
                                <template x-for="(date, index) in daysInMonth" :key="index">
                                    <div @click="!isPastDate(date) && pickDate(date); $refs.dropdownButton?.click()"
                                        x-text="date"
                                        class="text-center cursor-pointer p-4 flex justify-center transition-colors duration-200 ease-in-out border-2 border-transparent"
                                        :class="{
                                            'bg-slate-900 text-white': isSelectedDate(date),
                                            'text-gray-400 cursor-not-allowed opacity-50': isPastDate(date),
                                            'hover:border-orange-500': !isPastDate(date)
                                        }">
                                    </div>
                                </template>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button @click="searchIphones()" wire:loading.attr="disabled"
            class="ml-2 absolute end-0 bottom-0 p-3 rounded-xl font-semibold
           bg-slate-900 text-white
           border-2 border-transparent
           transition-all duration-150 ease-in-out

           hover:bg-white hover:text-black hover:border-black

           dark:bg-gray-100 dark:text-gray-900
           dark:hover:bg-gray-900 dark:hover:text-white
           dark:hover:border-gray-100

           disabled:opacity-60 disabled:cursor-not-allowed">

            <x-icons.search default="30px" />
        </button>

    </div>
    <x-modal name="ipip" :show="$errors->isNotEmpty()" rounded="rounded-none" border="border-2 border-slate-800">
        @if (isset($iphoneByDate) && $iphoneByDate->isNotEmpty())
            @foreach ($iphoneByDate as $iphone)
                @php
                    $durationsData = $iphone->durations->map(function ($d) {
                        return [
                            'id' => $d->id,
                            'hours' => $d->hours,
                            'price' => $d->pivot->price,
                        ];
                    });
                @endphp

                <div class="p-3 space-y-2 w-full flex items-start justify-between relative border border-slate-400"
                    x-data="{
                        durations: {{ Js::from($durationsData) }},
                        activeTab: {{ $durationsData->first()['id'] ?? 'null' }},
                        price: {{ $durationsData->first()['price'] ?? 0 }},
                        showDetail: false, // ← tambahkan ini
                        showHowToRent: false,
                        showTerms: false,
                    
                        setActiveTab(id) {
                            const selected = this.durations.find(d => d.id === id);
                            if (selected) {
                                this.activeTab = selected.id;
                                this.price = selected.price;
                            }
                        },
                    
                        formatRupiah(number) {
                            return new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0
                            }).format(number);
                        }
                    }">

                    <div class="p-2">
                        <div class="space-y-1">
                            <h1 class="text-xl font-semibold">{{ $iphone->name }}</h1>

                            <div class="flex gap-2 flex-wrap mb-4">
                                @foreach ($iphone->durations as $duration)
                                    <div @click="setActiveTab({{ $duration->id }})"
                                        :class="{ 'bg-black text-white': activeTab === {{ $duration->id }} }"
                                        class="px-3 py-1 font-medium text-sm text-center cursor-pointer border border-slate-400 text-black rounded">
                                        {{ $duration->hours }} jam
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-5 flex space-x-1 md:space-x-5 text-sm font-semibold text-gray-600">
                            <button
                                @click="() => {
                                showDetail = !showDetail
                                showHowToRent = false
                                showTerms = false
                            }"
                                class="hover:underline">Detail</button>
                            <button
                                @click="() => {
                                showDetail = false
                                showTerms = false
                                showHowToRent = !showHowToRent    
                            }"
                                class="hover:underline">Cara Sewa</button>
                            <button
                                @click="() => {
                                showDetail = false
                                showHowToRent = false
                                showTerms = !showTerms    
                            }"
                                class="hover:underline">Syarat & Ketentuan</button>
                        </div>

                        <!-- COLLAPSE AREA -->
                        <div x-show="showDetail" x-collapse class="mt-3 text-sm text-gray-700 border-t pt-3 w-full">
                            <div
                                class="prose prose-sm prose-invert text-black prose-li:text-black prose-li:text-sm prose-a:text-blue-600 max-w-none ">
                                {!! $iphone->description !!}</div>
                            {{-- <p><strong>Warna:</strong> {{ $iphone->color ?? '-' }}</p>
                            <p><strong>Serial:</strong> {{ $iphone->serial_number ?? '-' }}</p> --}}
                            <!-- Tambahkan info lainnya sesuai kebutuhan -->
                        </div>
                        <div x-show="showHowToRent" x-collapse class="mt-3 text-sm text-gray-700 border-t pt-3">
                            <p><strong>Cara Sewa iPhone:</strong></p>
                            <ul class="list-disc pl-5 space-y-1 mt-2">
                                <li>Pilih unit iPhone pada tanggal yang tersedia.</li>
                                <li>Tentukan durasi sewa dengan mengklik jumlah jam.</li>
                                <li>Lihat total harga yang muncul secara otomatis.</li>
                                <li>Klik tombol <strong>Booking</strong> untuk memesan.</li>
                                <li>Lengkapi data dan lakukan pembayaran.</li>
                                <li>iPhone akan dikirim atau dapat diambil sesuai ketentuan.</li>
                            </ul>
                        </div>
                        <div x-show="showTerms" x-collapse class="mt-3 text-sm text-gray-700 border-t pt-3">
                            <div class="text-sm text-gray-700 space-y-2">
                                <h2 class="text-base font-semibold mb-2">✅ Syarat dan Ketentuan Sewa iPhone</h2>
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>
                                        Penyewa wajib mengisi data diri dengan lengkap dan benar. Data yang dimasukkan
                                        akan digunakan untuk proses verifikasi dan keperluan sewa.
                                    </li>
                                    <li>
                                        Minimal durasi sewa adalah 1 jam. Waktu sewa dihitung dari waktu penyerahan unit
                                        ke penyewa.
                                    </li>
                                    <li>
                                        Pembayaran dilakukan di awal (DP/full), sebelum unit dikirim/diambil.
                                    </li>
                                    <li>
                                        Dilarang keras mengubah, mereset, atau merusak iPhone yang disewa. Termasuk:
                                        logout iCloud, reset ulang, jailbreak, dan tindakan lain yang merugikan.
                                    </li>
                                    <li>
                                        Kerusakan atau kehilangan selama masa sewa menjadi tanggung jawab penyewa. Biaya
                                        akan ditagihkan sesuai harga pasaran atau perjanjian awal.
                                    </li>
                                    <li>
                                        Unit harus dikembalikan tepat waktu sesuai durasi sewa. Keterlambatan akan
                                        dikenakan denda per jam yang berlaku.
                                    </li>
                                    <li>
                                        Penyewa yang tidak kooperatif atau melanggar aturan dapat masuk blacklist dan
                                        dilaporkan.
                                    </li>
                                    <li>
                                        Dengan melakukan pemesanan, penyewa dianggap telah membaca dan menyetujui
                                        seluruh syarat & ketentuan ini.
                                    </li>
                                </ul>
                            </div>

                        </div>

                    </div>

                    <div class="mb-4 space-y-3">
                        <div class="text-xl font-bold text-red-500">
                            <h1 x-text="formatRupiah(price)"></h1>
                        </div>
                        <div>
                            <a x-bind:href="`{{ route('detail', $iphone->slug) }}?date=${selectedDate.toISOString()}&hour=${selectedHour}&minute=${selectedMinute}`"
                                wire:navigate
                                class="mt-2 bg-black py-2 px-4 text-white text-base font-semibold rounded">
                                Booking
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            {{-- Loading Spinner --}}
            <div class="w-full h-32 flex justify-center items-center col-span-4" wire:loading.flex>
                <svg width="64px" height="64px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"
                    fill="none" class="animate-spin">
                    <g fill="#f43f5e" fill-rule="evenodd" clip-rule="evenodd">
                        <path d="M8 1.5a6.5 6.5 0 100 13 6.5 6.5 0 000-13zM0 8a8 8 0 1116 0A8 8 0 010 8z"
                            opacity=".2"></path>
                        <path
                            d="M7.25.75A.75.75 0 018 0a8 8 0 018 8 .75.75 0 01-1.5 0A6.5 6.5 0 008 1.5a.75.75 0 01-.75-.75z">
                        </path>
                    </g>
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
            <div class="p-5 text-center" wire:loading.remove>
                <h1 class="text-lg font-semibold">Maaf, tidak ada iPhone tersedia pada tanggal tersebut.</h1>
                <p class="mt-2 text-gray-600">Silakan pilih tanggal lain atau hubungi kami untuk informasi lebih
                    lanjut.</p>
            </div>
        @endif
    </x-modal>
    <x-bottom-sheet id="sheetTanggalA" title="Form Booking" glass="">
        <!-- Kalender -->
        {{-- glass --}}
        <div
            class="relative text-lg z-10 w-full 
            bg-white/20 dark:bg-gray-800/30 
            backdrop-blur-xl border border-white/20 
            rounded-2xl shadow-xl p-4">

            <!-- Header jam & bulan -->
            <div class="border-b border-white/20 dark:border-gray-700/40 pb-4">
                <div class="flex items-center text-lg gap-2">
                    <!-- Hour Picker -->
                    <div>
                        <input type="number" x-model="selectedHour" min="0" max="23"
                            class="w-16 text-center bg-transparent text-white 
                           border border-transparent 
                           focus:border-white/40 dark:focus:border-gray-500 
                           focus:outline-none px-2 py-1 rounded 
                           text-2xl font-bold placeholder-gray-300"
                            placeholder="HH">
                    </div>

                    <div class="font-bold text-white">:</div>

                    <!-- Input Menit -->
                    <div>
                        <input type="number" x-model="selectedMinute" min="0" max="59" step="1"
                            class="w-16 text-center bg-transparent text-white 
                           border border-transparent 
                           focus:border-white/40 dark:focus:border-gray-500 
                           focus:outline-none px-2 py-1 rounded 
                           text-2xl font-bold placeholder-gray-300"
                            placeholder="MM">
                    </div>
                </div>
                <div class="text-lg font-medium text-white/90 dark:text-gray-200 mt-2"
                    x-text="monthNames[month] + ' ' + year"></div>
            </div>

            <!-- Header navigasi bulan -->
            <div class="flex mb-2 mt-2">
                <button type="button" @click="prevMonth()"
                    class="px-2 py-1 text-white/80 hover:bg-white/10 rounded">&lt;</button>
                <button type="button" @click="nextMonth()"
                    class="px-2 py-1 text-white/80 hover:bg-white/10 rounded">&gt;</button>
            </div>

            <!-- Hari -->
            <div class="grid grid-cols-7 text-white/70 mb-1">
                <template x-for="day in ['Min','Sen','Sel','Rab','Kam','Jum','Sab']">
                    <div x-text="day" class="text-center"></div>
                </template>
            </div>

            <!-- Tanggal -->
            <div class="grid grid-cols-7 gap-2 font-semibold text-sm">
                <!-- Sisipkan hari kosong -->
                <template x-for="blank in blankdays">
                    <div></div>
                </template>

                <!-- Tanggal -->
                <template x-for="(date, index) in daysInMonth" :key="index">
                    <div @click="!isPastDate(date) && pickDate(date); $refs.dropdownButton?.click()" x-text="date"
                        class="text-center cursor-pointer p-4 flex justify-center 
                       transition-colors duration-200 ease-in-out 
                       border border-transparent rounded-lg"
                        :class="{
                            'bg-white/20 text-white backdrop-blur-sm border-white/40': isSelectedDate(date),
                            'text-white/40 cursor-not-allowed opacity-50': isPastDate(date),
                            'hover:border-white/40 hover:bg-white/10': !isPastDate(date)
                        }">
                    </div>
                </template>
            </div>
        </div>

    </x-bottom-sheet>
</div>
