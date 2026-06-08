<x-home>
    <x-slot name="overide">
        {!! seo($overide) !!}
    </x-slot>
    <div class="max-w-2xl mx-auto items-center ">
        {{-- mobile --}}
        <div class="w-full p-3 overflow-hidden" x-data="{
        
            activeTab: $persist('whatsapp'),
        
            setActiveTab(tab) {
        
                this.activeTab = tab
        
            },
        
        }">
            <div class="flex w-full justify-end text-end">
                <h4 class="w-1/2 text-lg font-semibold text-gray-400">Jl. KH. Imam Bahri, Dusun Kopen,
                    Desa
                    Genteng Kulon, Kec.
                    Genteng, Kab. Banyuwangi</h4>
            </div>
            <div class="mt-20">
                <h1 class="text-5xl font-extrabold">
                    Contacts
                </h1>
                <div class=" mt-8 border-b-2 pb-3 mySwiperContacts">
                    <div class="flex space-x-3 swiper-wrapper font-semibold text-gray-400">

                        <button @click.prevent="setActiveTab('whatsapp')"
                            :class="{ 'text-gray-800': activeTab === 'whatsapp' }" class="swiper-slide">
                            <h3>WhatsApp</h3>
                        </button>
                        <button @click.prevent="setActiveTab('instagram')"
                            :class="{ 'text-gray-800': activeTab === 'instagram' }" class="swiper-slide">
                            <h3>Instagram</h3>
                        </button>

                        <button @click.prevent="setActiveTab('facebook')"
                            :class="{ 'text-gray-800': activeTab === 'facebook' }" class="swiper-slide">
                            <h3>Facebook</h3>
                        </button>

                        <button @click.prevent="setActiveTab('email')"
                            :class="{ 'text-gray-800': activeTab === 'email' }" class="swiper-slide">
                            <h3>Email</h3>
                        </button>

                        <button @click.prevent="setActiveTab('telegram')"
                            :class="{ 'text-gray-800': activeTab === 'telegram' }" class="swiper-slide">
                            <h3>Telegram</h3>
                        </button>

                        <button @click.prevent="setActiveTab('youtube')"
                            :class="{ 'text-gray-800': activeTab === 'youtube' }" class="swiper-slide">
                            <h3>YouTube</h3>
                        </button>

                        <button @click.prevent="setActiveTab('twitter')"
                            :class="{ 'text-gray-800': activeTab === 'twitter' }" class="swiper-slide">
                            <h3>Twitter</h3>
                        </button>

                    </div>
                </div>
                <div class="mt-14">
                    {{-- WhatsApp --}}
                    <div x-cloak x-show="activeTab === 'whatsapp'" class="w-[80%] text-3xl font-extrabold space-y-2">
                        <a href="{{ $setting->whatsapp }}" target="_blank">
                            <h1 class="text-sky-500">WhatsApp</h1>
                        </a>
                        <h1>Butuh bantuan cepat? Hubungi kami via WhatsApp</h1>
                        <h2 class="italic">Respon cepat jam 09.00 – 21.00 WIB</h2>
                    </div>

                    {{-- Instagram --}}
                    <div x-cloak x-show="activeTab === 'instagram'" class="w-[80%] text-3xl font-extrabold space-y-2">
                        <a href="{{ $setting->instagram }}" target="_blank">
                            <h1 class="text-sky-500">Instagram</h1>
                        </a>
                        <h1>Ikuti kami di Instagram untuk update terbaru</h1>
                        <h2>DM juga bisa kalau ada pertanyaan</h2>
                    </div>

                    {{-- YouTube --}}
                    <div x-cloak x-show="activeTab === 'youtube'" class="w-[80%] text-3xl font-extrabold space-y-2">
                        <a href="{{ $setting->youtube }}" target="_blank">
                            <h1 class="text-sky-500">YouTube</h1>
                        </a>
                        <h1>Lihat konten video terbaru kami di YouTube</h1>
                        <h2 class="italic">Jangan lupa subscribe & aktifkan notifikasi 🔔</h2>
                    </div>

                    {{-- TikTok --}}
                    <div x-cloak x-show="activeTab === 'tiktok'" class="w-[80%] text-3xl font-extrabold space-y-2">
                        <a href="{{ $setting->tiktok }}" target="_blank">
                            <h1 class="text-sky-500">TikTok</h1>
                        </a>
                        <h1>Tonton video singkat seru kami di TikTok</h1>
                        <h2 class="italic">Follow biar gak ketinggalan konten baru</h2>
                    </div>

                    {{-- Facebook --}}
                    <div x-cloak x-show="activeTab === 'facebook'" class="w-[80%] text-3xl font-extrabold space-y-2">
                        <a href="{{ $setting->facebook }}" target="_blank">
                            <h1 class="text-sky-500">Facebook</h1>
                        </a>
                        <h1>Terhubung dengan kami di Facebook</h1>
                        <h2 class="italic">Ikuti halaman untuk berita & promo terbaru</h2>
                    </div>

                    {{-- Twitter / X --}}
                    <div x-cloak x-show="activeTab === 'twitter'" class="w-[80%] text-3xl font-extrabold space-y-2">
                        <a href="{{ $setting->twitter }}" target="_blank">
                            <h1 class="text-sky-500">Twitter</h1>
                        </a>
                        <h1>Ikuti update singkat kami di Twitter</h1>
                        <h2 class="italic">Mention kami untuk diskusi langsung</h2>
                    </div>

                    {{-- Telegram --}}
                    <div x-cloak x-show="activeTab === 'telegram'" class="w-[80%] text-3xl font-extrabold space-y-2">
                        <a href="{{ $setting->telegram }}" target="_blank">
                            <h1 class="text-sky-500">Telegram</h1>
                        </a>
                        <h1>Gabung di channel/komunitas Telegram kami</h1>
                        <h2 class="italic">Dapatkan info eksklusif lebih cepat</h2>
                    </div>

                    {{-- Email --}}
                    <div x-cloak x-show="activeTab === 'email'" class="w-[80%] text-3xl font-extrabold space-y-2">
                        <a href="mailto:skyrental@gmail.com">
                            <h1 class="text-sky-500">skyrental@gmail.com</h1>
                        </a>
                        <h1>Kirim pertanyaan atau kerja sama via Email</h1>
                        <h2 class="italic">Kami akan membalas dalam 1x24 jam</h2>
                    </div>


                </div>
            </div>
        </div>
        <script>
            // di hero-section
            var contactSwiper = new Swiper(".mySwiperContacts", {
                spaceBetween: 0,
                slidesPerView: 3,
                loop: true,
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
            });
        </script>
    </div>
</x-home>
