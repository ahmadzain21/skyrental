<div class="space-y-2" x-data="{
    selectShow: false,
}">
    <div class="flex space-x-1 items-center w-full">
        <div class="gap-1 flex flex-1 items-center ">
            @foreach ($selectedIphone as $selected)
                <button type="button" wire:click="restoreSeries"
                    class="bg-blue-500 w-fit px-2 py-0 text-white text-base font-semibold text-start">{{ $selected['title'] }}</button>
            @endforeach
        </div>
        <div class="flex space-x-1 items-center w-full">
            <input type="text" placeholder="Cari berdasarkan nama"
                class="border-x-0 px-0 border-t-0 w-full placeholder:text-gray-400 border-b-2 border-b-gray-300 focus:ring-0 focus:border-t-0"
                wire:model.live.debounce.200ms="searchIphone" x-on:focus="selectShow = true">
            <button type="button" @click="selectShow = ! selectShow">
                <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" class="ease-in duration-200"
                    :class="selectShow ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path
                            d="M15 11L12.2121 13.7879C12.095 13.905 11.905 13.905 11.7879 13.7879L9 11M7 21H17C19.2091 21 21 19.2091 21 17V7C21 4.79086 19.2091 3 17 3H7C4.79086 3 3 4.79086 3 7V17C3 19.2091 4.79086 21 7 21Z"
                            stroke="rgb(31, 41, 55)" stroke-width="2" stroke-linecap="round"></path>
                    </g>
                </svg>
            </button>
        </div>
    </div>
    @error('selectedIphone')
        <div class="error">{{ $message }}</div>
    @enderror
    <div class="w-full" x-show="selectShow" x-collapse>
        <div class="w-full h-32 overflow-y-auto">
            @forelse ($iphones as $index => $iphone)
                <div id="iphone-{{ $index }}"
                    class=" border-b border-b-gray-300 w-full flex items-center justify-between space-x-2">
                    <button type="button" wire:click="setSelectedIphone({{ $iphone->id }}, '{{ $iphone->name }}')"
                        class="w-full text-start p-1 hover:bg-gray-200 ease-in duration-150">{{ $iphone->name }}</button>
                </div>
            @empty
                <div class="text-base font-medium w-full text-center">iphone tidak
                    ada/ditemukan</div>
            @endforelse
        </div>
    </div>
</div>
