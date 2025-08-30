<?php

declare(strict_types=1);

namespace App\Livewire\Tags;

use App\Models\Tag;
use Flux\Flux;
use Livewire\Component;

final class CreateTag extends Component
{
    public $name = '';

    public $color = '';

    public function save(): void
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:tags,name',
            'color' => 'required|string|max:32',
        ]);
        Tag::create([
            'name' => $this->name,
            'color' => $this->color,
        ]);
        $this->reset(['name', 'color']);
        Flux::modal('create-tag')->close();
        $this->dispatch('tag-created');
        Flux::toast(variant: 'success', text: 'Tag created successfully!');
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.tags.create-tag');
    }
}
