<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static firstOrCreate(string[] $array)
 */
class VolunteerField extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function profiles(): HasMany
    {
        return $this->HasMany(ClientProfile::class, 'client_volunteer_field_pivot');
    }
}
