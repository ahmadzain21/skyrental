<?php

namespace App\Livewire\Settings;

use App\Models\User;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class Users extends Component
{
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $paginate = 10;

    public $mySelected = [];
    public $selectedAll = false;

    
    public function getData()
    {
        $query = User::query();

        if ($this->search) {
            $query->search(['name'], $this->search);
        }

        if (in_array($this->sortField, ['created_at', 'updated_at'])) {

            $query->orderBy($this->sortField, $this->sortDirection);
        }

        // Jangan panggil get() di sini, biarkan query builder tetap sebagai objek query
        return $query;
    }

     public function destroyAlert($value = '', $onConfirm = 'destroy')
    {
        LivewireAlert::title('Delete this posts ?')
            ->warning()
            ->toast()
            ->position('top-end')
            ->withConfirmButton('Delete')
            ->confirmButtonColor('green')
            ->cancelButtonColor('red')
            ->withCancelButton('Cancel')
            ->onConfirm($onConfirm, ['data' => $value])
            ->show();
    }

    public function delete($data)
    {
        if (auth()->user()->can('delete')) {
            $this->mySelected[] = $data['data'];
            $this->destroy('deleted successfully');
        } else {
            LivewireAlert::title('kamu tidak memiliki izin')
                ->position('top-end')
                ->text('tidak dapat menghapus data')
                ->timer(5000)
                ->error()
                ->show();
            $this->mySelected = [];
            $this->selectedAll = false;
        }
    }

    public function destroy()
    {
        // dd($this->mySelected);
        if (auth()->user()->can('delete')) {
            if ($this->mySelected) {
                try {
                    //code...
                    // dd('masuk ke try');
                    User::whereIn('id', $this->mySelected)->delete();
                    $this->mySelected = [];
                    $this->selectedAll = false;
                    LivewireAlert::title('User deleted successfully')
                        ->position('top-end')
                        ->toast()
                        ->text('User(s) deleted successfully')
                        ->timer(5000)
                        ->success()
                        ->show();
                } catch (\Throwable $th) {
                    LivewireAlert::title('User tidak ditemukan 1')
                        ->position('top-end')
                        ->toast()
                        ->text('tidak dapat menghapus data')
                        ->timer(5000)
                        ->error()
                        ->show();
                }
            } else {
                LivewireAlert::title('Tidak ada data yang dipilih')
                    ->position('top-end')
                    ->toast()
                    ->text('tidak dapat menghapus data')
                    ->timer(5000)
                    ->error()
                    ->show();
            }
        } else {
            LivewireAlert::title('kamu tidak memiliki izin')
                ->position('top-end')
                ->toast()
                ->text('tidak dapat menghapus data')
                ->timer(5000)
                ->error()
                ->show();
            $this->mySelected = [];
            $this->selectedAll = false;
        }
    }
    
    public function updatedSelectedAll($val)
    {
        $val ? $this->mySelected = $this->getData()->limit($this->paginate)->pluck('id') : $this->mySelected = [];
    }

    public function updatedMySelected()
    {
        if (count($this->mySelected) === $this->paginate) {
            $this->selectedAll = true;
        } else {
            $this->selectedAll = false;
        }
    }
    
    #[On('re-render')]
    public function reRender()
    {
    }
    
    public function render()
    {
        return view('livewire.settings.users', [
            'users' => $this->getData()->paginate($this->paginate)
        ]);
    }
}
