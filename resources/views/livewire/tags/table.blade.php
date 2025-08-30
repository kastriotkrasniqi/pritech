
<div>
    <flux:modal.trigger name="create-tag">
        <flux:button size="sm" class="mb-4" icon="plus">Create Tag</flux:button>
    </flux:modal.trigger>

    <div class="px-4 rounded-2xl border dark:border-neutral-700 py-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-4">
            <flux:input size="sm" wire:model.live.debounce.300ms="search" class="w-full sm:w-64" placeholder="Search...">
            </flux:input>
            <flux:select size="sm" wire:model.live="perPage" class="w-full sm:w-32" placeholder="Choose per page...">
                <flux:select.option value="5">5</flux:select.option>
                <flux:select.option value="10">10</flux:select.option>
                <flux:select.option value="25">25</flux:select.option>
            </flux:select>
        </div>
        <flux:table :paginate="$this->tags">
            <flux:table.columns>
                <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection" wire:click="sort('name')">Name</flux:table.column>
                <flux:table.column>Color</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach ($this->tags as $tag)
                <flux:table.row :key="$tag->id" class="even:bg-gray-50 dark:even:bg-gray-700/30">
                    <flux:table.cell>
                        <span class="font-medium"><a href="{{ route('tags.edit', $tag->id) }}" wire:navigate>{{ $tag->name }}</a></span>
                    </flux:table.cell>
                    <flux:table.cell>
                        <span class="inline-block w-4 h-4 rounded" style="background: {{ $tag->color }};"></span>
                        <span class="ml-2 text-xs">{{ $tag->color }}</span>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:dropdown position="bottom" align="end" offset="-15">
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>
                            <flux:menu>
                                <flux:menu.item icon="pencil" href="{{ route('tags.edit', $tag->id) }}" wire:navigate>Edit Tag</flux:menu.item>
                                <flux:menu.item icon="archive-box" variant="danger" wire:click="confirmDelete({{ $tag->id }})">Delete</flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>

    <livewire:tags.create-tag />

    <flux:modal wire:model.live="showDeleteModal" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete tag?</flux:heading>
                <flux:text class="mt-2">
                    <p>You're about to delete this tag.</p>
                    <p>This action cannot be reversed.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button wire:click="deleteTag" variant="danger">Delete tag</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
