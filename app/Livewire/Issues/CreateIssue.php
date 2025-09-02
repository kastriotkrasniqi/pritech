<?php

declare(strict_types=1);

namespace App\Livewire\Issues;

use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\Livewire\Forms\IssueForm;
use App\Models\Project;
use App\Models\Tag;
use App\Models\User;
use Flux\Flux;
use Livewire\Component;

final class CreateIssue extends Component
{
    public IssueForm $form;

    public $searchProject = '';

    public function render()
    {
        return view('livewire.issues.create-issue', [
            'statuses' => IssueStatus::all(),
            'priorities' => IssuePriority::all(),
        ]);
    }

    public function save(): void
    {
        $issue = $this->form->save();

        Flux::modal('create-issue')->close();
        $this->dispatch('issue-created');
        Flux::toast(variant: 'success', text: 'Issue created successfully!');
    }

    #[\Livewire\Attributes\Computed]
    public function projects()
    {
        return Project::when($this->searchProject, fn ($q) => $q->where('name', 'like', "%{$this->searchProject}%"))->limit(5)->get();
    }

    #[\Livewire\Attributes\Computed]
    public function tags()
    {
        return Tag::select('id', 'name', 'color')->get();
    }

    #[\Livewire\Attributes\Computed]
    public function users()
    {
        return User::select('id', 'name')->get();
    }
}
