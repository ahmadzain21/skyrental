<?php

namespace App\Livewire\Faq;

use App\Models\Faq;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class Edit extends Component
{
    public $faq;
    public $question;
    public $answer;
    public $created_by;
    public $updated_by;

    public function update()
    {
        $this->validate([
            'question' => 'required|string|min:5|max:1000',
            'answer' => 'required|string|min:10',
        ]);

        if (auth()->user()->can('update')) {

            $this->faq->update([
                'question' => $this->question,
                'answer' => $this->answer,
                'updated_by' => Auth::id(),
            ]);

            $this->dispatch('close-modal');
            $this->dispatch('re-render');
            $this->reset([
                'question',
                'answer',
            ]);
            LivewireAlert::title('Success!')
                ->text('FAQ berhasil diupdate')
                ->success()
                ->toast()
                ->position('top-end')
                ->show();
        } else {
            LivewireAlert::title('Unauthorize')
                ->text('Kamu tidak memiliki akses untuk membuat FAQ')
                ->warning()
                ->toast()
                ->position('top-end')
                ->show();
        }
    }

    #[On('edit')]
    public function getEdit($value)
    {
        // dd($value);
        $this->faq = Faq::find($value);
        $this->question = $this->faq->question;
        $this->answer = $this->faq->answer;
    }

    public function render()
    {
        return view('livewire.faq.edit');
    }
}
