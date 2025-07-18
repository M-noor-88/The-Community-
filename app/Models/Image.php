<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, int $img_id)
 * @method static create(string[] $array)
 *
 * @property mixed $id
 */
class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = ['image_url'];

    public function complaints()
    {
        return $this->belongsToMany(Complaint::class, 'achievement_images');
    }
}
