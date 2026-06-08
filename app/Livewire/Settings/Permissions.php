<?php

namespace App\Livewire\Settings;

use App\Models\User;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Permissions extends Component
{
    public $searchInput = '';
    public $users;
    public $selectedRoles = [];

    public function setRole($index, $role, $user_id)
    {
        if (!auth()->user()->hasRole('super-admin')) {
            LivewireAlert::title('Unauthorized')
                ->text('You do not have permission to perform this action.')
                ->warning()
                ->toast()
                ->position('top-end')
                ->show();
            return;
        }
        $this->selectedRoles[$index] = $role;
        $user = User::find($user_id);
        $user->syncRoles($this->selectedRoles[$index]);

        LivewireAlert::title('Success!')
            ->text('Role updated successfully.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function getUsers()
    {
        return User::where('name', 'like', '%' . $this->searchInput . '%')
            ->latest('id')
            ->get();
    }

    public function getPermissionUser()
    {
        $rolesToSearch = ['admin', 'super-admin'];

        $users = User::whereHas('roles', function ($query) use ($rolesToSearch) {
            $query->whereIn('name', $rolesToSearch);
        })->get();

        return $users;
    }

    public function setSelectedUser($id) {}

    public function updatedSearchInput()
    {
        if ($this->searchInput !== '') {
            $this->users = $this->getUsers();
        } else {
            $this->users = [];
        }
    }

    public function render()
    {
        return view('livewire.settings.permissions', [
            'inPermissionUser' => $this->getPermissionUser(),
            'roles' => Role::all()
        ]);
    }
}
