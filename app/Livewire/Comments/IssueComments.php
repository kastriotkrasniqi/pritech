<?php

namespace App\Livewire\Comments;

use App\Models\Issue;
use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;
use Flux\Flux;
use Cog\Laravel\Love\Reacterable\Models\Traits\Reacterable;
use Cog\Laravel\Love\ReactionType\Models\ReactionType;

class IssueComments extends Component
{
    use WithPagination;

    public Issue $issue;
    public $newComment = '';
    public $editingCommentId = null;
    public $editingCommentBody = '';

    public function mount(Issue $issue)
    {
        $this->issue = $issue;
    }

    /**
     * Fetch comments for the issue, with the user attached.
     */
    #[\Livewire\Attributes\Computed]
    public function comments()
    {
        return $this->issue->comments()->with('user')->latest()->paginate(4);
    }

    public function addComment()
    {
        $this->validate([
            'newComment' => 'required|string|max:1000',
        ]);

        $this->issue->comments()->create([
            'user_id'     => auth()->id(),
            'body'        => $this->newComment,
            'author_name' => auth()->user()->name,
        ]);

        $this->reset('newComment');
        Flux::toast(variant: 'success', text: 'Comment added successfully!');
        $this->resetPage();
    }

    public function editComment($id)
    {
        $comment = Comment::find($id);
        if ($comment && $comment->user_id === auth()->id()) {
            $this->editingCommentId   = $id;
            $this->editingCommentBody = $comment->body;
        }
    }

    public function updateComment()
    {
        $this->validate([
            'editingCommentBody' => 'required|string|max:1000',
        ]);

        $comment = Comment::find($this->editingCommentId);

        if ($comment && $comment->user_id === auth()->id()) {
            $comment->update([
                'body' => $this->editingCommentBody,
            ]);
            $this->reset(['editingCommentId', 'editingCommentBody']);
            Flux::toast(variant: 'success', text: 'Comment updated successfully!');
        }
    }

    public function cancelEditComment()
    {
        $this->reset(['editingCommentId', 'editingCommentBody']);
    }

    public function deleteComment($id)
    {
        $comment = Comment::find($id);
        $projectOwnerId = $this->issue->project?->owner_id;

        if ($comment && (auth()->id() === $comment->user_id || auth()->id() === $projectOwnerId)) {
            $comment->delete();
            Flux::toast(variant: 'danger', text: 'Comment deleted successfully!');
            $this->resetPage();
        }
    }

    public function toggleLike($commentId)
    {
        $comment = $this->comments->firstWhere('id', $commentId);
        $user = auth()->user();
        if ($comment && $user) {
            if ($comment->liked($user)) {
                $comment->unlike($user);
            } else {
                $comment->like($user);
            }
            $this->dispatch('$refresh');
        }
    }

    public function render()
    {
        return view('livewire.comments.issue-comments', [
            'comments' => $this->comments,
        ]);
    }
}
