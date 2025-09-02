<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Models\Comment;
use Livewire\Attributes\Validate;
use Livewire\Form;

final class CommentForm extends Form
{
    public ?Comment $comment = null;

    #[Validate(['required', 'string', 'max:1000'])]
    public $body = '';

    public function forModel(): array
    {
        return $this->only(['body']);
    }

    public function setComment(?Comment $comment): void
    {
        $this->comment = $comment;
        $this->refreshFromModel();
    }

    public function save(int $issueId): Comment
    {
        $this->validate();

        if ($this->comment) {
            $this->comment->update($this->forModel());
            return $this->comment;
        }

        return Comment::create([
            'issue_id' => $issueId,
            'user_id' => auth()->id(),
            'body' => $this->body,
        ]);
    }

    public function refreshFromModel(): void
    {
        if ($this->comment) {
            $this->fill($this->comment->toArray());
        } else {
            $this->reset();
        }
    }
}
