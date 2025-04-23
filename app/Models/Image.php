<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $string, int $img_id)
 * @method static create(string[] $array)
 * @property mixed $id
 */
class Image extends Model
{
    protected $table = 'images';

    protected $fillable = ['image_url'];

}
