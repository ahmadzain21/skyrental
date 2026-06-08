<div wire:ignore x-data="{
    date: true,
    currentDate: '',
    dataDate: @entangle('value'),
    setDate: true,
    flatpickrInstance: null,

    init() {
        let flat = document.querySelector('#flatpickr')
        this.flatpickrInstance = flatpickr(flat, {
            altInput: true,
            altFormat: 'F j, Y',
            dateFormat: 'Y-m-d',
            defaultDate: @js($value),
            onChange: (selectedDates, dateStr, instance) => {
            {{-- console.log('Selected date:', dateStr); --}}
                $wire.value = dateStr;
                {{-- console.log(selectedDates) --}}
                let result = this.convertToCustomFormat(selectedDates);
                this.dateInit = result.date; // Update tanggal yang ditampilkan
            }
        })
    },

    convertToCustomFormat(inputDateString) {
        const dateObj = new Date(inputDateString); // Konversi string menjadi objek Date

        const monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        const day = dateObj.getDate(); // Tanggal
        const monthName = monthNames[dateObj.getMonth()]; // Nama bulan
        const year = dateObj.getFullYear(); // Tahun

        const hours = String(dateObj.getHours()).padStart(2, '0'); // Jam (24 jam)
        const minutes = String(dateObj.getMinutes()).padStart(2, '0'); // Menit

        const formattedDate = `${monthName} ${day}, ${year}`; // Contoh: July 19, 2025
        const formattedTime = `${hours}:${minutes}`; // Contoh: 11:38

        return {
            date: formattedDate,
            time: formattedTime
        };
    }
}">
    <div class="space-y-2" >
        <div >
            <input id="flatpickr" wire:model="value" wire:ignore type="text" placeholder="YYYY-MM-DD" class="w-full" />
        </div>
    </div>
</div>
