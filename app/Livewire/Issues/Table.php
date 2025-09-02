<?php

declare(strict_types=1);

namespace App\Livewire\Issues;

use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\Models\Issue;
use App\Models\Tag;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

final class Table extends Component
{
    use WithPagination;

    public $sortBy = 'created_at';

    public $sortDirection = 'desc';

    public $perPage = 10;

    public $search = '';

    public $filterStatus = '';

    public $filterPriority = '';

    public $filterTag = '';

    public $showDeleteModal = false;

    public $selectedIssue;

    public function updated($propertyName): void
    {
        if (in_array($propertyName, ['search', 'filterStatus', 'filterPriority', 'filterTag'])) {
            $this->resetPage();
        }
    }

    public function updatedPerPage(): void
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

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.issues.table', [
            'statuses' => IssueStatus::all(),
            'priorities' => IssuePriority::all(),
            'tags' => Tag::all(),
            'perPageOptions' => [5, 10, 25, 50, 100],
        ]);
    }

    #[On('issue-created')]
    #[\Livewire\Attributes\Computed]
    public function issues()
    {
        return Issue::query()
            ->when($this->search, function ($query): void {
                $query->where(function ($q): void {
                    $q->where('title', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->filterStatus, fn ($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterPriority, fn ($q) => $q->where('priority', $this->filterPriority))
            ->when($this->filterTag, fn ($q) => $q->whereHas('tags', fn ($t) => $t->where('tags.id', $this->filterTag)))
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function confirmDelete($id): void
    {
        $this->selectedIssue = Issue::find($id);
        $this->showDeleteModal = true;
    }

    public function deleteIssue(): void
    {
        if ($this->selectedIssue) {
            $this->selectedIssue->delete();
            $this->showDeleteModal = false;
            $this->selectedIssue = null;
            Flux::toast(variant: 'danger', text: 'Issue deleted successfully!');
        }
    }
}
