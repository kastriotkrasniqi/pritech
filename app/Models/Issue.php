<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Issue extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
    ];

    public static function statusOptions(): array
    {
        return IssueStatus::all();
    }

    public static function priorityOptions(): array
    {
        return IssuePriority::all();
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'issue_tag');
    }

    // Members assigned to this issue
    public function members()
    {
        return $this->belongsToMany(User::class, 'issue_user');
    }
}
