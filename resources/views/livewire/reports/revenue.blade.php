<div>
    <div class="grid md:grid-cols-5 grid-cols-2 gap-x-2">
        {{-- Revenue Hari Ini --}}
        <x-mary-stat title="Hari Ini" description="{{ now()->format('d F Y') }}"
            value="Rp {{ number_format($revenueToday, 0, ',', '.') }}" icon="o-banknotes" color="text-green-600" />

        {{-- Pendapatan Bulan Ini --}}
        <x-mary-stat title="Bulan Ini" description="{{ now()->format('F Y') }}"
            value="Rp {{ number_format($revenueThisMonth, 0, ',', '.') }}" icon="o-chart-bar" color="text-blue-600" />

        {{-- Total Revenue --}}
        <x-mary-stat title="Total Semua Waktu" value="Rp {{ number_format($revenueTotal, 0, ',', '.') }}"
            icon="o-currency-dollar" color="text-purple-600" />

        {{-- Revenue Denda --}}
        <x-mary-stat title="Revenue Denda" description="Total semua denda"
            value="Rp {{ number_format($revenuePenalty, 0, ',', '.') }}" icon="o-exclamation-circle"
            color="text-red-600" />

        {{-- Persentase Kenaikan/Penurunan Bulan Ini --}}
        <x-mary-stat title="Perubahan Bulanan"
            description="{{ $revenueThisMonthPercentage >= 0 ? 'Kenaikan' : 'Penurunan' }}"
            value="{{ $revenueThisMonthPercentage }}%"
            icon="{{ $revenueThisMonthPercentage >= 0 ? 'o-arrow-trending-up' : 'o-arrow-trending-down' }}"
            color="{{ $revenueThisMonthPercentage >= 0 ? 'text-green-600' : 'text-red-600' }}"
            tooltip-right="Dibanding bulan lalu" />
    </div>


    {{-- datatable --}}
    <div class="mt-10">
        <x-tables.table name="Pendapatan" count="{{ $revenues->count() }} ">
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
                <x-tables.th>Amount</x-tables.th>
                <x-tables.th>Type</x-tables.th>
                <x-tables.th>Customer</x-tables.th>
                <x-tables.th>WA</x-tables.th>
                <x-tables.th>iPhone</x-tables.th>
                <x-tables.th>Start Date</x-tables.th>
                <x-tables.th>End Date</x-tables.th>
                <x-tables.th>Duration</x-tables.th>
                <x-tables.th>Updated</x-tables.th>
                <x-tables.th>Created</x-tables.th>

            </x-slot>
            <x-slot name="tbody">
                @foreach ($revenues as $index => $revenue)
                    <tr>
                        <x-tables.td>
                            <input id="default-{{ $index }}" type="checkbox"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                wire:model.live="mySelected" value="{{ $revenue->id }}">
                        </x-tables.td>

                        <x-tables.td>
                            Rp{{ number_format($revenue->amount, 0, ',', '.') }}
                        </x-tables.td>

                        <x-tables.td>
                            @if ($revenue->type === 'booking')
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                    Booking
                                </span>
                            @elseif($revenue->type === 'extend')
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-700">
                                    Extend
                                </span>
                            @elseif($revenue->type === 'penalty')
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                    Denda
                                </span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                    -
                                </span>
                            @endif
                        </x-tables.td>

                        <x-tables.td>
                            {{ $revenue->booking->customer_name ?? '-' }}
                        </x-tables.td>

                        <x-tables.td>
                            {{ $revenue->booking->customer_phone ?? '-' }}
                        </x-tables.td>

                        <x-tables.td>
                            {{ $revenue->booking->iphone->name ?? '-' }}
                        </x-tables.td>

                        <x-tables.td>
                            {{ \Carbon\Carbon::parse($revenue->booking->start_booking_date)->format('d M Y') }}
                        </x-tables.td>

                        <x-tables.td>
                            {{ \Carbon\Carbon::parse($revenue->booking->end_booking_date)->format('d M Y') }}
                        </x-tables.td>

                        <x-tables.td>
                            {{ $revenue->booking->duration ?? '-' }} Jam
                        </x-tables.td>

                        <x-tables.td>
                            {{ $revenue->updated_at->diffForHumans() }}
                        </x-tables.td>
                        <x-tables.td>
                            {{ \Carbon\Carbon::parse($revenue->created)->format('d M Y H:i') }}
                        </x-tables.td>

                    </tr>
                @endforeach

            </x-slot>
        </x-tables.table>
    </div>

</div>
