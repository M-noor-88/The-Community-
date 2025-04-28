<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property mixed $bio
 * @property mixed $phone
 * @property mixed $age
 * @property mixed $gender
 */
class ClientProfile extends Model
{
    use HasFactory;

    protected $table = 'client_profiles';

    protected $fillable = ['user_id', 'location_id', 'image_id', 'bio', 'phone', 'age', 'gender'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'client_skill_pivot');
    }

    public function fields(): BelongsToMany
    {
        return $this->belongsToMany(VolunteerField::class, 'client_volunteer_field_pivot');
    }
}
