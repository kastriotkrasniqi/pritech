<flux:modal name="create-project" class="md:w-96">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Create Project</flux:heading>
        </div>
        <form wire:submit.prevent="save">
            @csrf
            <flux:field class="mb-4">
                <flux:input label="Name" wire:model="form.name" />
            </flux:field>

            <flux:field class="mb-4">
                <flux:textarea label="Description" wire:model.live="form.description" rows="3" />
            </flux:field>

             <flux:field class="mb-4">
            <flux:select wire:model="form.user_id" variant="combobox" :filter="false" label="Owner" placeholder="Select owner..." >
                <x-slot name="input">
                    <flux:select.input wire:model.live="searchOwner" />
                </x-slot>
                @foreach ($this->users as $user)
                    <flux:select.option value="{{ $user->id }}" wire:key="{{ $user->id }}">
                        {{ $user->name }}
                    </flux:select.option>
                @endforeach
            </flux:select>
            </flux:field>


            <flux:field class="mb-4">
                <flux:date-picker label="Start Date" wire:model="form.start_date" />
            </flux:field>

            <flux:field class="mb-4">
                <flux:date-picker label="Deadline"  wire:model="form.deadline" />
            </flux:field>


            <div class="flex">
                <flux:spacer />
                <flux:button size="sm" type="submit">Save changes</flux:button>
            </div>
        </form>
</flux:modal>
