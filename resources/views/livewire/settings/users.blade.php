<div x-data="{
    createUser() {
            $dispatch('create-chapter')
            $dispatch('open-modal', 'user-create')
        },
        editUser(id) {

            $dispatch('open-modal', 'chapter-edit');
            $dispatch('edit', { value: id });

        }
}">
    <x-tables.table name="Users" count="{{ $users->count() }} Users">
        <x-slot name="secondBtn">
            <button
                class="flex items-center justify-center w-1/2 px-5 py-2 text-sm disabled:text-gray-700 transition-colors duration-200 disabled:bg-white border rounded-lg gap-x-2 sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700 bg-red-500 text-white"
                wire:click="destroyAlert" @if (!$mySelected) disabled @endif>
                <span>Bulk delete</span>
            </button>
        </x-slot>
        <x-slot name="addBtn">
            <x-tables.addbtn type="button" x-data="" @click="createUser">
                Add User
            </x-tables.addbtn>
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
                        <option selected>Filter by</option>
                        <option value="created_at">All</option>
                        <option value="updated_at">Updated</option>
                    </select>
                </div>
            </div>
        </x-slot>
        <x-slot name="search">
            <x-search wire:model.live.debounce.500ms="search" />
        </x-slot>
        <x-slot name="thead">
            <x-tables.th>
                <input id="selectedAll" type="checkbox"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                    wire:model.live="selectedAll">
            </x-tables.th>
            <x-tables.th>Name</x-tables.th>
            <x-tables.th>Email</x-tables.th>
            <x-tables.th>Role</x-tables.th>
            <x-tables.th>Created</x-tables.th>
            <x-tables.th>Updated</x-tables.th>
            <x-tables.th>Action</x-tables.th>
        </x-slot>

        <x-slot name="tbody">
            @foreach ($users as $index => $user)
                <tr>
                    <x-tables.td>
                        <input id="default-{{ $index }}" type="checkbox"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            wire:model.live="mySelected" value="{{ $user->id }}">
                    </x-tables.td>
                    <x-tables.td>{{ $user->name }}</x-tables.td>
                    <x-tables.td>{{ $user->email }}</x-tables.td>
                    <x-tables.td>
                        {{ $user->getRoleNames()->first() ?? '-' }}
                    </x-tables.td>
                    <x-tables.td>{{ $user->created_at->format('F j, Y') }}</x-tables.td>
                    <x-tables.td>{{ $user->updated_at->format('d M Y') }}</x-tables.td>
                    <x-tables.td>
                        {{-- <a href="{{ route('users.edit', $user->id) }}">
                            <x-primary-button type="button">edit</x-primary-button>
                        </a> --}}
                        <x-danger-button type="button"
                            wire:click="destroyAlert('{{ $user->id }}', 'delete')">delete</x-danger-button>
                    </x-tables.td>
                </tr>
            @endforeach
        </x-slot>

    </x-tables.table>
    <div class="w-full mt-5">
        {{ $users->links() }}
    </div>
     <x-modal name="user-create" :show="$errors->isNotEmpty()" maxWidth="sm" focusable>
        <livewire:settings.user-create />
    </x-modal>
</div>
