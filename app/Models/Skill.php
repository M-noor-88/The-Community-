<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static firstOrCreate(string[] $array)
 */
class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function profiles(): HasMany
    {
        return $this->HasMany(ClientProfile::class, 'client_skill_pivot');
    }
}
