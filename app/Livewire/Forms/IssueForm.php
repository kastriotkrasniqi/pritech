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

    public $tags = [];

    public function setIssue(?Issue $issue): void
    {
        $this->issue = $issue;
        $this->tags = $issue instanceof \App\Models\Issue ? $issue->tags->pluck('id')->map(fn ($id): int => (int) $id)->toArray() : [];
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
        ];
    }
}
