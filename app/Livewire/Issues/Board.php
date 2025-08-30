<?php

namespace App\Livewire\Issues;

use Livewire\Component;
use App\Models\Issue;

class Board extends Component
{
    public function render()
    {
        $statuses = ['open', 'in_progress', 'closed'];
        $issues = [];
        foreach ($statuses as $status) {
            $issues[$status] = \App\Models\Issue::with('project', 'tags')
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
