<div class="p-3 min-h-[50vh] max-h-[80vh] overflow-y-auto" x-data="{
    permission: false,
}">
    <header>
        <h1 class="text-xl font-semibold">Admin dan editor</h1>
    </header>
    <div class="w-full">
        <div class="flex space-x-1 items-center w-full">
            <input type="text" placeholder="Cari berdasarkan nama"
                class="border-x-0 px-0 border-t-0 w-full placeholder:text-gray-400 border-b-2 border-b-gray-300 focus:ring-0 focus:border-t-0"
                wire:model.live.debounce.200ms="searchInput" x-on:focus="permission = true">
            <button type="button" @click="permission = ! permission">
                <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" class="ease-in duration-200"
                    :class="permission ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg">
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
        <div class="w-full mt-3 border-b-2 border-b-gray-400" x-show="permission" x-collapse>
            <div class="w-full h-32 overflow-y-auto space-y-2 ">
                @empty(!$users)
                    @forelse ($users as $index => $user)
                        <div class="flex items-end justify-between p-2 bg-gray-200 rounded-sm hover:bg-gray-300 bg-opacity-80 ease-i duration-150">
                            <div>
                                <h3 class="text-blue-500 text-base font-medium">{{ $user->name }}</h3>
                                <p class="text-sm font-medium text-gray-400">{{ $user->email }}</p>
                            </div>
                            <div>
                                <select id="user-{{ $index }}"
                                    class="bg-transparent font-semibold px-6 border-0 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-0 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    x-on:change="$wire.setRole({{ $index }}, $event.target.value, '{{ $user->id }}')" wire:model="selectedRoles.{{ $index }}">
                                    <option selected>{{ $user->getRoleNames()->first() ?? '' }}</option>
                                    @foreach ($roles as $role)
                                        @if ($role->name !== $user->getRoleNames()->first())
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @empty
                        <div class="text-base font-medium w-full text-center mt-4">User tidak
                            ada/ditemukan</div>
                    @endforelse
                @endempty
            </div>
        </div>
        <div class="space-y-2 mt-3">
            @forelse ($inPermissionUser as $index => $userInPermission)
                <div class="flex items-end justify-between p-2 bg-gray-200 rounded-sm hover:bg-gray-300 bg-opacity-80 ease-i duration-150">
                    <div>
                        <h3 class="text-blue-500 text-base font-medium">{{ $userInPermission->name }}</h3>
                        <p class="text-sm font-medium text-gray-500">{{ $userInPermission->email }}</p>
                    </div>
                    <div>
                        <select id="userInPermission-{{ $index }}"
                            class="bg-transparent font-semibold px-6 border-0 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-0 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            x-on:change="$wire.setRole({{ $index }}, $event.target.value, '{{ $userInPermission->id }}')" wire:model="selectedRoles.{{ $index }}">
                            <option selected>{{ $userInPermission->getRoleNames()[0] }}</option>
                            @foreach ($roles as $role)
                                @if ($role->name !== $userInPermission->getRoleNames()[0])
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            @empty
                <div class="text-base font-medium w-full text-center mt-4">User tidak
                    ada/ditemukan</div>
            @endforelse
        </div>
    </div>
</div>
