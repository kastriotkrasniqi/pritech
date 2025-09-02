<?php

declare(strict_types=1);

namespace App\Livewire\Issues;

use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\Livewire\Forms\IssueForm;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use Flux\Flux;
use Livewire\Component;

final class ShowIssue extends Component
{
    public IssueForm $form;

    public $issue;

    public $isEditing = false;

    public $searchTag = '';


    public function mount(Issue $issue): void
    {
        $this->issue = $issue;
        $this->form->setIssue($issue);
    }

    public function toggleEdit(): void
    {
        $this->isEditing = ! $this->isEditing;
        if ($this->isEditing) {
            $this->form->refreshFromModel();
        }
    }

    public function save(): void
    {
        $this->form->save();
        $this->issue->load(['tags', 'members']);
        $this->isEditing = false;
        Flux::toast(variant: 'success', text: 'Issue updated successfully!');
    }

    #[\Livewire\Attributes\Computed]
    public function tags()
    {
        return Tag::when($this->searchTag, fn ($q) => $q->where('name', 'like', "%{$this->searchTag}%"))->get();
    }

    #[\Livewire\Attributes\Computed]
    public function projects()
    {
        return Project::select('id', 'name')->get();
    }

    #[\Livewire\Attributes\Computed]
    public function users()
    {
        return \App\Models\User::select('id', 'name')->get();
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.issues.show-issue', [
            'statuses' => IssueStatus::all(),
            'priorities' => IssuePriority::all(),
        ]);
    }
}
