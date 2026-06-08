@php
    if ($isEdit) {
        $finalValue = \Carbon\Carbon::createFromFormat('Y-m-d', $value);
        if ($finalValue !== false) {
            $inicialDate = $finalValue->format('F j, Y');
        }
    } else {
        $inicialDate = $value->format('F j, Y');
    }
@endphp

<div x-cloak :class="!date ? 'border-b border-b-gray-400' : ''" x-data="{
    date: false,
    currentDate: '',
    dataDate: @entangle('value'),
    setDate: true,
    flatpickrInstance: null,
    dateInit: @js($inicialDate),

    init() {                                 
        let flat = document.querySelector('#flatpickr')
        this.flatpickrInstance = flatpickr(flat, {
            altInput: true,
            altFormat: 'F j, Y',
            dateFormat: 'Y-m-d',
            defaultDate: @js($value),
            onChange: (selectedDates, dateStr, instance) => {
                $wire.date = dateStr;
                this.dateInit = this.convertToCustomFormat(dateStr)
            }
        })
    },
    convertToCustomFormat(inputDate) {
        const parts = inputDate.split('-');
        const monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        const monthName = monthNames[parseInt(parts[1], 10) - 1];
        const formattedDate = `${monthName} ${parts[2]}, ${parseInt(parts[0], 10)}`;
        return formattedDate;
    },
}">
    <button type="button" @click="date = ! date" class="flex space-x-4 gray w-full py-2 cursor-pointer">
        <div x-data="$watch('setDate', value => {
            value == 'false' ? this.setDate = false : this.setDate = true
            $dispatch('inisiasi', this.setDate)
        })">
            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" class="ease-in duration-200"
                :class="date ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path
                        d="M15 11L12.2121 13.7879C12.095 13.905 11.905 13.905 11.7879 13.7879L9 11M7 21H17C19.2091 21 21 19.2091 21 17V7C21 4.79086 19.2091 3 17 3H7C4.79086 3 3 4.79086 3 7V17C3 19.2091 4.79086 21 7 21Z"
                        stroke="rgb(31, 41, 55)" stroke-width="2" stroke-linecap="round"></path>
                </g>
            </svg>
        </div>
        <div class="text-start">
            <x-input-label for="date">Dipublikasikan pada</x-input-label>
            <div class="text-base font-medium text-gray-400 mt-1" x-show="!date" x-text="dateInit">
            </div>
        </div>
    </button>
    <div x-show="date" x-collapse class="space-y-2">

        <div class="flex items-center">
            <input id="date-otomatis" type="radio" value="true" name="date-radio"
                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                x-model="setDate">
            <label for="date-otomatis"
                class="ms-2 text-base font-medium text-gray-800  dark:text-gray-300">Otomatis</label>
        </div>
        <div class="flex items-center">
            <input id="default-radio-2" type="radio" value="false" name="date-radio"
                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                x-model="setDate">
            <label for="default-radio-2" class="ms-2 text-base font-medium text-gray-800  dark:text-gray-300">Setel
                tanggal</label>
        </div>
        <div wire:ignore class="dateShow" :class="setDate ? 'hidden' : ''"
            @inisiasi.window="() => {
            let wrapp = document.querySelector('.dateShow')
            if($event.detail){
                wrapp.classList.add('hidden')
            } else {
                wrapp.classList.remove('hidden')
            }
        }">
            <input id="flatpickr" wire:model="value" wire:ignore type="text" placeholder="YYYY-MM-DD"
                class="border-x-0 border-t-0 w-full placeholder:text-gray-400 border-b-2 border-b-gray-300 focus:ring-0 py-2 px-1 focus:border-t-0" />
        </div>
    </div>
</div>
