<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Comment extends Model
{
    use \Conner\Likeable\Likeable, HasFactory;

    protected $fillable = [
        'issue_id',
        'body',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function canBeEditedBy(User $user): bool
    {
        return $this->user_id === $user->id;
    }

    public function canBeDeletedBy(User $user): bool
    {
        return $this->canBeEditedBy($user) || $this->issue->project->user_id === $user->id;
    }

    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
