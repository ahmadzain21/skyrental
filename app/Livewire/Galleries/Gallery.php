<?php

namespace App\Livewire\Galleries;

use App\Models\Gallery as ModelsGallery;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class Gallery extends Component
{
    use WithFileUploads;

    public $paginate = 20;
    public $images = [];


    public function saveImage()
    {
        if (auth()->user()->can('create')) {
            if (!empty($this->images)) {
                $this->validate([
                    'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
                ]);

                foreach ($this->images as $image) {
                    ModelsGallery::create([
                        'image' => $image->store('galleries', 'public')
                    ]);
                }

                LivewireAlert::title('Item Saved')
                    ->text('The item has been successfully saved to the database.')
                    ->success()
                    ->toast()
                    ->show();
                $this->dispatch('re-render');
                $this->images = [];
            } else {
                LivewireAlert::title('Error')
                    ->text('image tidak ditemukan')
                    ->error()
                    ->toast()
                    ->position('top-end')
                    ->show();
            }
        } else {
            $this->alert('error', 'kamu tidak memiliki izin');
            LivewireAlert::title('Unauthorize')
                ->text('Kamu tidak memiliki akses untuk merubah gambar')
                ->warning()
                ->toast()
                ->position('top-end')
                ->show();
        }
    }

    #[On('delete-poster')]
    public function deletePoster($id)
    {
        if (auth()->user()->can('delete')) {
            # code...
            $gallery = ModelsGallery::find($id);
            $gallery->delete();
            Storage::delete($gallery);
            LivewireAlert::title('Berhasil dihapus')
                ->text('Image deleted successfully')
                ->success()
                ->toast()
                ->position('top-end')
                ->show();
            $this->dispatch('re-render');
        } else {
            LivewireAlert::title('Unauthorize')
                ->text('Kamu tidak memiliki akses untuk merubah gambar')
                ->warning()
                ->toast()
                ->position('top-end')
                ->show();
        }
    }

    #[On('alert-me')]
    public function alertMe($status, $message)
    {
        if ($status == 'error') {
            # code...
            LivewireAlert::title('Error')
                ->text($message)
                ->error()
                ->toast()
                ->position('top-end')
                ->show();
        } else {
            LivewireAlert::title('Succes')
                ->text($message)
                ->success()
                ->toast()
                ->position('top-end')
                ->show();
        }
        // $this->alert($status, $message);
    }

    public function getGalleries()
    {
        return ModelsGallery::latest('id');
    }

    public function render()
    {
        return view('livewire.galleries.gallery', [
            'galleries' => $this->getGalleries()->paginate($this->paginate)
        ]);
    }
}
