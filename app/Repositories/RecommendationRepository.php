<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class RecommendationRepository
{
    public function updateInterests($categoryID , $userID , $score): void
    {
        DB::table('user_interests')->updateOrInsert(
            ['user_id' => $userID, 'category_id' => $categoryID],
            ['interest_score' => DB::raw("interest_score + $score")]
        );
    }

}
