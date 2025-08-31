<?php

declare(strict_types=1);

namespace App\Livewire\Issues;

use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\Livewire\Forms\IssueForm;
use App\Models\Issue;
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
            'tags' => Tag::all(['id','name','color']),
            'members' => User::all(['id','name']),
            'statuses' => IssueStatus::all(),
            'priorities' => IssuePriority::all(),
        ]);
    }

    public function save(): void
    {
        $this->validate();

        $issue = Issue::create($this->form->forModel());

        $issue->tags()->sync($this->form->tags);
        $issue->members()->sync($this->form->members);

        $this->form->reset();

        Flux::modal('create-issue')->close();
        $this->dispatch('issue-created');
        Flux::toast(variant: 'success', text: 'Issue created successfully!');
    }

    #[\Livewire\Attributes\Computed]
    public function projects()
    {
        return Project::query()
            ->when($this->searchProject, fn ($query) => $query->where('name', 'like', '%'.$this->searchProject.'%'))
            ->limit(5)
            ->get();
    }
}
