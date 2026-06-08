<?php

namespace App\Livewire\Faq;

use App\Models\Faq;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class Create extends Component
{
    public $question;
    public $answer;

    public function save()
    {
        $this->validate([
            'question' => 'required|string|min:5|max:1000',
            'answer' => 'required|string|min:10',
        ]);

        if (Auth::user()->can('create')) {
            Faq::create([
                'question' => $this->question,
                'answer' => $this->answer,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            $this->dispatch('close-modal');
            $this->dispatch('re-render');
            $this->reset([
                'question',
                'answer',
            ]);
            LivewireAlert::title('Success!')
                ->text('FAQ berhasil dibuat')
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
    
    public function render()
    {
        return view('livewire.faq.create');
    }
}
