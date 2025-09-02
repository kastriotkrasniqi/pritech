<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'deadline',
        'user_id',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'deadline' => 'datetime',
    ];

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }

    // Owner of the project
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
