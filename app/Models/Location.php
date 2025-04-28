<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class Location extends Model
{
    use HasFactory;

    protected $table = 'locations';

    protected $fillable = ['latitude', 'longitude', 'name'];
}
