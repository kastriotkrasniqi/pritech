<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class ProjectForm extends Form
{
    #[Validate(['required', 'string', 'max:255'])]
    public $name;
    #[Validate(['nullable', 'string'])]
    public $description;

    #[Validate( ['required','integer','exists:users,id'],as:'owner')]
    public $user_id;
    #[Validate(['date'])]
    public $start_date;
    #[Validate(['date', 'after_or_equal:start_date'])]
    public $deadline;
}
