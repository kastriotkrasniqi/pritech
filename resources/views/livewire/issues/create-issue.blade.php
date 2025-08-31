<flux:modal name="create-issue" class="md:w-96">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Create Issue</flux:heading>
        </div>
        <form wire:submit.prevent="save">
            <flux:field class="mb-4">
                <flux:input label="Title" wire:model="form.title" placeholder="Enter title..."  />
            </flux:field>
            <flux:field class="mb-4">
                <flux:textarea label="Description" wire:model="form.description" rows="3" placeholder="Enter description..." />
            </flux:field>
            <flux:field class="mb-4">
                <flux:select wire:model="form.status" label="Status" placeholder="Select status..." >
                    @foreach($statuses as $status)
                        <flux:select.option value="{{ $status }}">{{ ucfirst(str_replace('_', ' ', $status)) }}</flux:select.option>
                    @endforeach
                </flux:select>
            </flux:field>
            <flux:field class="mb-4">
                <flux:select wire:model="form.priority" label="Priority"  placeholder="Select priority..." >
                    @foreach($priorities as $priority)
                        <flux:select.option value="{{ $priority }}">{{ ucfirst($priority) }}</flux:select.option>
                    @endforeach
                </flux:select>
            </flux:field>
            <flux:field class="mb-4">
                <flux:date-picker label="Due Date" wire:model="form.due_date" />
            </flux:field>
            <flux:field class="mb-4">
                <flux:select wire:model="form.project_id" variant="combobox" :filter="false" label="Project" placeholder="Select project with ajax request..." >
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
            <flux:field class="mb-4">
                <flux:select wire:model="form.tags" label="Tags"  variant="listbox" multiple placeholder="Select tags...">
                    @foreach($tags as $tag)
                        <flux:select.option value="{{ $tag->id }}">{{ $tag->name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </flux:field>

             <flux:field class="mb-4">
                <flux:select wire:model="form.members" label="Members"  variant="listbox" multiple placeholder="Select members..." searchable>
                    @foreach($members as $user)
                        <flux:select.option value="{{ $user->id }}">{{ $user->name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </flux:field>

            <div class="flex">
                <flux:spacer />
                <flux:button size="sm" type="submit">Save Issue</flux:button>
            </div>
        </form>
    </div>
</flux:modal>
