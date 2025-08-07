<?php

namespace App\Services;

use App\Models\Keyword;
use Illuminate\Support\Str;
use App\Repositories\LocationRepository;
use App\Repositories\ComplaintsRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class ComplaintScoringService
{
    public function __construct(
        private LocationRepository $locationRepo,
        private ComplaintsRepository $complaintsRepo,
    ) {}

    public function calculate(int $complaintId): float
    {
        $complaint = $this->complaintsRepo->getComplaintById($complaintId);
        if (!$complaint) {
            throw new Exception('Complaint not found');
        }

        // كلمات مفتاحية
        $keywordsScore = 0;
        $content = $complaint->title . ' ' . $complaint->description;
        $keywords = Keyword::all();
        foreach ($keywords as $keyword) {
            if (Str::contains($content, $keyword->word)) {
                $keywordsScore += $keyword->points;
            }
        }

        // المنطقة
        $region = $this->locationRepo->getRegion($complaint->region);
        if (!$region) {
            throw new Exception('Region not found');
        }
        $regionScore = $region['points'];

        // التصنيف
        $category = $this->complaintsRepo->getComplaintCategoryById($complaint->complaint_category_id);
        if (!$category) {
            throw new Exception('Category not found');
        }
        $categoryScore = $category['points'];

        // الوسائط
        $mediaScore = $complaint->complaintImages()->exists() ? 10 : 0;

        // عمر الشكوى
        $createdDate = Carbon::parse($complaint->created_at);
        $daysOld = $createdDate->diffInDays(now());
        $timeScore = $this->calculateTimeScore($daysOld);

        // الحساب النهائي مع الأوزان
        $totalScore = ($keywordsScore * 0.4) +
                      ($regionScore * 0.15) +
                      ($categoryScore * 0.15) +
                      ($mediaScore * 0.1) +
                      ($timeScore * 0.2);

        return round($totalScore, 2);
    }

    private function calculateTimeScore(int $days): int
    {
        if ($days <= 1) return 0;
        if ($days <= 7) return 5;
        if ($days <= 30) return 10;
        if ($days <= 180) return 20;
        return 30;
    }
}
