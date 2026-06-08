<div :class="!permalink ? 'border-b border-b-gray-400' : ''">
    <button type="button" @click="permalink = ! permalink"
        class="flex space-x-4 gray w-full py-2 cursor-pointer outline-none">
        <div>
            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                class="ease-in duration-200" :class="permalink ? 'rotate-180' : ''"
                xmlns="http://www.w3.org/2000/svg">
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
            <x-input-label for="permalink">Permalink</x-input-label>
            <input type="text"
            disabled
                class="border-0 focus:border-0 p-0 text-base font-medium text-gray-400 outline-none"
                wire:model="value">
        </div>
    </button>
    <div x-show="permalink" x-collapse>
        <input type="text"
            class="border-x-0 border-t-0 w-full placeholder:text-gray-400 border-b-2 border-b-gray-300 focus:ring-0 py-2 px-1 focus:border-t-0"
            placeholder="permalink" id="permalink" wire:model="value">
    </div>
</div>
