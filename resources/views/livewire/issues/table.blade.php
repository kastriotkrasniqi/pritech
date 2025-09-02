<div>
      <flux:modal.trigger name="create-issue">
        <flux:button size="sm" class="mb-4" icon="plus">Create Issue
        </flux:button>
    </flux:modal.trigger>
    <div class="px-4 rounded-2xl border dark:border-neutral-700 py-4">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-4">
            <flux:input size="sm" wire:model.live.debounce.300ms="search" class="w-full sm:w-64"
                placeholder="Search issues..." />
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-4">
                <flux:select size="sm" wire:model.live="filterStatus" class="w-full sm:w-32" placeholder="Status">
                    <flux:select.option value="">All Statuses</flux:select.option>
                    @foreach($statuses as $status)
                    <flux:select.option value="{{ $status }}">{{ ucfirst(str_replace('_', ' ', $status)) }}
                    </flux:select.option>
                    @endforeach
                </flux:select>
                <flux:select size="sm" wire:model.live="filterPriority" class="w-full sm:w-32" placeholder="Priority">
                    <flux:select.option value="">All Priorities</flux:select.option>
                    @foreach($priorities as $priority)
                    <flux:select.option value="{{ $priority }}">{{ ucfirst($priority) }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:select size="sm" wire:model.live="filterTag" class="w-full sm:w-32" placeholder="Tag">
                    <flux:select.option value="">All Tags</flux:select.option>
                    @foreach($tags as $tag)
                    <flux:select.option value="{{ $tag->id }}">{{ $tag->name }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:select size="sm" wire:model.live="perPage" class="w-full sm:w-24" placeholder="Per Page">
                    @foreach($perPageOptions as $option)
                    <flux:select.option value="{{ $option }}">{{ $option }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
        </div>
        <flux:table :paginate="$this->issues">
            <flux:table.columns>
                <flux:table.column sortable :sorted="$sortBy === 'title'" :direction="$sortDirection"
                    wire:click="sort('title')">Title</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column>Priority</flux:table.column>
                <flux:table.column>Tags</flux:table.column>
                <flux:table.column>Due Date</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach ($this->issues as $issue)
                <flux:table.row :key="$issue->id" class="even:bg-gray-50 dark:even:bg-gray-700/30">
                    <flux:table.cell><a href="{{ route('issues.show', $issue->id) }}" wire:navigate class="font-medium hover:underline">{{ $issue->title }}</a></flux:table.cell>
                    <flux:table.cell>
                        <flux:badge size="sm"
                            color="{{ $issue->status === 'open' ? 'green' : ($issue->status === 'in_progress' ? 'yellow' : 'gray') }}">
                            {{ ucfirst(str_replace('_', ' ', $issue->status)) }}
                        </flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:badge size="sm"
                            color="{{ $issue->priority === 'high' ? 'red' : ($issue->priority === 'medium' ? 'yellow' : 'green') }}">
                            {{ ucfirst($issue->priority) }}
                        </flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        @foreach($issue->tags as $tag)
                        <flux:badge size="xxs"
                            :style="'background-color: ' . $tag->color . '; color: #fff; font-size: 0.65rem; padding: 0.1rem 0.3rem;'">
                            {{ $tag->name }}</flux:badge>
                        @endforeach
                    </flux:table.cell>
                    <flux:table.cell>{{ $issue->due_date ?? '-' }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:dropdown position="bottom" align="end" offset="-15">
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom">
                            </flux:button>
                            <flux:menu>
                                <flux:menu.item icon="document-text" :href="route('issues.show', $issue->id)" wire:navigate>View</flux:menu.item>
                                <flux:menu.item icon="archive-box" variant="danger"
                                    wire:click="confirmDelete({{ $issue->id }})">Delete</flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>

    <livewire:issues.create-issue />

        <flux:modal wire:model.live="showDeleteModal" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete issue?</flux:heading>
                <flux:text class="mt-2">
                    <p>You're about to delete this issue.</p>
                    <p>This action cannot be reversed.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button wire:click="deleteIssue" variant="danger">Delete issue</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
