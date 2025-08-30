<?php
namespace App\Livewire\Issues;

use App\Models\Issue;
use App\Models\Tag;
use App\Models\Project;
use App\Enums\IssueStatus;
use App\Enums\IssuePriority;
use Flux\Flux;
use Livewire\Component;

class CreateIssue extends Component
{
    public \App\Livewire\Forms\IssueForm $form;
    public $searchProject = '';

    public function render()
    {
        return view('livewire.issues.create-issue', [
            'tags' => Tag::all(),
            'statuses' => IssueStatus::all(),
            'priorities' => IssuePriority::all(),
        ]);
    }

    public function save()
    {
        $this->validate();
        $issue = Issue::create($this->form->all());
        $issue->tags()->sync($this->form->tags);
        $this->form->reset();
        Flux::modal('create-issue')->close();
        $this->dispatch('issue-created');
        Flux::toast(variant: 'success', text: 'Issue created successfully!', );
    }

    #[\Livewire\Attributes\Computed]
    public function projects()
    {
        return Project::query()
            ->when($this->searchProject, fn($query) => $query->where('name', 'like', '%' . $this->searchProject . '%'))
            ->limit(5)
            ->get();
    }
}
