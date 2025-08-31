<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 mb-4">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Comments</h3>
    <div class="space-y-4">
        @forelse($comments as $comment)
            <div class="p-2 sm:p-3 rounded-lg border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-xs">
                <div class="flex flex-row items-start gap-2">
                    <flux:avatar
                        src="{{ $comment->user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) }}"
                        size="xs"
                        class="shrink-0"
                    />
                    <div class="flex-1">
                        <div class="flex items-center gap-1">
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $comment->user->name }}</span>

                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>

                        {{-- ✅ Edit mode --}}
                        @if($editingCommentId === $comment->id)
                            <div class="mt-2">
                                <flux:textarea wire:model.defer="editingCommentBody" rows="2" />
                                <div class="flex gap-2 mt-2">
                                    <flux:button size="xs" wire:click="updateComment">Save</flux:button>
                                    <flux:button size="xs" variant="subtle" wire:click="cancelEditComment">Cancel</flux:button>
                                </div>
                            </div>
                        @else
                            {{-- Normal view --}}
                            <div class="mt-1 text-gray-800 dark:text-gray-200">{{ $comment->body }}</div>
                        @endif

                        <div class="flex items-center gap-1 mt-1">
                            @php
                                $liked = auth()->check() && $comment->liked(auth()->user());
                                $canEditDelete = auth()->check() && (auth()->id() === $comment->user_id || auth()->id() === ($comment->issue->project->owner_id ?? null));
                            @endphp
                            <flux:button wire:click="toggleLike({{ $comment->id }})" variant="ghost" size="xs">
                                <div class="flex items-center gap-1">
                                    <flux:icon.hand-thumb-up variant="outline" class="size-4 {{ $liked ? 'text-blue-500' : 'text-zinc-400' }}" />
                                    <span class="text-xs text-zinc-500">{{ $comment->likeCount }}</span>
                                </div>
                            </flux:button>
                            @if($canEditDelete)
                            <flux:dropdown>
                                <flux:button icon="ellipsis-horizontal" variant="subtle" size="xs" />
                                <flux:menu>

                                        <flux:menu.item icon="pencil-square" wire:click="editComment({{ $comment->id }})">Edit</flux:menu.item>
                                        <flux:menu.item variant="danger" icon="trash" wire:click="deleteComment({{ $comment->id }})">Delete</flux:menu.item>

                                </flux:menu>
                            </flux:dropdown>
                             @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-gray-500 dark:text-gray-400 text-xs">No comments yet. Be the first to comment!</div>
        @endforelse

        <div class="mt-4">
            <flux:pagination :paginator="$comments" />
        </div>

        <div class="mt-6">
            <form wire:submit.prevent="addComment" class="flex flex-col gap-3">
                <flux:field>
                    <flux:textarea wire:model.defer="newComment" rows="2" placeholder="Add a comment..." />
                      <flux:error name="newComment" />
                </flux:field>
                <div class="flex justify-end">
                    <flux:button type="submit" size="sm">Post Comment</flux:button>
                </div>
            </form>
        </div>
    </div>
</div>
