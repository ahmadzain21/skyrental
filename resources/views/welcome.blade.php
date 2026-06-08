<x-home>
    <livewire:hero-section />
    <livewire:review-page />
    <section class="overflow-hidden py-5 lg:py-4 space-y-2
           bg-white dark:bg-gray-900">

        <!-- TOP : Right to Left -->
        <div class="relative overflow-hidden">
            <div class="flex w-max animate-marquee-left gap-16">
                <span
                    class="text-[10vw] font-extrabold whitespace-nowrap
                       text-gray-900 dark:text-gray-100">
                    Sewa iPhone no.1 😎
                </span>
                <span
                    class="text-[10vw] font-extrabold whitespace-nowrap
                       text-gray-900 dark:text-gray-100">
                    Sewa iPhone no.1
                </span>
            </div>
        </div>

        <!-- BOTTOM : Left to Right -->
        <div class="relative overflow-hidden">
            <div class="flex w-max animate-marquee-right gap-16">
                <span
                    class="text-[10vw] font-extrabold whitespace-nowrap
                       text-transparent stroke-text
                       dark:stroke-text-dark">
                    Raya Di Banyuwangi<span class="text-orange-500">.</span>
                </span>
                <span
                    class="text-[10vw] font-extrabold whitespace-nowrap
                       text-transparent stroke-text
                       dark:stroke-text-dark">
                    Raya Di Banyuwangi<span class="text-orange-500">.</span>
                </span>
            </div>
        </div>

    </section>

    <section class="max-w-6xl mx-auto px-6 py-20">
        <!-- Header -->
        <div class="text-center mb-14">
            <span class="inline-flex items-center px-4 py-1 rounded-full bg-gray-100 text-sm font-medium text-gray-600">
                Media Sosial
            </span>
            <h2 class="mt-5 text-4xl font-bold text-gray-900 leading-tight dark:text-white">
                Terhubung Dengan <br class="hidden md:block"> Skyrental™
            </h2>
            <p class="mt-4 text-gray-500 max-w-xl mx-auto">
                Dapatkan update terbaru, promo, dan informasi penting melalui media sosial kami.
            </p>
        </div>

        <!-- Card Wrapper -->
        <div class="grid md:grid-cols-2 gap-8 items-center">
            <!-- Left Card -->
            <div class="relative bg-white rounded-[32px] p-8 shadow-xl overflow-hidden">
                <!-- Decorative Shape -->
                <div class="absolute -top-16 -right-16 w-48 h-48 bg-indigo-100 rounded-full blur-2xl"></div>

                <h3 class="text-2xl font-semibold text-gray-900 mb-3">
                    Ikuti Kami di Media Sosial
                </h3>
                <p class="text-gray-500 mb-8">
                    Semua info terbaru kami bagikan secara real-time di platform berikut.
                </p>

                <!-- Social Icons -->
                <div class="flex gap-4 mb-8">
                    @if (!empty($setting->whatsapp))
                        <a href="{{ $setting->whatsapp }}" target="_blank" rel="noopener noreferrer"
                            class="w-14 h-14 flex items-center justify-center rounded-2xl bg-gray-100 hover:bg-black hover:text-white transition">
                            <i class="ri-whatsapp-line text-xl"></i>
                        </a>
                    @endif
                    @if (!empty($setting->instagram))
                        <a href="{{ $setting->instagram }}" target="_blank" rel="noopener noreferrer"
                            class="w-14 h-14 flex items-center justify-center rounded-2xl bg-gray-100 hover:bg-black hover:text-white transition">
                            <i class="ri-instagram-line text-xl"></i>
                        </a>
                    @endif
                    @if (!empty($setting->tiktok))
                        <a href="{{ $setting->tiktok }}" target="_blank" rel="noopener noreferrer"
                            class="w-14 h-14 flex items-center justify-center rounded-2xl bg-gray-100 hover:bg-black hover:text-white transition">
                            <i class="ri-tiktok-line text-xl"></i>
                        </a>
                    @endif
                    @if (empty($setting->twitter))
                        <a href="{{ $setting->twitter }}" target="_blank" rel="noopener noreferrer"
                            class="w-14 h-14 flex items-center justify-center rounded-2xl bg-gray-100 hover:bg-black hover:text-white transition">
                            <i class="ri-twitter-x-line text-xl"></i>
                        </a>
                    @endif
                </div>

                <!-- CTA -->
                <a href="#"
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-black text-white font-medium hover:opacity-90 transition">
                    Kunjungi Media Sosial
                    <span>↗</span>
                </a>
            </div>

            <!-- Right Visual Card -->
            <div class="relative bg-gradient-to-br from-black to-gray-800 rounded-[32px] p-10 text-white shadow-xl">
                <span class="text-sm uppercase tracking-widest text-gray-300">
                    Skyrental™
                </span>

                <h3 class="mt-4 text-3xl font-bold leading-tight">
                    Update Cepat <br> Tanpa Ketinggalan
                </h3>

                <p class="mt-4 text-gray-300">
                    Promo, info stok, dan pengumuman penting selalu kami share lebih dulu di media sosial.
                </p>
            </div>
        </div>
    </section>

    <div class="max-w-screen-2xl mx-auto">
        <livewire:cards lazy="on-load" />
    </div>
</x-home>
