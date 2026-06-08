<?php

namespace App\Livewire\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class UserCreate extends Component
{
    public $name;
    public $email;
    public $password;

    public function save()
    {
        if (auth()->user()->hasRole('super-admin')) {
            $this->validate([
                'name' => 'required|string|min:3',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|min:8'
            ]);

            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password)
            ]);

            LivewireAlert::title('User created successfully')
                ->position('top-end')
                ->text('Berhasil membuat user baru')
                ->timer(5000)
                ->success()
                ->toast()
                ->show();
                
            $this->dispatch('re-render');
            $this->reset(['name' => 'email', 'password']);
        } else {
            LivewireAlert::title('Unauthorized')
                ->position('top-end')
                ->text('kamu tidak memiliki izin untuk membuat user')
                ->toast()
                ->timer(5000)
                ->warning()
                ->show();
        }
    }

    public function render()
    {
        return view('livewire.settings.user-create');
    }
}
