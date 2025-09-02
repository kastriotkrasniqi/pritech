<?php

declare(strict_types=1);

namespace App\Livewire\Tags;

use App\Models\Tag;
use Flux\Flux;
use Livewire\Attributes\Validate;
use Livewire\Component;

final class CreateTag extends Component
{
    #[Validate(['required', 'string', 'max:255', 'unique:tags,name'])]
    public $name = '';

    #[Validate(['required', 'string', 'max:32'])]
    public $color = '';

    public function save(): void
    {
        $this->validate();

        Tag::create([
            'name' => $this->name,
            'color' => $this->color,
        ]);

        $this->reset();
        Flux::modal('create-tag')->close();
        $this->dispatch('tag-created');
        Flux::toast(variant: 'success', text: 'Tag created successfully!');
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.tags.create-tag');
    }
}
