<?php
namespace App\Livewire\Forms;

use App\Models\Issue;
use Livewire\Form;

class IssueForm extends Form
{
    public ?Issue $issue = null;
    public $title = '';
    public $description = '';
    public $status = '';
    public $priority = '';
    public $due_date = null;
    public $project_id = null;
    public $tags = [];

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
