<?php

namespace App\Livewire;

use App\Models\Iphones;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class IphonesManagements extends Component
{
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $paginate = 10;

    public $mySelected = [];
    public $selectedAll = false;

    public function render()
    {
        $query = $this->getData()->paginate($this->paginate);

        return view('livewire.iphones-managements', [
            'iphones' => $query,
        ]);
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
                    Iphones::whereIn('id', $this->mySelected)->delete();
                    $this->mySelected = [];
                    $this->selectedAll = false;
                    LivewireAlert::title('Data berhasil dihapus')
                        ->position('top-end')
                        ->toast()
                        ->text('bulk delete data berhasil')
                        ->timer(5000)
                        ->success()
                        ->show();
                } catch (\Throwable $th) {
                    LivewireAlert::title('iPhone tidak ditemukan 1')
                        ->position('top-end')
                        ->toast()
                        ->text('tidak dapat menghapus data')
                        ->timer(5000)
                        ->error()
                        ->show();
                }
            } else {
                LivewireAlert::title('iPhone tidak ditemukan 2')
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

    public function getData()
    {
        $query = Iphones::query();

        if ($this->search) {
            $query->search(['name', 'description', 'updated_at', 'serial_number'], $this->search);
        }

        if (in_array($this->sortField, ['created_at', 'updated_at'])) {

            $query->orderBy($this->sortField, $this->sortDirection);
        }

        // Jangan panggil get() di sini, biarkan query builder tetap sebagai objek query
        return $query;
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

    public function updatedPage($page)
    {
        $this->mySelected = [];
        $this->selectedAll = false;
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div class="w-full min-h-[60vh] flex justify-center items-center">
            <svg width="64px" height="64px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="none" class="animate-spin"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g fill="#f43f5e" fill-rule="evenodd" clip-rule="evenodd"> <path d="M8 1.5a6.5 6.5 0 100 13 6.5 6.5 0 000-13zM0 8a8 8 0 1116 0A8 8 0 010 8z" opacity=".2"></path> <path d="M7.25.75A.75.75 0 018 0a8 8 0 018 8 .75.75 0 01-1.5 0A6.5 6.5 0 008 1.5a.75.75 0 01-.75-.75z"></path> </g> </g></svg>
            <span class="sr-only">Loading...</span>
        </div>
        HTML;
    }
}
