<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Models\Issue;
use Livewire\Form;

final class IssueForm extends Form
{
    public ?Issue $issue = null;

    public $title = '';
    public $description = '';
    public $status = '';
    public $priority = '';
    public $due_date;
    public $project_id;

    // relationships
    public $tags = [];
    public $members = [];

    public function modelAttributes(): array
    {
        return [
            'project_id',
            'title',
            'description',
            'status',
            'priority',
            'due_date',
        ];
    }


    public function forModel(): array
    {
        return $this->only($this->modelAttributes());
    }

    public function setIssue(?Issue $issue): void
    {
        $this->issue = $issue;

        if ($issue instanceof Issue) {
            $this->tags = $issue->tags->pluck('id')->map(fn ($id): int => (int) $id)->toArray();
            $this->members = $issue->members->pluck('id')->map(fn ($id): int => (int) $id)->toArray();
        }
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string'],
            'priority' => ['required', 'string'],
            'due_date' => ['nullable', 'date'],
            'project_id' => ['required', 'exists:projects,id'],
            'tags' => ['array'],
            'tags.*' => ['exists:tags,id'],
            'members' => ['array'],
            'members.*' => ['exists:users,id'],
        ];
    }
}
