<?php

declare(strict_types=1);

namespace App\Livewire\Issues;

use App\Models\Issue;
use Livewire\Component;

final class Board extends Component
{
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        $statuses = ['open', 'in_progress', 'closed'];
        $issues = [];
        foreach ($statuses as $status) {
            $issues[$status] = Issue::with('project', 'tags')
                ->where('status', $status)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        }

        return view('livewire.issues.board', [
            'issues' => $issues,
            'statuses' => $statuses,
        ]);
    }
}
