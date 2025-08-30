<?php
namespace App\Livewire\Issues;

use App\Livewire\Forms\IssueForm;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use App\Enums\IssueStatus;
use App\Enums\IssuePriority;
use Livewire\Component;

class ShowIssue extends Component
{

    public IssueForm $form;
    public $issue;
    public $isEditing = false;
    public $searchTag = '';
    public $searchProject = '';

    public function mount(Issue $issue)
    {
        $this->issue = $issue;
        $this->form->fill($issue->toArray());
    }

    public function toggleEdit()
    {
        $this->isEditing = !$this->isEditing;
        if ($this->isEditing) {
            $this->form->fill($this->issue->toArray());
        }
    }

    public function save()
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
            ->when($this->searchTag, fn($query) => $query->where('name', 'like', '%' . $this->searchTag . '%'))
            ->get();
    }

    #[\Livewire\Attributes\Computed]
    public function projects()
    {
        return Project::query()
            ->when($this->searchProject, fn($query) => $query->where('name', 'like', '%' . $this->searchProject . '%'))
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.issues.show-issue', [
            'statuses' => \App\Enums\IssueStatus::all(),
            'priorities' => \App\Enums\IssuePriority::all(),
        ]);
    }
}
