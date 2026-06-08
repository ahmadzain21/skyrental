<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if (!empty($overide))
        {{ $overide }}
    @else
        <title>{{ $seo->title }}</title>
        <meta name="description" content="{{ $seo->description }}">
        <meta name="robots" content="{{ $seo->robots }}">
    @endif
    <link rel="icon" href="{{ asset('storage/' . $setting->favicon) }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">


    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body>
    <div class="antialiased font-sans dark:bg-gray-900" x-data="{ setNav: false, }">
        <div class="w-full flex justify-between items-center p-3 lg:hidden" wire:ignore>
            <button @click="setNav = true" class="">
                <svg width="54px" height="54px" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M19.5 8.25H4.5V6.75H19.5V8.25Z" fill="#000000">
                        </path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M19.5 12.75H4.5V11.25H19.5V12.75Z"
                            fill="#000000"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M19.5 17.25H4.5V15.75H19.5V17.25Z"
                            fill="#000000"></path>
                    </g>
                </svg>
            </button>
        </div>
        <div class="">
            <livewire:layout.home-navigation />
            @if (!request()->routeIs('detail'))
                <div x-data="{ open: false }"
                    class="fixed bottom-6 right-6 sm:right-20 flex flex-col-reverse items-end space-y-reverse space-y-3"
                    @click.outside="open = false">
                    <button @click="open = !open" class="relative inline-block px-4 py-3 font-medium group z-50">
                        <span
                            class="absolute inset-0 w-full h-full transition duration-200 ease-out transform translate-x-1 translate-y-1 bg-black group-hover:-translate-x-0 group-hover:-translate-y-0"></span>
                        <span
                            class="absolute inset-0 w-full h-full bg-white border-2 border-black group-hover:bg-black"></span>
                        <span class="relative text-black group-hover:text-white">Butuh bantuan?</span>
                    </button>

                    <!-- Tombol Sosial Media -->
                    <div class="flex flex-col items-end space-y-3 mb-3" x-show="open"
                        x-transition:enter="transition transform duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition transform duration-300"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-4" x-cloak>

                        <!-- WhatsApp -->
                        <a href="{{ $setting->whatsapp }}" target="_blank"
                            class="relative inline-block px-4 py-2 font-medium group">
                            <span
                                class="absolute inset-0 w-full h-full transition duration-200 ease-out transform translate-x-1 translate-y-1 bg-green-600 group-hover:translate-x-0 group-hover:translate-y-0"></span>
                            <span
                                class="absolute inset-0 w-full h-full bg-white border-2 border-green-600 group-hover:bg-green-600"></span>
                            <span class="relative text-green-600 group-hover:text-white flex items-center gap-2">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </span>
                        </a>

                        <!-- Instagram -->
                        <a href="{{ $setting->instagram }}" target="_blank"
                            class="relative inline-block px-4 py-2 font-medium group">
                            <span
                                class="absolute inset-0 w-full h-full transition duration-200 ease-out transform translate-x-1 translate-y-1 bg-pink-500 group-hover:translate-x-0 group-hover:translate-y-0"></span>
                            <span
                                class="absolute inset-0 w-full h-full bg-white border-2 border-pink-500 group-hover:bg-pink-500"></span>
                            <span class="relative text-pink-500 group-hover:text-white flex items-center gap-2">
                                <i class="fab fa-instagram"></i> Instagram
                            </span>
                        </a>

                        <!-- Email -->
                        <a href="mailto:gwennrepair@gmail.com" class="relative inline-block px-4 py-2 font-medium group">
                            <span
                                class="absolute inset-0 w-full h-full transition duration-200 ease-out transform translate-x-1 translate-y-1 bg-red-600 group-hover:translate-x-0 group-hover:translate-y-0"></span>
                            <span
                                class="absolute inset-0 w-full h-full bg-white border-2 border-red-600 group-hover:bg-red-600"></span>
                            <span class="relative text-red-600 group-hover:text-white flex items-center gap-2">
                                <i class="fas fa-envelope"></i> Email
                            </span>
                        </a>
                    </div>
                </div>
            @endif

            {{-- <button type="button" class="p-2 bg-primary bottom-3 right-3 flex  z-50"
                @click="setNav = true" :class="setNav ? 'hidden' : ''">
                <x-icons.dotmenu default="25px" />
            </button> --}}
        </div>
        <main>
            {{ $slot }}
        </main>
    </div>
    <footer class="w-full bg-slate-950 h-fit mt-[30vh] lg:mt-[25vh] py-7 px-3">
        <div class="max-w-screen-2xl mx-auto mt-5">
            <div class="md:flex md:justify-end mb-5">
                <div class="flex items-center space-x-3">
                    <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M12 21C15.5 17.4 19 14.1764 19 10.2C19 6.22355 15.866 3 12 3C8.13401 3 5 6.22355 5 10.2C5 14.1764 8.5 17.4 12 21Z"
                                stroke="#4b5563" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                            <path
                                d="M12 12C13.1046 12 14 11.1046 14 10C14 8.89543 13.1046 8 12 8C10.8954 8 10 8.89543 10 10C10 11.1046 10.8954 12 12 12Z"
                                stroke="#4b5563" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                        </g>
                    </svg>
                    <span class="text-gray-600 font-semibold">Indonesia</span>
                </div>
            </div>
            <div class="border-y border-y-gray-600 py-6">
                <h1 class="text-white font-semibold">Ikuti kami di</h1>
                <div class="md:flex justify-between items-center space-y-2 md:space-y-0">
                    <div class="flex space-x-3 items-center">
                        {{-- youtube --}}
                        @if (!empty($setting->youtube))
                            <a href="{{ $setting->youtube }}" target="_blank">
                                <svg width="42px" height="42px" viewBox="0 -3 20 20" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    fill="#000000" stroke="#000000">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <title>youtube [#000000]</title>
                                        <desc>Created with Sketch.</desc>
                                        <defs> </defs>
                                        <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                            fill-rule="evenodd">
                                            <g id="Dribbble-Light-Preview"
                                                transform="translate(-300.000000, -7442.000000)" fill="#ffffff">
                                                <g id="icons" transform="translate(56.000000, 160.000000)">
                                                    <path
                                                        d="M251.988432,7291.58588 L251.988432,7285.97425 C253.980638,7286.91168 255.523602,7287.8172 257.348463,7288.79353 C255.843351,7289.62824 253.980638,7290.56468 251.988432,7291.58588 M263.090998,7283.18289 C262.747343,7282.73013 262.161634,7282.37809 261.538073,7282.26141 C259.705243,7281.91336 248.270974,7281.91237 246.439141,7282.26141 C245.939097,7282.35515 245.493839,7282.58153 245.111335,7282.93357 C243.49964,7284.42947 244.004664,7292.45151 244.393145,7293.75096 C244.556505,7294.31342 244.767679,7294.71931 245.033639,7294.98558 C245.376298,7295.33761 245.845463,7295.57995 246.384355,7295.68865 C247.893451,7296.0008 255.668037,7296.17532 261.506198,7295.73552 C262.044094,7295.64178 262.520231,7295.39147 262.895762,7295.02447 C264.385932,7293.53455 264.28433,7285.06174 263.090998,7283.18289"
                                                        id="youtube-[#000000]"> </path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </a>
                        @endif
                        {{-- facebook --}}
                        @if (!empty($setting->facebook))
                            <a href="{{ $setting->facebook }}" target="_blank">
                                <svg fill="#ffffff" width="46px" height="46px" viewBox="-5.5 0 32 32"
                                    version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <title>facebook</title>
                                        <path
                                            d="M1.188 5.594h18.438c0.625 0 1.188 0.563 1.188 1.188v18.438c0 0.625-0.563 1.188-1.188 1.188h-18.438c-0.625 0-1.188-0.563-1.188-1.188v-18.438c0-0.625 0.563-1.188 1.188-1.188zM14.781 17.281h2.875l0.125-2.75h-3v-2.031c0-0.781 0.156-1.219 1.156-1.219h1.75l0.063-2.563s-0.781-0.125-1.906-0.125c-2.75 0-3.969 1.719-3.969 3.563v2.375h-2.031v2.75h2.031v7.625h2.906v-7.625z">
                                        </path>
                                    </g>
                                </svg>
                            </a>
                        @endif
                        {{-- Instagram --}}
                        @if (!empty($setting->instagram))
                            <a href="{{ $setting->instagram }}" target="_blank">
                                <svg width="37px" height="37px" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M12 18C15.3137 18 18 15.3137 18 12C18 8.68629 15.3137 6 12 6C8.68629 6 6 8.68629 6 12C6 15.3137 8.68629 18 12 18ZM12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16Z"
                                            fill="#ffffff"></path>
                                        <path
                                            d="M18 5C17.4477 5 17 5.44772 17 6C17 6.55228 17.4477 7 18 7C18.5523 7 19 6.55228 19 6C19 5.44772 18.5523 5 18 5Z"
                                            fill="#ffffff"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M1.65396 4.27606C1 5.55953 1 7.23969 1 10.6V13.4C1 16.7603 1 18.4405 1.65396 19.7239C2.2292 20.8529 3.14708 21.7708 4.27606 22.346C5.55953 23 7.23969 23 10.6 23H13.4C16.7603 23 18.4405 23 19.7239 22.346C20.8529 21.7708 21.7708 20.8529 22.346 19.7239C23 18.4405 23 16.7603 23 13.4V10.6C23 7.23969 23 5.55953 22.346 4.27606C21.7708 3.14708 20.8529 2.2292 19.7239 1.65396C18.4405 1 16.7603 1 13.4 1H10.6C7.23969 1 5.55953 1 4.27606 1.65396C3.14708 2.2292 2.2292 3.14708 1.65396 4.27606ZM13.4 3H10.6C8.88684 3 7.72225 3.00156 6.82208 3.0751C5.94524 3.14674 5.49684 3.27659 5.18404 3.43597C4.43139 3.81947 3.81947 4.43139 3.43597 5.18404C3.27659 5.49684 3.14674 5.94524 3.0751 6.82208C3.00156 7.72225 3 8.88684 3 10.6V13.4C3 15.1132 3.00156 16.2777 3.0751 17.1779C3.14674 18.0548 3.27659 18.5032 3.43597 18.816C3.81947 19.5686 4.43139 20.1805 5.18404 20.564C5.49684 20.7234 5.94524 20.8533 6.82208 20.9249C7.72225 20.9984 8.88684 21 10.6 21H13.4C15.1132 21 16.2777 20.9984 17.1779 20.9249C18.0548 20.8533 18.5032 20.7234 18.816 20.564C19.5686 20.1805 20.1805 19.5686 20.564 18.816C20.7234 18.5032 20.8533 18.0548 20.9249 17.1779C20.9984 16.2777 21 15.1132 21 13.4V10.6C21 8.88684 20.9984 7.72225 20.9249 6.82208C20.8533 5.94524 20.7234 5.49684 20.564 5.18404C20.1805 4.43139 19.5686 3.81947 18.816 3.43597C18.5032 3.27659 18.0548 3.14674 17.1779 3.0751C16.2777 3.00156 15.1132 3 13.4 3Z"
                                            fill="#ffffff"></path>
                                    </g>
                                </svg>
                            </a>
                        @endif
                        {{-- Tiktok --}}
                        @if (!empty($setting->tiktok))
                            <a href="{{ $setting->tiktok }}" target="_blank">
                                <svg width="38px" height="38px" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path
                                            d="M16.8217 5.1344C16.0886 4.29394 15.6479 3.19805 15.6479 2H14.7293M16.8217 5.1344C17.4898 5.90063 18.3944 6.45788 19.4245 6.67608C19.7446 6.74574 20.0786 6.78293 20.4266 6.78293V10.2191C18.645 10.2191 16.9932 9.64801 15.6477 8.68211V15.6707C15.6477 19.1627 12.8082 22 9.32386 22C7.50043 22 5.85334 21.2198 4.69806 19.98C3.64486 18.847 2.99994 17.3331 2.99994 15.6707C2.99994 12.2298 5.75592 9.42509 9.17073 9.35079M16.8217 5.1344C16.8039 5.12276 16.7861 5.11101 16.7684 5.09914M6.9855 17.3517C6.64217 16.8781 6.43802 16.2977 6.43802 15.6661C6.43802 14.0734 7.73249 12.7778 9.32394 12.7778C9.62087 12.7778 9.9085 12.8288 10.1776 12.9124V9.40192C9.89921 9.36473 9.61622 9.34149 9.32394 9.34149C9.27287 9.34149 8.86177 9.36884 8.81073 9.36884M14.7244 2H12.2097L12.2051 15.7775C12.1494 17.3192 10.8781 18.5591 9.32386 18.5591C8.35878 18.5591 7.50971 18.0808 6.98079 17.3564"
                                            stroke="#ffffff" stroke-linejoin="round"></path>
                                    </g>
                                </svg>

                            </a>
                        @endif
                        {{-- X --}}
                        @if (!empty($setting->twitter))
                            <a href="{{ $setting->twitter }}" target="_blank">

                                <svg width="39px" height="39px" viewBox="0 -2 20 20" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    fill="#000000">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <title>twitter [#154]</title>
                                        <desc>Created with Sketch.</desc>
                                        <defs> </defs>
                                        <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                            fill-rule="evenodd">
                                            <g id="Dribbble-Light-Preview"
                                                transform="translate(-60.000000, -7521.000000)" fill="#ffffff">
                                                <g id="icons" transform="translate(56.000000, 160.000000)">
                                                    <path
                                                        d="M10.29,7377 C17.837,7377 21.965,7370.84365 21.965,7365.50546 C21.965,7365.33021 21.965,7365.15595 21.953,7364.98267 C22.756,7364.41163 23.449,7363.70276 24,7362.8915 C23.252,7363.21837 22.457,7363.433 21.644,7363.52751 C22.5,7363.02244 23.141,7362.2289 23.448,7361.2926 C22.642,7361.76321 21.761,7362.095 20.842,7362.27321 C19.288,7360.64674 16.689,7360.56798 15.036,7362.09796 C13.971,7363.08447 13.518,7364.55538 13.849,7365.95835 C10.55,7365.79492 7.476,7364.261 5.392,7361.73762 C4.303,7363.58363 4.86,7365.94457 6.663,7367.12996 C6.01,7367.11125 5.371,7366.93797 4.8,7366.62489 L4.8,7366.67608 C4.801,7368.5989 6.178,7370.2549 8.092,7370.63591 C7.488,7370.79836 6.854,7370.82199 6.24,7370.70483 C6.777,7372.35099 8.318,7373.47829 10.073,7373.51078 C8.62,7374.63513 6.825,7375.24554 4.977,7375.24358 C4.651,7375.24259 4.325,7375.22388 4,7375.18549 C5.877,7376.37088 8.06,7377 10.29,7376.99705"
                                                        id="twitter-[#154]"> </path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </a>
                        @endif
                        {{-- whatsapp --}}
                        @if (!empty($setting->whatsapp))
                            <a href="{{ $setting->whatsapp }}" target="_blank">
                                <svg width="38px" height="38px" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M3.50002 12C3.50002 7.30558 7.3056 3.5 12 3.5C16.6944 3.5 20.5 7.30558 20.5 12C20.5 16.6944 16.6944 20.5 12 20.5C10.3278 20.5 8.77127 20.0182 7.45798 19.1861C7.21357 19.0313 6.91408 18.9899 6.63684 19.0726L3.75769 19.9319L4.84173 17.3953C4.96986 17.0955 4.94379 16.7521 4.77187 16.4751C3.9657 15.176 3.50002 13.6439 3.50002 12ZM12 1.5C6.20103 1.5 1.50002 6.20101 1.50002 12C1.50002 13.8381 1.97316 15.5683 2.80465 17.0727L1.08047 21.107C0.928048 21.4637 0.99561 21.8763 1.25382 22.1657C1.51203 22.4552 1.91432 22.5692 2.28599 22.4582L6.78541 21.1155C8.32245 21.9965 10.1037 22.5 12 22.5C17.799 22.5 22.5 17.799 22.5 12C22.5 6.20101 17.799 1.5 12 1.5ZM14.2925 14.1824L12.9783 15.1081C12.3628 14.7575 11.6823 14.2681 10.9997 13.5855C10.2901 12.8759 9.76402 12.1433 9.37612 11.4713L10.2113 10.7624C10.5697 10.4582 10.6678 9.94533 10.447 9.53028L9.38284 7.53028C9.23954 7.26097 8.98116 7.0718 8.68115 7.01654C8.38113 6.96129 8.07231 7.046 7.84247 7.24659L7.52696 7.52195C6.76823 8.18414 6.3195 9.2723 6.69141 10.3741C7.07698 11.5163 7.89983 13.314 9.58552 14.9997C11.3991 16.8133 13.2413 17.5275 14.3186 17.8049C15.1866 18.0283 16.008 17.7288 16.5868 17.2572L17.1783 16.7752C17.4313 16.5691 17.5678 16.2524 17.544 15.9269C17.5201 15.6014 17.3389 15.308 17.0585 15.1409L15.3802 14.1409C15.0412 13.939 14.6152 13.9552 14.2925 14.1824Z"
                                            fill="#ffffff"></path>
                                    </g>
                                </svg>
                            </a>
                        @endif
                        {{-- Telegram --}}
                        @if (!empty($setting->telegram))
                            <a href="{{ $setting->telegram }}" target="_blank">
                                <svg width="39px" height="39px" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M21.997 12C21.997 17.5228 17.5198 22 11.997 22C6.47415 22 1.99699 17.5228 1.99699 12C1.99699 6.47715 6.47415 2 11.997 2C17.5198 2 21.997 6.47715 21.997 12ZM12.3553 9.38244C11.3827 9.787 9.43876 10.6243 6.52356 11.8944C6.05018 12.0827 5.8022 12.2669 5.77962 12.4469C5.74147 12.7513 6.12258 12.8711 6.64155 13.0343C6.71214 13.0565 6.78528 13.0795 6.86026 13.1038C7.37085 13.2698 8.05767 13.464 8.41472 13.4717C8.7386 13.4787 9.10009 13.3452 9.49918 13.0711C12.2229 11.2325 13.629 10.3032 13.7172 10.2831C13.7795 10.269 13.8658 10.2512 13.9243 10.3032C13.9828 10.3552 13.977 10.4536 13.9708 10.48C13.9331 10.641 12.4371 12.0318 11.6629 12.7515C11.4216 12.9759 11.2504 13.135 11.2154 13.1714C11.137 13.2528 11.0571 13.3298 10.9803 13.4038C10.506 13.8611 10.1502 14.204 11 14.764C11.4083 15.0331 11.7351 15.2556 12.0611 15.4776C12.4171 15.7201 12.7722 15.9619 13.2317 16.2631C13.3487 16.3398 13.4605 16.4195 13.5694 16.4971C13.9837 16.7925 14.3559 17.0579 14.8158 17.0155C15.083 16.991 15.359 16.7397 15.4992 15.9903C15.8305 14.2193 16.4817 10.382 16.6322 8.80081C16.6454 8.66228 16.6288 8.48498 16.6154 8.40715C16.6021 8.32932 16.5743 8.21842 16.4731 8.13633C16.3533 8.03911 16.1683 8.01861 16.0856 8.02C15.7095 8.0267 15.1324 8.22735 12.3553 9.38244Z"
                                            stroke="#ffffff" stroke-linejoin="round"></path>
                                    </g>
                                </svg>
                            </a>
                        @endif
                    </div>

                    <div class="flex items-center max-w-sm">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M4 7.00005L10.2 11.65C11.2667 12.45 12.7333 12.45 13.8 11.65L20 7"
                                            stroke="#787878" stroke-width="1.152" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                        <rect x="3" y="5" width="18" height="14" rx="2"
                                            stroke="#787878" stroke-width="1.152" stroke-linecap="round"></rect>
                                    </g>
                                </svg>
                            </div>
                            <input type="text" id="simple-search"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Email address" required />
                        </div>
                        <button type="submit"
                            class="p-2.5 ms-2 text-sm font-medium text-white bg-gray-700 rounded-lg border border-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-blue-800">
                            <p>Subscribe</p>
                        </button>
                    </div>

                </div>
            </div>
            <div>
                <ul class="md:flex items-center md:space-x-4 text-white mt-5 font-semibold space-y-2 md:space-y-0">
                    <li>
                        <a href="{{ route('terms') }}" wire:navigate>
                            Syarat & Ketentuan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('privacy') }}" wire:navigate>
                            Kebijakan Privasi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('howtorent') }}" wire:navigate>
                            Cara Sewa
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('faqs') }}" wire:navigate>
                            FAQ
                        </a>
                    </li>
                </ul>
                <div class="flex w-full justify-between items-start">
                    <div class="w-[50%] h-[50%] md:w-40 md:h-40 mt-5">
                        <h3 class="text-gray-500 font-semibold text-sm md:text-base">Jl. KH. Imam Bahri, Dusun Kopen,
                            Desa
                            Genteng Kulon, Kec.
                            Genteng, Kab. Banyuwangi</h3>
                    </div>
                    <img class="w-20 h-[70px] md:w-[160px] md:h-[140px] object-contain"
                        src="{{ url('IMG_0976-removebg-preview1.png') }}" alt="" srcset="">
                </div>
            </div>
        </div>
    </footer>
    <script type='text/javascript'>
        //<![CDATA[
        function ignielLazyLoad() {
            eval(function(p, a, c, k, e, d) {
                e = function(c) {
                    return (c < a ? '' : e(parseInt(c / a))) + ((c = c % a) > 35 ? String.fromCharCode(c + 29) :
                        c.toString(36))
                };
                if (!''.replace(/^/, String)) {
                    while (c--) {
                        d[e(c)] = k[c] || e(c)
                    }
                    k = [function(e) {
                        return d[e]
                    }];
                    e = function() {
                        return '\\w+'
                    };
                    c = 1
                };
                while (c--) {
                    if (k[c]) {
                        p = p.replace(new RegExp('\\b' + e(c) + '\\b', 'g'), k[c])
                    }
                }
                return p
            }('u B(){Y(v e=o.1r("B"),t=0;t<e.1q;t++)Q(e[t])&&(e[t].N=e[t].1p("1n-N"))}u Q(e){v t=e.1t();Z t.1x>=0&&t.1w>=0&&t.1v<=(y.1u||o.T.1m)&&t.1k<=(y.1c||o.T.1b)}v b=["\\r\\m\\m\\D\\G\\a\\f\\c\\M\\n\\p\\c\\a\\f\\a\\k","\\h\\f","\\r\\c\\c\\r\\l\\A\\D\\G\\a\\f\\c","\\g\\h\\r\\m","\\p\\l\\k\\h\\g\\g","\\V\\1a\\1e\\R\\h\\f\\c\\a\\f\\c\\M\\h\\r\\m\\a\\m","\\w\\p\\a\\1l\\p\\c\\k\\n\\l\\c","\\r","\\1f\\w\\a\\k\\L\\1j\\a\\g\\a\\l\\c\\h\\k\\W\\g\\g","\\g\\a\\f\\q\\c\\A","\\w\\p\\a\\k\\W\\q\\a\\f\\c","\\c\\a\\p\\c","\\m\\h\\l\\w\\F\\a\\f\\c\\D\\g\\a\\F\\a\\f\\c","\\1i\\h\\m\\L","\\l\\g\\n\\l\\1g","\\p\\l\\k\\h\\g\\g\\1h\\h\\J","\\c\\h\\J","\\q\\a\\c\\S\\h\\w\\f\\m\\n\\f\\q\\R\\g\\n\\a\\f\\c\\1z\\a\\l\\c","\\A\\k\\a\\X","\\a\\1y\\a\\l","\\q\\a\\c\\D\\g\\a\\F\\a\\f\\c\\S\\L\\1F\\m","\\p\\l\\k\\h\\g\\g\\U\\a\\n\\q\\A\\c","\\n\\f\\f\\a\\k\\U\\a\\n\\q\\A\\c","\\J\\k\\a\\G\\a\\f\\c\\V\\a\\X\\r\\w\\g\\c","\\n\\c\\a\\F"];u I(d,j){y[b[0]]?y[b[0]](d,j):y[b[2]](b[1]+d,j)}I(b[3],B),I(b[4],B),o[b[0]](b[5],u(){b[6];Y(v d=o[b[8]](b[7]),j=d[b[9]],s=/1D|1B/i[b[11]](1G[b[10]])?o[b[12]]:o[b[13]],C=u(d,j,s,C){Z(d/=C/2)<1?s/2*d*d*d+j:s/2*((d-=2)*d*d+2)+j};j--;){d[b[1C]](j)[b[0]](b[14],u(d){v j,E=s[b[15]],x=o[b[1A]](/[^#]+$/[b[19]](1H[b[18]])[0])[b[17]]()[b[16]],z=s[b[1d]]-y[b[1s]],O=z>E+x?x:z-E,K=1o,H=u(d){j=j||d;v x=d-j,z=C(x,E,O,K);s[b[15]]=z,K>x&&P(H)};P(H),d[b[1E]]()})}});',
                62, 106,
                '||||||||||x65|_0x1b5d|x74|_0xdd48x2||x6E|x6C|x6F||_0xdd48x3|x72|x63|x64|x69|document|x73|x67|x61|_0xdd48x4||function|var|x75|_0xdd48x7|window|_0xdd48x8|x68|lazy|_0xdd48x5|x45|_0xdd48x6|x6D|x76|_0xdd48xb|registerListener|x70|_0xdd48xa|x79|x4C|src|_0xdd48x9|requestAnimationFrame|isInViewport|x43|x42|documentElement|x48|x44|x41|x66|for|return|||||||||||x4F|clientWidth|innerWidth|21|x4D|x71|x6B|x54|x62|x53|left|x20|clientHeight|data|900|getAttribute|length|getElementsByClassName|22|getBoundingClientRect|innerHeight|top|right|bottom|x78|x52|20|trident|24|firefox|23|x49|navigator|this'
                .split('|'), 0, {}));
        }
        eval(function(p, a, c, k, e, d) {
            e = function(c) {
                return c.toString(36)
            };
            if (!''.replace(/^/, String)) {
                while (c--) {
                    d[c.toString(a)] = k[c] || c.toString(a)
                }
                k = [function(e) {
                    return d[e]
                }];
                e = function() {
                    return '\\w+'
                };
                c = 1
            };
            while (c--) {
                if (k[c]) {
                    p = p.replace(new RegExp('\\b' + e(c) + '\\b', 'g'), k[c])
                }
            }
            return p
        }('j 4=["\\7\\9\\9\\e\\d\\a\\b\\8\\i\\g\\h\\8\\a\\b\\a\\k","\\f\\c\\7\\9","\\7\\8\\8\\7\\m\\l\\e\\d\\a\\b\\8","\\c\\b\\f\\c\\7\\9"];5[4[0]]?5[4[0]](4[1],6,!1):5[4[2]]?5[4[2]](4[1],6):5[4[3]]=6;5[4[0]]?5[4[0]](4[1],6,!1):5[4[2]]?5[4[2]](4[1],6):5[4[3]]=6;',
            23, 23,
            '||||_0xdfb4|window|ignielLazyLoad|x61|x74|x64|x65|x6E|x6F|x76|x45|x6C|x69|x73|x4C|var|x72|x68|x63'
            .split('|'), 0, {}));
        //]]>
    </script>
</body>

</html>
