<?php

namespace App\Livewire\Settings;

use App\Models\Iphones;
use Livewire\Attributes\On;
use Livewire\Component;

class SetIphone extends Component
{
    public $selectedIphone = [];
    public $iphones;
    public $searchIphone;

    public function getIphones()
    {
        return Iphones::search('name', $this->searchIphone)->latest('id')->take(10)->get();
    }

    public function restoreSeries()
    {
        $this->iphones = $this->getIphones();
        $this->selectedIphone = [];
    }

    public function removeIphone($id)
    {
        // Menghapus genre dengan ID tertentu dari $this->iphones
        $this->iphones = $this->iphones->reject(function ($iphones) use ($id) {
            return $iphones->id == $id;
        });
    }

    public function setSelectedIphone($id, $title)
    {
        $this->removeIphone($id);
        $this->selectedIphone = [];
        $this->selectedIphone[] = ['id' => $id, 'title' => $title];
        $this->dispatch('setSelectedIphone', $this->selectedIphone[0]['id']);
    }

    #[On('create-slider')]
    public function isCreate()
    {
        $this->selectedIphone = [];
    }

    #[On('editIphone')]
    public function editIphone($value)
    {
        $this->selectedIphone = [];
        $this->selectedIphone = $value;
    }

    public function mount()
    {
        $this->iphones = $this->getIphones();
    }

    public function updatedSearchIphone()
    {
        $this->iphones = $this->getIphones();
    }

    public function render()
    {
        return view('livewire.settings.set-iphone');
    }
}
