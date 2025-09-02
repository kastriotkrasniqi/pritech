<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Models\Issue;
use Livewire\Attributes\Validate;
use Livewire\Form;

final class IssueForm extends Form
{
    public ?Issue $issue = null;

    #[Validate(['required', 'string', 'max:255'])]
    public $title = '';

    #[Validate(['nullable', 'string'])]
    public $description = '';

    #[Validate(['required', 'string'])]
    public $status = '';

    #[Validate(['required', 'string'])]
    public $priority = '';

    #[Validate(['nullable', 'date'])]
    public $due_date;

    #[Validate(['required', 'exists:projects,id'])]
    public $project_id;

    // relationships
    #[Validate(['array'])]
    #[Validate(['exists:tags,id'], 'tags.*')]
    public $tags = [];

    #[Validate(['array'])]
    #[Validate(['exists:users,id'], 'members.*')]
    public $members = [];

    public function forModel(): array
    {
        return $this->only([
            'project_id',
            'title',
            'description',
            'status',
            'priority',
            'due_date',
        ]);
    }

    public function setIssue(?Issue $issue): void
    {
        $this->issue = $issue;
        $this->refreshFromModel();
    }

    public function loadRelationships(): void
    {
        if ($this->issue) {
            $this->tags = $this->issue->tags()->pluck('tags.id')->toArray();
            $this->members = $this->issue->members()->pluck('users.id')->toArray();
        }
    }

    public function syncRelationships(): void
    {
        if ($this->issue) {
            $this->issue->tags()->sync($this->tags);
            $this->issue->members()->sync($this->members);
        }
    }

    public function save(): Issue
    {
        $this->validate();

        $this->issue
            ? $this->issue->update($this->forModel())
            : $this->issue = Issue::create($this->forModel());

        $this->syncRelationships();

        return $this->issue;
    }

    public function refreshFromModel(): void
    {
        if ($this->issue) {
            $this->fill($this->issue->toArray());
            $this->loadRelationships();
        } else {
            $this->reset();
        }
    }
}
