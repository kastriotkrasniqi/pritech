<div class="max-w-4xl mx-auto">
    <nav class="mb-4" aria-label="Breadcrumb">
        <div class="flex items-center justify-between">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('tags.index') }}" wire:navigate
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">
                        <flux:icon.tag variant="mini" class="mr-2" />
                        Tags
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <flux:icon.chevron-right variant="mini" class="mx-2 text-gray-400" />
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $tag->name }}</span>
                    </div>
                </li>
            </ol>

            <div class="flex items-center gap-3">
                <flux:button size="sm" variant="outline" wire:click="toggleEdit">Edit Tag</flux:button>
                <flux:button variant="ghost" href="{{ route('tags.index') }}" wire:navigate size="sm">
                    <flux:icon.arrow-left variant="mini" class="mr-2" />
                    Back to Tags
                </flux:button>
            </div>
        </div>
    </nav>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 mb-4">

        @if($isEditing)
        <form wire:submit.prevent="save" class="space-y-6">
            <flux:field class="mb-4">
                <flux:input label="Name" wire:model="name" placeholder="Enter tag name..." />
                <flux:error name="name" />
            </flux:field>

            <flux:field class="mb-4">
                <label class="block text-sm font-medium mb-1">Color</label>
                <input type="color" wire:model="color" class="flux-input w-16 h-8 p-0 border-none rounded">
                <span class="ml-2 text-xs font-mono">{{ $color }}</span>
                <flux:error name="color" />
            </flux:field>

            <div class="flex gap-2">
                <flux:spacer />
                <flux:button size="sm" type="submit">Save changes</flux:button>
                <flux:button size="sm" variant="ghost" type="button" wire:click="toggleEdit">Cancel</flux:button>
            </div>
        </form>
        @else

        <div class="space-y-4">
            <div>
                <span class="block text-sm font-medium mb-1">Name</span>
                <span class="text-lg">{{ $tag->name }}</span>
            </div>
            <div>
                <span class="block text-sm font-medium mb-1">Color</span>
                <div class="flex items-center gap-2">
                    <span class="inline-block w-6 h-6 rounded border" style="background: {{ $tag->color }};"></span>
                    <span class="text-xs font-mono">{{ $tag->color }}</span>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
