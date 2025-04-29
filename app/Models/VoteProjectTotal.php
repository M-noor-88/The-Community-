<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static updateOrCreate(array $array, array $array1)
 */
class VoteProjectTotal extends Model
{
    use HasFactory;

    protected $table = 'vote_project_totals';

    protected $fillable = ['project_id', 'likes', 'dislikes'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
