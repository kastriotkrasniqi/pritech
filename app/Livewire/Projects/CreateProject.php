<?php

namespace App\Livewire\Projects;

use App\Livewire\Forms\ProjectForm;
use App\Models\Project;
use Flux\Flux;
use Livewire\Component;
use Devrabiul\ToastMagic\Facades\ToastMagic;


class CreateProject extends Component
{
    public ProjectForm $form;
    public $searchOwner = '';
    public function render()
    {
        return view('livewire.projects.create-project');
    }

    public function save()
    {
        $this->validate();
        Project::create($this->form->all());
        $this->reset();
        Flux::modal('create-project')->close();
        $this->dispatch('project-created');
        Flux::toast(variant: 'success', text: 'Project created successfully!', );

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
