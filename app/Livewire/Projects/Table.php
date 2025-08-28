<?php

namespace App\Livewire\Projects;

use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;
    public $sortBy = 'name';
    public $sortDirection = 'desc';
    public $perPage = 5;

    public $search = '';
    public function render()
    {
        return view('livewire.projects.table');
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

    #[\Livewire\Attributes\Computed]
    public function users()
    {
        return \App\Models\User::query()
            ->tap(fn($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->when($this->search, fn($query) => $query->where('name', 'like', '%' . $this->search . '%'))->orWhere('email', 'like', '%' . $this->search . '%')
            ->paginate($this->perPage);
    }


}
