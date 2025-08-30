<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Comment extends Model
{
    use HasFactory, \Conner\Likeable\Likeable;

    protected $fillable = [
        'issue_id',
        'author_name',
        'body',
        'user_id',
    ];

    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
