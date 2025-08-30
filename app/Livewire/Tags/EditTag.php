<?php
namespace App\Livewire\Tags;

use App\Models\Tag;
use Flux\Flux;
use Livewire\Component;

class EditTag extends Component
{
    public Tag $tag;
    public $name = '';
    public $color = '';
    public $isEditing = false;

    public function mount(Tag $tag)
    {
        $this->tag = $tag;
        $this->name = $tag->name;
        $this->color = $tag->color;
        $this->isEditing = false;
    }

    public function toggleEdit()
    {
        $this->isEditing = !$this->isEditing;
        if ($this->isEditing) {
            $this->name = $this->tag->name;
            $this->color = $this->tag->color;
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $this->tag->id,
            'color' => 'required|string|max:32',
        ]);
        $this->tag->update([
            'name' => $this->name,
            'color' => $this->color,
        ]);
        $this->isEditing = false;
        Flux::toast(variant: 'success', text: 'Tag updated successfully!');
    }

    public function render()
    {
        return view('livewire.tags.edit-tag');
    }
}
