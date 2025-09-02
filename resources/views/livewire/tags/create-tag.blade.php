
<flux:modal name="create-tag" class="md:w-96">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Create Tag</flux:heading>
        </div>
        <form wire:submit.prevent="save">
            <flux:field class="mb-4">
                <flux:input label="Name" wire:model="name" placeholder="Enter tag name..." />
                <flux:error name="name" />
            </flux:field>

            <flux:field class="mb-4">
                <label class="block text-sm font-medium mb-1">Color</label>
                <input type="color" wire:model.live="color" class="flux-input w-16 h-8 p-0 border-none rounded">
                <span class="ml-2 text-xs font-mono">{{ $color ?: '#000000' }}</span>
                <flux:error name="color" />
            </flux:field>

            <div class="flex">
                <flux:spacer />
                <flux:button size="sm" type="submit">Create Tag</flux:button>
            </div>
        </form>
    </div>
</flux:modal>
