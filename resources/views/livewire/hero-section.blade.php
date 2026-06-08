<div class="relative w-full h-auto" x-data="{ openBottomSheet: false }">
    <section class="max-w-screen-2xl mx-auto px-6 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

            <!-- LEFT CONTENT -->
            <div class="flex flex-col items-center lg:items-start w-full ">
                <div class="flex flex-col justify-center items-center lg:items-start font-neulis">

                    <!-- Badge -->
                    <div
                        class="inline-block mb-6 px-4 py-1 text-sm font-medium border rounded-full
                mx-auto lg:mx-0">
                        Skyrental™
                    </div>

                    <!-- Heading -->
                    <h1
                        class="text-5xl md:text-6xl font-extrabold leading-tight mb-6
               text-center lg:text-left">
                        <span class="bg-gradient-to-r from-orange-400 to-orange-500 bg-clip-text text-transparent">
                            Sewa iPhone
                        </span><br>
                        <span class="bg-gradient-to-r from-orange-500 to-pink-500 bg-clip-text text-transparent">
                            no.1 di Banyuwangi
                        </span>
                    </h1>

                </div>


                <p class="text-gray-600 mb-8 text-center lg:text-left md:text-lg">
                    {{ $setting->tagline }}
                </p>
                <div class="w-full">
                    <livewire:filter-section />
                </div>
            </div>

            <!-- RIGHT IMAGE -->
            <div class="flex justify-center lg:justify-end -z-50 dark:z-10">
                <img src="{{ url('ip17.png') }}" alt="iPhone" class="max-w-48 md:max-w-md drop-shadow-2xl" />
            </div>

        </div>
    </section>
</div>
