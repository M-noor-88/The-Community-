<?php
namespace App\Services;

use App\Models\Keyword;
use Illuminate\Support\Str;
use App\Repositories\LocationRepository;
use App\Repositories\ComplaintsRepository;
use Exception;

class ComplaintScoringService
{
    public function __construct(
        private LocationRepository $locationRepo,
        private ComplaintsRepository $complaintsRepo,
    ) {}

    public function calculate(string $title, string $description, string $region, string $categoryId): int
    {
        $keywordsScore = 0;
        $content = $title . ' ' . $description;
        $keywords = Keyword::all();
        foreach ($keywords as $keyword) {
            if (Str::contains($content, $keyword->word)) {
                $keywordsScore += $keyword->points;
            }
        }

        $region = $this->locationRepo->getRegion($region);
        if(!$region){
            throw new Exception('region not found');
        }
        $regionScore = $region['points'];

        $category = $this->complaintsRepo->getComplaintCategoryById($categoryId);
        if(!$category){
            throw new Exception('category not found');
        }
        $categoryScore = $category['points'];

        $totalScore = ($keywordsScore * 0.5) +($regionScore * 0.2) +($categoryScore * 0.3);

        return $totalScore;
    }
}
