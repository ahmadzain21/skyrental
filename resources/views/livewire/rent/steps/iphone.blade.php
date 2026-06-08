<div class="space-y-3 ">
    <div>
        {{-- Date picker --}}
        <div>
            <label for="requested_booking_date"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                booking</label>
            <livewire:booking.set-date wire:model="requested_booking_date" />
        </div>
        @error('requested_booking_date')
            <span class="error">Pilih tanggal sewa</span>
        @enderror
        {{-- Time picker --}}
        <div wire:ignore>
            <label for="timepicker" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Waktu
                mulai</label>
            {{-- Initialize flatpickr for time selection --}}
            <div class="border-gray-300" x-data="{
                timepickerinstance: null,
            
                init() {
                    let timepick = document.querySelector('#timepicker')
                    this.timepickerinstance = flatpickr(timepick, {
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: 'H:i',
                        time_24hr: true,
                        defaultDate: @js($requested_time ? \Carbon\Carbon::parse($requested_time)->format('H:i') : null),
                        onChange: (selectedDates, dateStr, instance) => {
                            $wire.requested_time = dateStr; // Update Livewire property
                            {{-- console.log(selectedDates) --}}
                            {{-- $wire.setTime(dateStr); // Call Livewire method to set time --}}
                        }
                    })
                },
            }">
                <input id="timepicker" wire:ignore type="text" placeholder="YYYY-MM-DD"
                    class="w-full border-gray-300 rounded-sm" />
            </div>
            @error('requested_time')
                <span class="error">Pilih jam sewa</span>
            @enderror
        </div>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">

        @foreach ($iphones as $iphone)
            <button wire:click="selectIphone({{ $iphone->id }})" @disabled(!$iphone->is_available)
                class="
                    relative rounded-xl border p-4 text-left transition
                    {{ $selectedIphoneId === $iphone->id ? 'border-black ring-2 ring-black' : 'border-gray-200' }}
                    {{ !$iphone->is_available ? 'opacity-40 cursor-not-allowed' : 'hover:border-black' }}
                ">
                {{-- IMAGE --}}
                <div class="flex justify-center mb-4">
                    <img src="{{ $iphone->image }}" alt="{{ $iphone->name }}" class="h-40 object-contain">
                </div>

                {{-- NAME --}}
                <p class="text-sm font-medium text-gray-900">
                    {{ $iphone->name }}
                </p>

                {{-- CODE / SERIAL --}}
                <p class="text-xs text-gray-500 mt-1">
                    {{ $iphone->code ?? '—' }}
                </p>

                {{-- STATUS --}}
                @if (!$iphone->is_available)
                    <span class="absolute top-3 right-3 text-xs bg-red-100 text-red-600 px-2 py-1 rounded">
                        Sedang disewa
                    </span>
                @endif
            </button>
        @endforeach

    </div>
</div>
