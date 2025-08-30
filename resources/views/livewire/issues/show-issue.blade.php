<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4" aria-label="Breadcrumb">
        <div class="flex items-center justify-between">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('issues.index') }}" wire:navigate
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">
                        <flux:icon.bug-ant variant="mini" class="mr-2" />
                        Issues
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <flux:icon.chevron-right variant="mini" class="mx-2 text-gray-400" />
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $issue->title }}</span>
                    </div>
                </li>
            </ol>
            <div class="flex items-center gap-3">
                <flux:button wire:click="toggleEdit" variant="outline" size="sm">
                    @if($isEditing)
                    Cancel Edit
                    @else
                    Edit Issue
                    @endif
                </flux:button>
                <flux:button variant="ghost" href="{{ route('issues.index') }}" wire:navigate size="sm">
                    <flux:icon.arrow-left variant="mini" class="mr-2" />
                    Back to Issues
                </flux:button>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 mb-4">
        <div class="flex items-center gap-4 mb-4">
            @if($isEditing)
            <flux:field class="flex-1">
                <flux:input wire:model="form.title" label="Issue Title"
                    class="text-2xl font-bold text-gray-900 dark:text-white" />
            </flux:field>

            @else
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $issue->title }}</h1>
            @endif

        </div>
        @if($isEditing)
        <flux:field class="mb-4">
            <flux:textarea wire:model="form.description" rows="3" label="Description" />
        </flux:field>
        @else
        <p class="text-base text-gray-600 dark:text-gray-400 mb-4">
            {{ $issue->description ?: 'No description provided for this issue.' }}
        </p>
        @endif
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 mb-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($isEditing)
                <flux:field>
                    <flux:select wire:model="form.status" label="Status" variant="listbox" placeholder="Select status...">
                        @foreach($statuses as $status)
                            <flux:select.option value="{{ $status }}">{{ ucfirst(str_replace('_', ' ', $status)) }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </flux:field>
                <flux:field>
                    <flux:select wire:model="form.priority" label="Priority" variant="listbox" placeholder="Select priority...">
                        @foreach($priorities as $priority)
                            <flux:select.option value="{{ $priority }}">{{ ucfirst($priority) }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </flux:field>
                @else
                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg
                    >
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Status</p>
                    <p class="text-gray-900 dark:text-white font-medium">
                        {{ ucfirst(str_replace('_', ' ', $issue->status)) }}
                    </p>
                </div>
                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Priority</p>
                    <p class="text-gray-900 dark:text-white font-medium">
                        {{ ucfirst($issue->priority) }}
                    </p>
                </div>
                @endif
            </div>
        </div>

    <!-- Issue Details -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 mb-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if($isEditing)

            <flux:field>
                <flux:select wire:model="form.project_id" variant="combobox" :filter="false" label="Project"
                    placeholder="Select project...">
                    <x-slot name="input">
                        <flux:select.input wire:model.live="searchProject" />
                    </x-slot>
                    @foreach ($this->projects as $project)
                    <flux:select.option value="{{ $project->id }}" wire:key="{{ $project->id }}">
                        {{ $project->name }}
                    </flux:select.option>
                    @endforeach
                </flux:select>
            </flux:field>
            <flux:field>
                <flux:date-picker wire:model="form.due_date" label="Due Date" />
            </flux:field>
            @else
            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Project</p>
                <p class="text-gray-900 dark:text-white font-medium">
                    {{ $issue->project?->name ?? 'Not set' }}
                </p>
            </div>
            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Due Date</p>
                <p class="text-gray-900 dark:text-white font-medium">
                    {{ $issue->due_date ?? 'Not set' }}
                </p>
            </div>
            @endif
        </div>
    </div>

    <!-- Tags -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 mb-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tags</h3>

        </div>
        @if($isEditing)
        <flux:field>
            <flux:select wire:model="form.tags" label="Tags" variant="listbox" placeholder="Select tags..." searchable multiple>
                @foreach($this->tags as $tag)
                    <flux:select.option value="{{ $tag->id }}">{{ $tag->name }}</flux:select.option>
                @endforeach
            </flux:select>
        </flux:field>
        @else
        <div class="flex flex-wrap gap-2">
            @foreach($issue->tags as $tag)
            <flux:badge size="xs" :style="'background-color: ' . $tag->color . '; color: #fff;'">{{ $tag->name }}
            </flux:badge>
            @endforeach
        </div>
        @endif
    </div>
    <!-- Actions -->
    @if($isEditing)
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Actions</h3>
        <div class="flex gap-3">
            <flux:button wire:click="save" class="flex-1">Save Changes</flux:button>
            <flux:button wire:click="toggleEdit" variant="ghost" class="flex-1">Cancel</flux:button>
        </div>
    </div>
    @endif


    <livewire:comments.issue-comments :issue="$issue" />
</div>
