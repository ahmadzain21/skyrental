<div x-data="{
    generateRoute() {
        $wire.generateRoute()
    }
}">
    <div class="grid grid-cols-3 gap-4 mb-6">
        <x-mary-stat 
            title="Total Delivery Hari Ini"
            :value="$deliveryBookings->count() . ' Booking'"
            icon="o-truck"
            color="text-blue-600" 
        />

        <x-mary-stat 
            title="Sudah Dipilih"
            :value="count($selectedBookings) . ' Booking'"
            icon="o-check-circle"
            color="text-green-600" 
        />

        <x-mary-stat 
            title="Belum Diproses"
            :value="$pendingDelivery->count() . ' Booking'"
            icon="o-clock"
            color="text-yellow-600" 
        />
    </div>

    <x-tables.table name="Delivery Booking">

        {{-- tombol tambahan --}}
        <x-slot name="secondBtn">
            <button
                wire:click="autoSelectByTime"
                class="px-4 py-2 bg-orange-500 text-white rounded-lg">
                Auto Pilih Berdasarkan Jam
            </button>
        </x-slot>

        <x-slot name="addBtn">
            <button
                @click="generateRoute()"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                Generate Route
            </button>
        </x-slot>

        <x-slot name="search">
            <x-search wire:model.live.debounce.500ms="search" />
        </x-slot>

        <x-slot name="thead">
            <x-tables.th>
                <input type="checkbox" wire:model.live="selectedAll">
            </x-tables.th>
            <x-tables.th>Booking Code</x-tables.th>
            <x-tables.th>Customer</x-tables.th>
            <x-tables.th>Alamat Delivery</x-tables.th>
            <x-tables.th>Jam Booking</x-tables.th>
            <x-tables.th>Status</x-tables.th>
            <x-tables.th>Aksi</x-tables.th>
        </x-slot>

        <x-slot name="tbody">
            @foreach($deliveryBookings as $booking)
                <tr>
                    <x-tables.td>
                        <input
                            type="checkbox"
                            wire:model.live="selectedBookings"
                            value="{{ $booking->id }}">
                    </x-tables.td>

                    <x-tables.td>
                        {{ $booking->booking_code }}
                    </x-tables.td>

                    <x-tables.td>
                        {{ $booking->customer_name }}
                    </x-tables.td>

                    <x-tables.td>
                        <div class="max-w-xs truncate">
                            {{ $booking->address }}
                        </div>
                    </x-tables.td>

                    <x-tables.td>
                        {{ $booking->start_time }}
                    </x-tables.td>

                    <x-tables.td>
                        @if($booking->status === 'confirmed')
                            <span class="px-2 py-1 bg-green-500 text-white rounded">
                                Confirmed
                            </span>
                        @else
                            <span class="px-2 py-1 bg-yellow-500 text-white rounded">
                                Pending
                            </span>
                        @endif
                    </x-tables.td>

                    <x-tables.td class="flex gap-2">
                        <x-primary-button
                            wire:click="showRoute({{ $booking->id }})">
                            Route
                        </x-primary-button>

                        <x-primary-button
                            wire:click="markDelivered({{ $booking->id }})">
                            Delivered
                        </x-primary-button>
                    </x-tables.td>
                </tr>
            @endforeach
        </x-slot>

    </x-tables.table>
</div>