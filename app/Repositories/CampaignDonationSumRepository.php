<?php

namespace App\Repositories;

use App\Models\CampaignDonation;
use App\Models\CampaignDonationSummary;
use Illuminate\Support\Collection;

class CampaignDonationSumRepository
{
    public function create(array $data): CampaignDonationSummary
    {
        return CampaignDonationSummary::create($data);
    }


    public function myDonations(int $userId) : Collection
    {
        return CampaignDonation::where('user_id' , $userId)
            ->with('project')->get();
    }
}
