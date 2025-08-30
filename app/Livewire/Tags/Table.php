<?php

declare(strict_types=1);

namespace App\Livewire\Tags;

use App\Models\Tag;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

final class Table extends Component
{
    use WithPagination;

    public $search = '';

    public $sortBy = 'created_at';

    public $sortDirection = 'desc';

    public $perPage = 10;

    public $showDeleteModal = false;

    public $selectedTagId;

    public function confirmDelete($id): void
    {
        $this->selectedTagId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteTag(): void
    {
        if ($this->selectedTagId) {
            Tag::find($this->selectedTagId)?->delete();
            $this->showDeleteModal = false;
            $this->selectedTagId = null;
            $this->dispatch('tag-deleted');
        }
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function sort($column): void
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
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.tags.table');
    }
}
