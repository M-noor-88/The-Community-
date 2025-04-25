<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    use HasFactory;

    protected $table = 'ratings';
    protected $fillable = ['project_id', 'user_id', 'rating', 'comment'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
