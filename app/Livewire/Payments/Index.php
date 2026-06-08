<?php

namespace App\Livewire\Payments;

use App\Models\Payment;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $paginate = 10;

    public $mySelected = [];
    public $selectedAll = false;

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
                ->toast()
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
        if (auth()->user()->can('delete')) {
            if ($this->mySelected) {
                try {
                    //code...
                    // dd('masuk ke try');
                    Payment::whereIn('id', $this->mySelected)->delete();
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
        $query = Payment::query();

        if ($this->search) {
            $query->search(['name', 'description', 'updated_at'], $this->search);
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
    
    #[On('refresh-payment')]
    public function reRender() {}
    
    public function render()
    {
        return view('livewire.payments.index', [
            'payments' => $this->getData()->paginate($this->paginate),
        ]);
    }
}
