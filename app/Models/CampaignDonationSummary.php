<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CampaignDonationSummary extends Model
{
    use HasFactory;

    protected $table = 'campaign_donation_summaries';

    protected $fillable = ['project_id', 'total_donated', 'total_donors', 'required_amount'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
