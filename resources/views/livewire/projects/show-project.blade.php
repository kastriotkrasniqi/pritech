<div class="max-w-6xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4" aria-label="Breadcrumb">
        <div class="flex items-center justify-between">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('projects.index') }}" wire:navigate class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">
                        <flux:icon.home variant="mini" class="mr-2" />
                        Projects
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <flux:icon.chevron-right variant="mini" class="mx-2 text-gray-400" />
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $project->name }}</span>
                    </div>
                </li>
            </ol>

            <div class="flex items-center gap-3">
                @can('update', $project)
                    <flux:button
                        wire:click="toggleEdit"
                        variant="{{ $isEditing ? 'ghost' : 'outline' }}"
                        size="sm"
                    >
                        @if($isEditing)
                            Cancel Edit
                        @else
                            Edit Project
                        @endif
                    </flux:button>
                @endcan
                @can('delete', $project)
                    <flux:button
                        variant="danger"
                        wire:click="confirmDelete"
                        size="sm"
                    >
                        Delete Project
                    </flux:button>
                @endcan
                <flux:button
                    variant="ghost"
                    href="{{ route('projects.index') }}"
                    wire:navigate
                    size="sm"
                >
                    <flux:icon.arrow-left variant="mini" class="mr-2" />
                    Back to Projects
                </flux:button>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 mb-4">
        <div class="flex items-center gap-4 mb-4">
            @if($isEditing)
                <flux:field class="flex-1">
                    <flux:input
                        wire:model="form.name"
                        label="Project Name"
                        class="text-3xl font-bold text-gray-900 dark:text-white"
                    />
                </flux:field>
            @else
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $project->name }}</h1>
            @endif

            @if(!$isEditing)
            <flux:badge size="lg" color="{{ $this->getStatusColor() }}">
                @if(!$project->deadline)
                    No Deadline
                @elseif($this->isOverdue())
                    Overdue
                @elseif($project->deadline->diffInDays(now()) <= 7)
                    Due Soon
                @else
                    On Track
                @endif
            </flux:badge>
            @endif
        </div>

        @if($isEditing)
            <flux:field class="mb-4">
                <flux:textarea
                    wire:model="form.description"
                    rows="3"
                    placeholder="Enter project description..."
                    label="Description"
                />
            </flux:field>
        @else
            <p class="text-base text-gray-600 dark:text-gray-400 mb-4">
                {{ $project->description ?: 'No description provided for this project.' }}
            </p>
        @endif

        <!-- Quick Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <div class="text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="text-xl font-bold text-gray-900 dark:text-white">{{ $project->issues->count() }}</div>
                <div class="text-xs text-gray-600 dark:text-gray-400">Issues</div>
            </div>
            <div class="text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="text-xl font-bold text-gray-900 dark:text-white">{{ $project->created_at->format('M d') }}</div>
                <div class="text-xs text-gray-600 dark:text-gray-400">Created</div>
            </div>
            <div class="text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="text-xl font-bold text-gray-900 dark:text-white">{{ $project->start_date ? $project->start_date->format('M d') : 'N/A' }}</div>
                <div class="text-xs text-gray-600 dark:text-gray-400">Start Date</div>
            </div>
            <div class="text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="text-xl font-bold text-gray-900 dark:text-white">{{ $project->deadline ? $project->deadline->format('M d') : 'N/A' }}</div>
                <div class="text-xs text-gray-600 dark:text-gray-400">Deadline</div>
            </div>
        </div>
    </div>

        <!-- Project Information -->
    <div class="space-y-6">
            <!-- Project Details -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Project Details</h3>
                    @if($isEditing)
                        <flux:badge color="blue" size="sm">Editing</flux:badge>
                    @endif
                </div>

                @if($isEditing)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <flux:field>
                            <flux:date-picker
                                wire:model="form.start_date"
                                label="Start Date"
                            />
                        </flux:field>
                        <flux:field>
                            <flux:date-picker
                                wire:model="form.deadline"
                                label="Deadline"
                            />
                        </flux:field>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Start Date</p>
                            <p class="text-gray-900 dark:text-white font-medium">
                                {{ $project->start_date ? $project->start_date->format('F d, Y') : 'Not set' }}
                            </p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Deadline</p>
                            <p class="text-gray-900 dark:text-white font-medium">
                                {{ $project->deadline ? $project->deadline->format('F d, Y') : 'Not set' }}
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Project Owner -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 mb-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Project Owner</h3>
                    @if($isEditing)
                        <flux:badge color="blue" size="sm">Editing</flux:badge>
                    @endif
                </div>

                @if($isEditing)
                    <flux:field >
                        <flux:select
                            wire:model="form.user_id"
                            variant="combobox"
                            :filter="false"
                            label="Owner"
                            placeholder="Select owner..."
                        >
                            <x-slot name="input">
                                <flux:select.input wire:model.live="searchOwner" />
                            </x-slot>
                            @foreach ($this->users as $user)
                                <flux:select.option
                                    value="{{ $user->id }}"
                                    wire:key="{{ $user->id }}"
                                    :selected="$user->id == $form->user_id"
                                >
                                    {{ $user->name }}
                                </flux:select.option>
                            @endforeach
                        </flux:select>
                    </flux:field>
                @else
                    <div class="flex items-center gap-3">
                        <flux:avatar size="md" src="https://i.pravatar.cc/40?u={{ $project->owner?->id ?? 1 }}" />
                        <div class="min-w-0 flex-1">
                            <p class="font-medium text-gray-900 dark:text-white truncate">
                                {{ $project->owner?->name ?? 'Unknown Owner' }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                {{ $project->owner?->email ?? 'No email' }}
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Project Issues -->
            @if($this->issues->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Project Issues</h3>
                <flux:table :paginate="$this->issues">
                    <flux:table.columns>
                        <flux:table.column>Title</flux:table.column>
                        <flux:table.column>Status</flux:table.column>
                        <flux:table.column>Priority</flux:table.column>
                        <flux:table.column>Tags</flux:table.column>
                        <flux:table.column>Due Date</flux:table.column>
                    </flux:table.columns>
                    <flux:table.rows>
                        @foreach ($this->issues as $issue)
                        <flux:table.row :key="$issue->id" class="even:bg-gray-50 dark:even:bg-gray-700/30">
                            <flux:table.cell>
                                <a href="{{ route('issues.show', $issue->id) }}" wire:navigate class="font-medium hover:underline">{{ $issue->title }}</a>
                            </flux:table.cell>
                            <flux:table.cell>
                                <flux:badge size="sm" color="{{ $issue->status === 'open' ? 'green' : ($issue->status === 'in_progress' ? 'yellow' : 'gray') }}">
                                    {{ ucfirst(str_replace('_', ' ', $issue->status)) }}
                                </flux:badge>
                            </flux:table.cell>
                            <flux:table.cell>
                                <flux:badge size="sm" color="{{ $issue->priority === 'high' ? 'red' : ($issue->priority === 'medium' ? 'yellow' : 'green') }}">
                                    {{ ucfirst($issue->priority) }}
                                </flux:badge>
                            </flux:table.cell>
                            <flux:table.cell>
                                @foreach($issue->tags as $tag)
                                    <flux:badge size="xxs" :style="'background-color: ' . $tag->color . '; color: #fff; font-size: 0.65rem; padding: 0.1rem 0.3rem;'">
                                        {{ $tag->name }}
                                    </flux:badge>
                                @endforeach
                            </flux:table.cell>
                            <flux:table.cell>
                                {{ $issue->due_date }}
                            </flux:table.cell>
                        </flux:table.row>
                        @endforeach
                    </flux:table.rows>
                </flux:table>
            </div>
            @endif
        </div>



            <!-- Actions -->
            @if($isEditing)
                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Actions</h3>
                    <div class="flex gap-3">
                        <flux:button
                            wire:click="save"
                            class="flex-1"
                        >
                            Save Changes
                        </flux:button>
                        <flux:button
                            wire:click="cancel"
                            variant="ghost"
                            class="flex-1"
                        >
                            Cancel
                        </flux:button>
                    </div>
                </div>
            @endif



    <!-- Delete Confirmation Modal -->
    <flux:modal wire:model.live="showDeleteModal" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete project?</flux:heading>
                <flux:text class="mt-2">
                    <p>You're about to delete "{{ $project->name }}".</p>
                    <p>This action cannot be reversed.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button wire:click="deleteProject" variant="danger">Delete project</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
