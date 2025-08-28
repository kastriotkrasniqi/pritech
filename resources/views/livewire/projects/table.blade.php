<div class="px-4 rounded-2xl border dark:border-neutral-700  py-4" >
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-4">
        <flux:input size="sm" wire:model.live.debounce.300ms="search" class="w-full sm:w-64" placeholder="Search..."></flux:input>
        <flux:select size="sm" wire:model.live="perPage" class="w-full sm:w-32" placeholder="Choose per page...">
            <flux:select.option value="5">5</flux:select.option>
            <flux:select.option value="10">10</flux:select.option>
            <flux:select.option value="25">25</flux:select.option>
        </flux:select>
    </div>
    <flux:table :paginate="$this->users">
        <flux:table.columns>
            <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection"
                wire:click="sort('name')">Name</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection"
                wire:click="sort('created_at')">Registered</flux:table.column>
            <flux:table.column>Email</flux:table.column>
            <flux:table.column>Status</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->users as $user)
            <flux:table.row :key="$user->id" class="even:bg-gray-50 dark:even:bg-gray-700/30">
                <flux:table.cell class="flex items-center gap-3">
                    <flux:avatar size="xs" src="https://i.pravatar.cc/40?u={{ $user->id }}" />
                    {{ $user->name }}
                </flux:table.cell>
                <flux:table.cell class="whitespace-nowrap">{{ $user->created_at->format('Y-m-d') }}</flux:table.cell>
                <flux:table.cell>{{ $user->email }}</flux:table.cell>
                <flux:table.cell>
                    <flux:badge size="sm" color="green" inset="top bottom">Active</flux:badge>
                </flux:table.cell>
            </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

</div>
