<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'complaint_category_id', 'location_id', 'assigned_to', 'last_status_changed_at',
        'title', 'description', 'status','region', 'priority_points'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ComplaintCategory::class, 'complaint_category_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function complaintImages()
    {
        return $this->belongsToMany(Image::class, 'complaint_images')->where('type', 'complaint');
    }

    public function achievementImages()
    {
        return $this->belongsToMany(Image::class, 'complaint_images')->where('type', 'achievement');
    }

    public function workflowLogs()
    {
        return $this->hasMany(ComplaintWorkflowLog::class);
    }

    public function assignedAgent()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
