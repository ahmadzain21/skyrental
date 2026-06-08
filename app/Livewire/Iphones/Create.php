<?php

namespace App\Livewire\Iphones;

use App\Models\Duration;
use App\Models\Iphones;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\On;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;

class Create extends Component
{
    public $name,
        $description,
        $urlPoster,
        $date,
        $slug,
        $gallery_id,
        $serial_number;


    public $durations = [
        [
            'index' => 0,
            'hours' => 24,
            'price' => 100000,
        ],
    ];

    public function mount()
    {
        $this->date = Carbon::now();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'gallery_id' => 'required|exists:galleries,id',
            'slug' => 'required|string|max:255|unique:iphones,slug',
            'serial_number' => 'required|string|max:255'
        ]);

        // 1. Simpan iPhone
        $iphone = Iphones::create([
            'name' => $this->name,
            'description' => $this->description,
            'gallery_id' => $this->gallery_id,
            'user_id' => auth()->id(),
            'slug' => $this->slug,
            'created' => $this->date->format('Y-m-d'),
            'serial_number' => $this->serial_number,
        ]);

        // dd($this->durations);
        // 2. Siapkan data attach [duration_id => ['price' => ...]]
        $syncData = [];
        foreach ($this->durations as $item) {
            // Cek apakah duration dengan 'hours' tersebut sudah ada
            $duration = Duration::firstOrCreate(
                ['hours' => $item['hours']]
            );

            // Bersihkan price agar hanya angka
            $cleanPrice = (int) preg_replace('/[^\d]/', '', $item['price']);

            // Attach dengan price yang sudah dibersihkan
            $syncData[$duration->id] = ['price' => $cleanPrice];
        }


        // dd($syncData);
        // 3. Attach relasi
        $iphone->durations()->attach($syncData);

        // 4. Reset input dan beri feedback
        $this->reset(['name', 'description', 'urlPoster', 'date', 'slug', 'gallery_id', 'durations', 'serial_number']);

        session()->flash('saved', [
            'title' => 'Changes Saved!',
            'text' => 'You can safely close the tab!',
        ]);

        $this->redirect(route('iphones'));
    }


    #[On('setslug')]
    public function setSlugAttribute()
    {
        $slug = Str::slug($this->name);
        $originalSlug = $slug;
        $count = 2;

        while (Iphones::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        $this->slug = $slug;
    }


    #[On('select-poster')]
    public function setSelectedposted($id, $url)
    {
        $this->gallery_id = $id;
        $this->urlPoster = $url;
    }

    public function removePoster()
    {
        $this->urlPoster = '';
        $this->gallery_id = '';
    }

    public function test()
    {
        LivewireAlert::title('Custom Alert')
            ->text('This alert has a unique style.')
            ->success()
            ->withOptions([
                'width' => '1000px',
                'background' => '#000000',
                'customClass' => ['popup' => 'animate__animated
      animate__fadeInUp
      animate__faster'],
                'allowOutsideClick' => false,
            ])->show();
    }

    public function render()
    {
        return view('livewire.iphones.create');
    }
}
