<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class Region extends Model
{
    use HasFactory;
    protected $table = 'region';

    protected $fillable = ['name', 'longitude', 'latitude', 'points', 'created_at', 'updated_at'];

}
