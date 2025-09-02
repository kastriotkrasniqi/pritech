<flux:main>
    <div class="overflow-x-auto -m-6">
        <div class="flex gap-4 min-w-max px-6">
            @foreach ($statuses as $status)
                <div class="w-80 flex-shrink-0">
                    <div class="rounded-lg bg-zinc-400/5 dark:bg-zinc-900 h-full">
                        <div class="px-4 py-4 flex justify-between items-start border-b border-zinc-200 dark:border-zinc-700">
                            <div>
                                <flux:heading size="md">{{ ucfirst(str_replace('_', ' ', $status)) }}</flux:heading>
                                <flux:subheading class="mb-0! text-xs">
                                    {{ count($issues[$status] ?? []) }} tasks
                                </flux:subheading>
                            </div>
                            <div class="w-3 h-3 rounded-full {{ $status === 'open' ? 'bg-green-500' : ($status === 'in_progress' ? 'bg-yellow-500' : 'bg-gray-500') }}"></div>
                        </div>
                        <div class="flex flex-col gap-2 px-2 pb-4 min-h-[400px]">
                            @forelse ($issues[$status] ?? [] as $issue)
                                <div class="bg-white rounded-lg shadow-xs border border-zinc-200 dark:border-white/10 dark:bg-zinc-800 p-3 space-y-2 hover:shadow-md transition-all duration-200 cursor-pointer group">
                                    <div class="flex gap-2 flex-wrap">
                                        <flux:badge color="{{ $issue->priority === 'high' ? 'red' : ($issue->priority === 'medium' ? 'yellow' : 'green') }}" size="sm">
                                            {{ ucfirst($issue->priority) }}
                                        </flux:badge>
                                        @if($issue->project)
                                            <flux:badge color="blue" size="sm" variant="soft">
                                                {{ Str::limit($issue->project->name, 15) }}
                                            </flux:badge>
                                        @endif
                                    </div>
                                    <flux:heading size="sm">
                                        <a href="{{ route('issues.show', $issue->id) }}" wire:navigate class="hover:underline text-sm group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                            {{ Str::limit($issue->title, 50) }}
                                        </a>
                                    </flux:heading>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 space-y-1">
                                        <div class="flex items-center gap-1">
                                            <span>📅</span>
                                            <span>Due: {{ $issue->due_date ? $issue->due_date->format('M d') : '-' }}</span>
                                        </div>
                                        @if($issue->tags->count() > 0)
                                            <div class="flex items-center gap-1">
                                                <span>🏷️</span>
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach($issue->tags->take(3) as $tag)
                                                        <span class="inline-block w-2 h-2 rounded-full" style="background-color: {{ $tag->color }}" title="{{ $tag->name }}"></span>
                                                    @endforeach
                                                    @if($issue->tags->count() > 3)
                                                        <span class="text-xs">+{{ $issue->tags->count() - 3 }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="flex-1 flex items-center justify-center py-8 text-gray-500 dark:text-gray-400">
                                    <div class="text-center">
                                        <div class="text-2xl mb-2">📝</div>
                                        <div class="text-sm">No {{ ucfirst(str_replace('_', ' ', $status)) }} issues</div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</flux:main>
