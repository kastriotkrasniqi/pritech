<?php

declare(strict_types=1);

namespace App\Livewire\Issues;

use App\Models\Issue;
use Livewire\Component;

final class Board extends Component
{
    private const STATUSES = ['open', 'in_progress', 'closed'];

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        $statuses = self::STATUSES;

        // Single query with eager loading for better performance
        $allIssues = Issue::with(['project', 'tags'])
            ->whereIn('status', $statuses)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('status');

        // Ensure all status keys exist
        $issues = collect($statuses)->mapWithKeys(fn ($status) => [
            $status => $allIssues->get($status, collect())->take(10)
        ]);

        return view('livewire.issues.board', compact('issues', 'statuses'));
    }
}
