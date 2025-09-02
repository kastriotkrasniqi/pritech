<?php

declare(strict_types=1);

namespace App\Livewire\Projects;

use App\Livewire\Forms\ProjectForm;
use App\Models\Project;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

final class ShowProject extends Component
{
    use WithPagination;

    public Project $project;

    public ProjectForm $form;

    public $isEditing = false;

    public $searchOwner = '';

    public $showDeleteModal = false;


    public function mount(): void
    {
        $id = request()->route('id');
        $this->project = Project::with('owner')->findOrFail($id);
        $this->loadFormData();
    }

    public function loadFormData(): void
    {
        $this->form->name = $this->project->name;
        $this->form->description = $this->project->description;
        $this->form->user_id = $this->project->user_id;
        $this->form->start_date = $this->project->start_date;
        $this->form->deadline = $this->project->deadline;
    }

    public function toggleEdit(): void
    {
        $this->isEditing = ! $this->isEditing;
        if ($this->isEditing) {
            $this->loadFormData();
        }
    }

    public function save(): void
    {
        $this->validate();

        $this->project->update($this->form->all());
        $this->project->load('owner');
        $this->isEditing = false;
        Flux::toast(variant: 'success', text: 'Project updated successfully!');
    }

    public function cancel(): void
    {
        $this->isEditing = false;
        $this->loadFormData();
    }


    public function isOverdue(): bool
    {
        return $this->project->deadline && $this->project->deadline->isPast();
    }

    public function getStatusColor(): string
    {
        if (! $this->project->deadline) {
            return 'gray';
        }
        if ($this->isOverdue()) {
            return 'red';
        }
        if ($this->project->deadline->diffInDays(now()) <= 7) {
            return 'yellow';
        }

        return 'green';
    }

    public function confirmDelete(): void
    {
        $this->showDeleteModal = true;
    }

    public function deleteProject()
    {
            $this->authorize('delete', $this->project);
            $this->project->delete();
            Flux::toast(variant: 'success', text: 'Project deleted successfully!');

            return redirect()->route('projects.index');
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.projects.show-project');
    }

    #[\Livewire\Attributes\Computed]
    public function users()
    {
        return \App\Models\User::query()
            ->when($this->searchOwner, fn ($query) => $query->where('name', 'like', '%'.$this->searchOwner.'%'))
            ->limit(5)
            ->get();
    }

    #[\Livewire\Attributes\Computed]
    public function issues()
    {
        return $this->project->issues()
            ->with(['tags', 'members'])
            ->orderByDesc('created_at')
            ->paginate(5);
    }
}
