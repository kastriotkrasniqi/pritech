<?php

declare(strict_types=1);

namespace App\Livewire\Issues;

use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\Livewire\Forms\IssueForm;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use Livewire\Component;

final class ShowIssue extends Component
{
    public IssueForm $form;

    public $issue;

    public $isEditing = false;

    public $searchTag = '';

    public $searchProject = '';

    public function mount(Issue $issue): void
    {
        $this->issue = $issue;
        $this->form->fill($issue->toArray());
        $this->form->tags = $issue->tags->pluck('id')->map(fn ($id): int => (int) $id)->toArray();
        $this->form->project_id = $issue->project_id;
    }

    public function toggleEdit(): void
    {
        $this->isEditing = ! $this->isEditing;
        if ($this->isEditing) {
            $this->form->fill($this->issue->toArray());
        }
    }

    public function save(): void
    {
        $this->validate();
        $this->issue->update($this->form->all());
        $this->issue->tags()->sync($this->form->tags);
        $this->isEditing = false;
        $this->form->fill($this->issue->fresh()->toArray());
    }

    #[\Livewire\Attributes\Computed]
    public function tags()
    {
        return Tag::query()
            ->when($this->searchTag, fn ($query) => $query->where('name', 'like', '%'.$this->searchTag.'%'))
            ->get();
    }

    #[\Livewire\Attributes\Computed]
    public function projects()
    {
        return Project::query()
            ->when($this->searchProject, fn ($query) => $query->where('name', 'like', '%'.$this->searchProject.'%'))
            ->limit(5)
            ->get();
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.issues.show-issue', [
            'statuses' => IssueStatus::all(),
            'priorities' => IssuePriority::all(),
        ]);
    }
}
