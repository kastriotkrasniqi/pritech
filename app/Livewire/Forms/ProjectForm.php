<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Models\Project;
use Livewire\Attributes\Validate;
use Livewire\Form;

final class ProjectForm extends Form
{
    public ?Project $project = null;

    #[Validate(['required', 'string', 'max:255'])]
    public $name;

    #[Validate(['nullable', 'string'])]
    public $description;

    #[Validate(['required', 'integer', 'exists:users,id'], as: 'owner')]
    public $user_id;

    #[Validate(['date'])]
    public $start_date;

    #[Validate(['date', 'after_or_equal:start_date'])]
    public $deadline;

    public function save(): Project
    {
        $this->validate();

        if ($this->project) {
            $this->project->update($this->all());
        } else {
            $this->project = Project::create($this->all());
        }

        return $this->project;
    }

}
