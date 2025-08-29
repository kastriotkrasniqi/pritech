<div>
    <flux:modal.trigger name="create-project">
        <flux:button size="sm" class="mb-4">Create Project
            <flux:icon.plus variant="mini" />
        </flux:button>
    </flux:modal.trigger>

    <div class="px-4 rounded-2xl border dark:border-neutral-700  py-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-4">
            <flux:input size="sm" wire:model.live.debounce.300ms="search" class="w-full sm:w-64"
                placeholder="Search...">
            </flux:input>
            <flux:select size="sm" wire:model.live="perPage" class="w-full sm:w-32" placeholder="Choose per page...">
                <flux:select.option value="5">5</flux:select.option>
                <flux:select.option value="10">10</flux:select.option>
                <flux:select.option value="25">25</flux:select.option>
            </flux:select>
        </div>
        <flux:table :paginate="$this->projects">
            <flux:table.columns>
                <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection"
                    wire:click="sort('name')">Name</flux:table.column>
                <flux:table.column>Description</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection"
                    wire:click="sort('created_at')">Created</flux:table.column>
                <flux:table.column>Owner</flux:table.column>
                <flux:table.column>Deadline</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->projects as $project)
                <flux:table.row :key="$project->id" class="even:bg-gray-50 dark:even:bg-gray-700/30">
                    <flux:table.cell>{{ $project->name }}</flux:table.cell>
                    <flux:table.cell>{{ str()->limit($project->description, 30) }}</flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">{{ $project->created_at->format('Y-m-d') }}
                    </flux:table.cell>
                    <flux:table.cell>{{ $project->owner?->name ?? '-' }}</flux:table.cell>
                    <flux:table.cell>{{ $project->deadline ?? '-' }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:dropdown position="bottom" align="end" offset="-15">
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom">
                            </flux:button>
                            <flux:menu>
                                <flux:menu.item icon="document-text">View Project</flux:menu.item>
                                <flux:menu.item icon="receipt-refund" >Edit</flux:menu.item>
                                <flux:menu.item icon="archive-box" variant="danger"
                                    wire:click="confirmDelete({{ $project->id }})">
                                    Delete
                                </flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>

    <livewire:projects.create-project />

    <flux:modal wire:model.live="showDeleteModal" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete project?</flux:heading>
                <flux:text class="mt-2">
                    <p>You're about to delete this project.</p>
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
