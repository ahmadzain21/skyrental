<?php

namespace App\Livewire;

use App\Models\Faq as ModelsFaq;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use PhpParser\Node\Expr\AssignOp\Mod;

class Faq extends Component
{
    public $mySelected = [];

    public function destroy()
    {
        if (auth()->user()->can('delete')) {
            ModelsFaq::whereIn('id', $this->mySelected)->delete();
            $this->mySelected = [];
            LivewireAlert::title('Data berhasil dihapus')
                ->position('top-end')
                ->text('Data FAQ telah dihapus')
                ->toast()
                ->success()
                ->show();
        } else {
            LivewireAlert::title('Kamu tidak memiliki izin')
                ->position('top-end')
                ->text('Tidak dapat menghapus data FAQ')
                ->timer(5000)
                ->toast()
                ->error()
                ->show();
        }
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
        }
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

    public function toggleStatus($id, $is_active)
    {
        $faq = ModelsFaq::find($id);
        $faq->update([
            'is_active' => !$is_active
        ]);
        LivewireAlert::title('Status updated')
            ->position('top-end')
            ->text('Status berhasil di rubah')
            ->toast()
            ->success()
            ->show();
    }

    #[On('re-render')]
    public function reRender() {}

    public function render()
    {
        return view('livewire.faq', [
            'faqs' => ModelsFaq::orderBy('created_at', 'desc')->get(),
        ]);
    }
}
