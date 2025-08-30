<?php
namespace App\Livewire\Tags;

use App\Models\Tag;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;
    public $search = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;
    public $showDeleteModal = false;
    public $selectedTagId = null;
    public function confirmDelete($id)
    {
        $this->selectedTagId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteTag()
    {
        if ($this->selectedTagId) {
            Tag::find($this->selectedTagId)?->delete();
            $this->showDeleteModal = false;
            $this->selectedTagId = null;
            $this->dispatch('tag-deleted');
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    #[On('tag-created')]
    #[\Livewire\Attributes\Computed]
    public function tags()
    {
        return Tag::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.tags.table');
    }
}
