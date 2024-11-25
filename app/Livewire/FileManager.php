<?php

namespace App\Livewire;

use App\Models\Berita;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class FileManager extends Component
{
    use WithPagination;

    public $search = '';

    #[On('refreshItem')]
    public function refreshItem()
    {
        $this->search = '';
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $search = $this->search;
        return view('livewire.file-manager', [
            'items' => Berita::select(['id_berita', 'judul', 'gambar_detail'])
                        // ->where('id_network', auth()->user()->id_network)
                        ->where(function ($query) use ($search) {
                            $query->where('judul', 'like', '%' . $search . '%');
                        })
                        ->orderBy('created_at', 'desc')
                        ->paginate(12),
        ]);
    }
}
