<?php

declare(strict_types=1);

namespace App\Livewire\Tags;

use App\Models\Tag;
use Flux\Flux;
use Livewire\Attributes\Validate;
use Livewire\Component;

final class EditTag extends Component
{
    public Tag $tag;

    #[Validate(['required', 'string', 'max:255'])]
    public $name = '';

    #[Validate(['required', 'string', 'max:32'])]
    public $color = '';

    public $isEditing = false;

    public function mount(Tag $tag): void
    {
        $this->tag = $tag;
        $this->fillFromTag();
    }

    public function fillFromTag(): void
    {
        $this->name = $this->tag->name;
        $this->color = $this->tag->color;
    }

    public function toggleEdit(): void
    {
        $this->isEditing = ! $this->isEditing;
        if ($this->isEditing) {
            $this->fillFromTag();
        }
    }

    public function save(): void
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:tags,name,'.$this->tag->id,
            'color' => 'required|string|max:32',
        ]);

        $this->tag->update([
            'name' => $this->name,
            'color' => $this->color,
        ]);

        $this->isEditing = false;
        Flux::toast(variant: 'success', text: 'Tag updated successfully!');
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.tags.edit-tag');
    }
}
