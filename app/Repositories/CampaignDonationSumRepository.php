<?php

namespace App\Repositories;

use App\Models\CampaignDonationSummary;

class CampaignDonationSumRepository
{
    public function create(array $data): CampaignDonationSummary
    {
        return CampaignDonationSummary::create($data);
    }
}
