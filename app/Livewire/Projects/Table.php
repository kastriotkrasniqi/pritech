<?php

declare(strict_types=1);

namespace App\Livewire\Projects;

use App\Models\Project;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

final class Table extends Component
{
    use WithPagination;

    public $sortBy = 'created_at';

    public $sortDirection = 'desc';

    public $perPage = 5;

    public $search = '';

    public $showDeleteModal = false;

    public $selectedProject;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {

        return view('livewire.projects.table');
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

    #[On('project-created')]

    #[\Livewire\Attributes\Computed]
    public function projects()
    {

        return Project::query()
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->when($this->search, function ($query): void {
                $query->where(function ($q): void {
                    $q->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%');
                });
            })
            ->paginate($this->perPage);
    }

    public function confirmDelete($id): void
    {
        $this->selectedProject = Project::find($id);
        $this->showDeleteModal = true;
    }

    public function deleteProject(): void
    {
        if ($this->selectedProject) {
            $this->selectedProject->delete();
            $this->showDeleteModal = false;
            $this->selectedProject = null;
            Flux::toast(variant: 'danger', text: 'Project deleted successfully!');
        }
    }
}
