<?php

namespace App\Livewire\Iphones;

use App\Models\Duration;
use App\Models\Gallery;
use App\Models\Iphones;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

class Edit extends Component
{
    public $iphone,
        $name,
        $description,
        $urlPoster,
        $date,
        $slug,
        $gallery_id,
        $serial_number;

    public $durations = [];

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'gallery_id' => 'required|exists:galleries,id',
            'slug' => 'required|string|max:255|unique:iphones,slug,' . $this->iphone->id,
            'serial_number' => 'required|string|max:255'
        ]);

        $this->iphone->update([
            'name' => $this->name,
            'description' => $this->description,
            'gallery_id' => $this->gallery_id,
            'user_id' => auth()->id(),
            'slug' => $this->slug, // tidak perlu panggil setSlugAttribute
            'created' => Carbon::parse($this->date)->format('Y-m-d'),
            "serial_number" => $this->serial_number
        ]);

        // Sinkronisasi ulang durasi dan harga (pivot)
        $syncData = [];

        foreach ($this->durations as $item) {
            // Bersihkan nilai price jika masih string dari masking
            $cleanPrice = (int) preg_replace('/[^\d]/', '', $item['price']);

            // Cari duration berdasarkan hours
            $duration = Duration::firstOrCreate(['hours' => $item['hours']]);

            $syncData[$duration->id] = ['price' => $cleanPrice];
        }

        // Sinkronkan durasi ke iPhone (replace data lama)
        $this->iphone->durations()->sync($syncData);


        $this->reset(['name', 'description', 'urlPoster', 'date', 'slug', 'gallery_id', 'serial_number']);
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

    public function mount($iphone)
    {
        $this->durations = $iphone->durations->map(function ($duration, $index) {
            return [
                'index' => $index,
                'hours' => $duration->hours,
                'price' => (int) $duration->pivot->price,

            ];
        })->toArray();

        $this->iphone = $iphone;
        $this->name = $iphone->name;
        $this->description = $iphone->description;
        $this->date = $iphone->created;
        $this->slug = $iphone->slug;
        $this->urlPoster = Gallery::where('id', $this->iphone->gallery_id)->select('image')->first()?->image;
        $this->gallery_id = $iphone->gallery_id;
        $this->serial_number = $iphone->serial_number;
    }

    public function render()
    {
        return view('livewire.iphones.edit', [
            'iphone' => $this->iphone
        ]);
    }
}
