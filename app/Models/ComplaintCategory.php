<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ComplaintCategory extends Model
{
    use HasFactory;

    protected $table = 'complaint_categories';

    protected $fillable = ['name', 'points'];

    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class);
    }
}
