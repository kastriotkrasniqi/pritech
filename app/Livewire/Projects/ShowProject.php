<?php

namespace App\Livewire\Projects;

use App\Livewire\Forms\ProjectForm;
use App\Models\Project;
use Flux\Flux;
use Livewire\Component;
use Livewire\Attributes\On;

class ShowProject extends Component
{
    public Project $project;
    public ProjectForm $form;
    public $isEditing = false;
    public $searchOwner = '';
    public $showDeleteModal = false;

    public function mount()
    {
        $id = request()->route('id');
        $this->project = Project::with('owner')->findOrFail($id);
        $this->loadFormData();
    }

    public function loadFormData()
    {
        $this->form->name = $this->project->name;
        $this->form->description = $this->project->description;
        $this->form->user_id = $this->project->user_id;
        $this->form->start_date = $this->project->start_date;
        $this->form->deadline = $this->project->deadline;
    }

    public function toggleEdit()
    {
        $this->isEditing = !$this->isEditing;
        if ($this->isEditing) {
            $this->loadFormData();
        }
    }

    public function save()
    {
        $this->validate();
        
        // Additional validation for deadline
        if ($this->form->start_date && $this->form->deadline && $this->form->deadline < $this->form->start_date) {
            Flux::toast(variant: 'danger', text: 'Deadline cannot be before start date!');
            return;
        }
        
        $this->project->update($this->form->all());
        $this->project->refresh();
        
        $this->isEditing = false;
        Flux::toast(variant: 'success', text: 'Project updated successfully!');
    }

    public function cancel()
    {
        $this->isEditing = false;
        $this->loadFormData();
    }

    public function canEdit()
    {
        return auth()->id() === $this->project->user_id;
    }

    public function canDelete()
    {
        return auth()->id() === $this->project->user_id;
    }

    public function isOverdue()
    {
        return $this->project->deadline && $this->project->deadline->isPast();
    }

    public function getStatusColor()
    {
        if (!$this->project->deadline) {
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

    public function confirmDelete()
    {
        $this->showDeleteModal = true;
    }

    public function deleteProject()
    {
        if ($this->canDelete()) {
            $this->project->delete();
            Flux::toast(variant: 'success', text: 'Project deleted successfully!');
            return redirect()->route('projects.index');
        }
    }

    public function render()
    {
        return view('livewire.projects.show-project');
    }

    #[\Livewire\Attributes\Computed]
    public function users()
    {
        return \App\Models\User::query()
            ->when($this->searchOwner, fn($query) => $query->where('name', 'like', '%' . $this->searchOwner . '%'))
            ->limit(5)
            ->get();
    }
}
