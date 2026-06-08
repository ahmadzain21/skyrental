 <div>
     <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
         {{-- Total Pendapatan --}}
         <x-mary-stat title="Total Pendapatan" :value="'Rp ' . number_format($revenueTotal, 0, ',', '.')" icon="o-banknotes" color="text-success" />

         {{-- Total Booking --}}
         <x-mary-stat title="Total Booking" :value="$totalBookings . 'x'" icon="o-calendar" color="text-primary" />

         {{-- Unit Tersedia --}}
         <x-mary-stat title="Unit Tersedia" :value="$totalAvailable" icon="o-device-phone-mobile" color="text-info" />

         {{-- Top Device --}}
         <x-mary-stat title="Top Device" :value="$topDevice['nama'] ?? '-'" icon="o-star" color="text-warning" />
     </div>

     {{-- datatable --}}
     <div class="mt-10">
         <x-tables.table name="Pendapatan" count="">
             <x-slot name="secondBtn">
                 <button
                     class="flex items-center justify-center w-1/2 px-5 py-2 text-sm disabled:text-gray-700 transition-colors duration-200 disabled:bg-white border rounded-lg gap-x-2 sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700 bg-red-500 text-white"
                     wire:click="destroyAlert" @if (!$mySelected) disabled @endif>
                     <span>Bulk delete</span>
                 </button>
             </x-slot>
             <x-slot name="addBtn">
                 {{-- <x-tables.addbtn type="button" x-data="" @click="window.location.href = ''">
           Add iPhone
       </x-tables.addbtn> --}}
             </x-slot>
             <x-slot name="sort">
                 <div class="flex items-center space-x-2 w-1/2 ">
                     <div class="w-fit">
                         <select id="sort_series"
                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 px-5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                             wire:model.live="paginate">
                             <option value="10">10</option>
                             <option value="50">50</option>
                             <option value="100">100</option>
                             <option value="150">150</option>
                         </select>
                     </div>
                     <div class="w-fit">
                         <select id="sort"
                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 px-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                             wire:model.live="sortField">
                             <option value="">Urutkan berdasarkan</option>
                             <option value="amount">Jumlah Pendapatan</option>
                             <option value="bookings">Jumlah Disewa</option>
                             <option value="created">Tanggal Dibuat</option>
                             <option value="updated_at">Terakhir Diperbarui</option>
                         </select>

                     </div>
                 </div>
             </x-slot>
             <x-slot name="search">
                 <x-search wire:model.live.debounce.500ms="search" />
             </x-slot>
             <x-slot name="thead">
                 <x-tables.th>
                     <input id="selectedAll"
                         type="checkbox"class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                         wire:model.live="selectedAll">
                     {{-- <input type="hidden" wire:model.live="firstId" value="{{ $serieses[0]->id }}"> --}}
                 </x-tables.th>
                 <x-tables.th>iPhone</x-tables.th>
                 <x-tables.th>Disewa</x-tables.th>
                 <x-tables.th>Pendapatan</x-tables.th>
                 <x-tables.th>Kontribusi</x-tables.th>


             </x-slot>
             <x-slot name="tbody">
                 @foreach ($devices as $index => $device)
                     <tr>
                         <x-tables.td>
                             <input id="default-{{ $index }}" type="checkbox"
                                 class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                 wire:model.live="mySelected" value="{{ $index }}">
                         </x-tables.td>

                         {{-- Nama iPhone --}}
                         <x-tables.td>
                             {{ $device['nama'] }}
                         </x-tables.td>

                         {{-- Jumlah disewa --}}
                         <x-tables.td>
                             {{ $device['total_disewa'] }}x
                         </x-tables.td>

                         {{-- Pendapatan --}}
                         <x-tables.td>
                             Rp {{ number_format($device['total_pendapatan'], 0, ',', '.') }}
                         </x-tables.td>

                         <x-tables.td>
                             <div class="w-[50%] bg-gray-200 rounded h-3">
                                 <div class="bg-violet-400 h-3 rounded" style="width: {{ $device['kontribusi'] }}%">
                                 </div>
                             </div>
                             <span class="text-sm">{{ $device['kontribusi'] }}%</span>

                         </x-tables.td>
                     </tr>
                 @endforeach
             </x-slot>
         </x-tables.table>
     </div>
 </div>
