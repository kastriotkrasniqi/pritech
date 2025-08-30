<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 mb-4">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Comments</h3>
    <div class="space-y-4">
        @forelse($comments as $comment)
            <div class="p-3 sm:p-4 rounded-lg border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                <div class="flex flex-row items-start gap-3">
                    <flux:avatar src="{{ $comment->user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) }}" size="xs" class="shrink-0" />
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $comment->user->name }}</span>
                            @if($comment->user->is_moderator)
                                <flux:badge color="lime" size="sm" icon="check-badge" inset="top bottom">Moderator</flux:badge>
                            @endif
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="mt-2 text-gray-800 dark:text-gray-200">{{ $comment->body }}</div>
                        <div class="flex items-center gap-2 mt-2">
                            <flux:button wire:click="upvote({{ $comment->id }})" variant="ghost" size="sm">
                                <flux:icon.hand-thumb-up variant="outline" class="size-4 text-zinc-400" />
                                <span class="text-sm text-zinc-500">{{ $comment->upvotes }}</span>
                            </flux:button>
                            <flux:dropdown>
                                <flux:button icon="ellipsis-horizontal" variant="subtle" size="sm" />
                                <flux:menu>
                                    <flux:menu.item icon="pencil-square" wire:click="editComment({{ $comment->id }})">Edit</flux:menu.item>
                                    <flux:menu.item variant="danger" icon="trash" wire:click="deleteComment({{ $comment->id }})">Delete</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-gray-500 dark:text-gray-400">No comments yet. Be the first to comment!</div>
        @endforelse
        <div class="mt-6">
            <form wire:submit.prevent="addComment" class="flex flex-col gap-3">
                <flux:textarea wire:model.defer="newComment" rows="2" placeholder="Add a comment..." />
                <div class="flex justify-end">
                    <flux:button type="submit" size="sm">Post Comment</flux:button>
                </div>
            </form>
        </div>
    </div>
</div>
