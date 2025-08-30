<flux:main>
        <div class="overflow-x-auto -m-6 ">
            @php
                $statusList = $statuses ?? ['open', 'in_progress', 'closed'];
            @endphp
            <div class="flex gap-4">
                @foreach ($statusList as $status)
                <div>
                    <div class="rounded-lg w-80 max-w-80 bg-zinc-400/5 dark:bg-zinc-900">
                        <div class="px-4 py-4 flex justify-between items-start">
                            <div>
                                <flux:heading>{{ ucfirst(str_replace('_', ' ', $status)) }}</flux:heading>
                                {{-- <flux:subheading class="mb-0!">
                                    {{ isset($issues[$status]) ? count($issues[$status]) : 0 }} tasks
                                </flux:subheading> --}}
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 px-2">
                            @foreach ($issues[$status] ?? [] as $issue)
                            <div class="bg-white rounded-lg shadow-xs border border-zinc-200 dark:border-white/10 dark:bg-zinc-800 p-3 space-y-2">
                                <div class="flex gap-2">
                                    <flux:badge color="{{ $issue->priority === 'high' ? 'red' : ($issue->priority === 'medium' ? 'yellow' : 'green') }}" size="sm">
                                        {{ ucfirst($issue->priority) }}
                                    </flux:badge>
                                </div>
                                <flux:heading>
                                    <a href="{{ route('issues.show', $issue->id) }}" wire:navigate class="hover:underline">
                                        {{ $issue->title }}
                                    </a>
                                </flux:heading>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Due: {{ $issue->due_date ?? '-' }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </flux:main>
