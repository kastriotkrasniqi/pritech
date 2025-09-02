<?php

declare(strict_types=1);

namespace App\Livewire\Comments;

use App\Livewire\Forms\CommentForm;
use App\Models\Comment;
use App\Models\Issue;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

final class IssueComments extends Component
{
    use WithPagination;

    public Issue $issue;

    public CommentForm $form;

    public $editingCommentId;

    public $newComment = '';

    public function mount(Issue $issue): void
    {
        $this->issue = $issue;
    }

    /**
     * Fetch comments for the issue, with the user attached.
     */
    #[\Livewire\Attributes\Computed]
    public function comments()
    {
        return $this->issue->comments()
            ->with(['user', 'issue'])
            ->latest()
            ->paginate(4);
    }

    public function addComment(): void
    {
        $this->validate([
            'newComment' => 'required|string|max:1000',
        ]);

        $this->issue->comments()->create([
            'user_id' => auth()->id(),
            'body' => $this->newComment,
        ]);

        $this->reset('newComment');
        Flux::toast(variant: 'success', text: 'Comment added successfully!');
        $this->resetPage();
    }

    public function editComment($id): void
    {
        $comment = Comment::find($id);

        if ($comment && $comment->user_id === auth()->id()) {
            $this->form->setComment($comment);
            $this->editingCommentId = $id;
        }
    }

    public function updateComment(): void
    {
        $comment = Comment::find($this->editingCommentId);

        if ($comment && $comment->user_id === auth()->id()) {
            $this->form->comment = $comment;
            $this->form->save($this->issue->id);
            $this->reset(['editingCommentId']);
            $this->form->reset();
            Flux::toast(variant: 'success', text: 'Comment updated successfully!');
        }
    }

    public function cancelEditComment(): void
    {
        $this->reset(['editingCommentId']);
        $this->form->reset();
    }

    public function deleteComment($id): void
    {
        $comment = Comment::find($id);
        $projectOwnerId = $this->issue->project?->user_id;

        if ($comment && (auth()->id() === $comment->user_id || auth()->id() === $projectOwnerId)) {
            $comment->delete();
            Flux::toast(variant: 'danger', text: 'Comment deleted successfully!');
        }
    }

    public function toggleLike($commentId): void
    {
        $comment = Comment::find($commentId);
        $user = auth()->user();

        if ($comment && $user) {
            if ($comment->liked($user)) {
                $comment->unlike($user);
            } else {
                $comment->like($user);
            }
        }
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.comments.issue-comments', [
            'comments' => $this->comments,
        ]);
    }
}
