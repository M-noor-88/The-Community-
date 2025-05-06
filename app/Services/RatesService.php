<?php

namespace App\Services;

use App\Repositories\ProjectRepository;
use App\Repositories\RateRepository;
use Exception;

class RatesService
{
    public function __construct(
        protected RateRepository $rateRepository,
        protected ProjectRepository $projectRepository
    ) {}

    /**
     * @throws Exception
     */
    public function addRateToProject($data, $userId)
    {
        $project = $this->projectRepository->get($data['project_id']);
        if ($project->type !== 'حملة رسمية' || $project->status !== 'منجزة') {
            throw new Exception('لا يمكن تقييم إلا الحملات الرسمية المنجزة فقط.');
        }

        return $this->rateRepository->create($data, $userId);
    }

    public function getProjectRatings($projectId)
    {
        return $this->rateRepository->getProjectRatings($projectId);
    }
}
