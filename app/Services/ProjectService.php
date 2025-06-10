<?php

namespace App\Services;

use App\Http\Resources\RatingResource;
use App\Models\Project;
use App\Models\User;
use App\Repositories\CampaignDonationSumRepository;
use App\Repositories\CampaignParticipantRepository;
use App\Repositories\ImageRepository;
use App\Repositories\LocationRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\RecommendationRepository;
use App\Services\DonationService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectService
{
    public function __construct(
        protected ProjectRepository $projectRepo,
        protected LocationRepository $locationRepo,
        protected ImageRepository $imageRepo,
        protected CampaignDonationSumRepository $campaignDonationSumRepo,
        protected CampaignParticipantRepository $campaignParticipantRepository,
        protected RecommendationRepository $recommendRepo,
        protected DonationService $stripeService,
    ) {}

    public function show($projectId): array
    {
        $project = $this->projectRepo->get($projectId);

        if (Auth::id()) {
            $this->recommendRepo->updateInterests($project->category->id, Auth::id(), 1);
        }

        return $this->transformProject($project);
    }

    /**
     * @throws Exception
     */
    public function  create(array $requestData): Project
    {
        try {
            DB::beginTransaction();

            $locationId = DB::transaction(function () use ($requestData) {
                return $this->locationRepo->create([
                    'latitude' => $requestData['latitude'],
                    'longitude' => $requestData['longitude'],
                    'area' => $requestData['area'] ?? 'غير معروف',
                ]);
            });

            // Create image - must be transactional
            $image = DB::transaction(function () {
                return $this->imageRepo->createPlaceholder();
            });

            // اذا تم انشائها من قبل الفريق التطوعي
            $type = 'حملة رسمية';
            $status = 'نشطة';
            $user = User::where('id', Auth::id())->first();

            if ($user->hasRole('client')) {
                $type = 'مبادرة';
                $status = 'تصويت';
            }


            // Create project
            $attributes = [
                'user_id' => $user->id,
                'category_id' => $requestData['category_id'],
                'location_id' => $locationId,
                'image_id' => $image->id,
                'title' => $requestData['title'],
                'description' => $requestData['description'] ?? null,
                'Execution_date' => $requestData['execution_date'] ?? null,
                'type' => $type,
                'status' => $status,
                'number_of_participant' => $requestData['number_of_participant'],
                'created_by' => 'user',
            ];

            $project = DB::transaction(function () use ($attributes) {
                return $this->projectRepo->create($attributes);
            });

            // create associate donation summaries
            if (isset($requestData['required_amount'])) {
                DB::transaction(function () use ($project, $requestData) {
                    $this->campaignDonationSumRepo->create([
                        'required_amount' => $requestData['required_amount'],
                        'project_id' => $project->id,
                        'total_donated' => 0.00,
                        'total_donors' => 0,
                    ]);
                });
            }

            DB::commit();

            if (isset($requestData['image'])) {
                $this->imageRepo->storeTempImageAndDispatch($requestData['image'], $image->id);
            }

            return $project;

        } catch (Exception $e) {
            DB::rollBack();

            if (isset($image)) {
                $this->imageRepo->deleteImagePlaceholder($image->id);
            }
            throw $e;
        }
    }

    public function getAllProjects($type, $status)
    {
        $projects = $this->projectRepo->getAllProjectsByType($type, $status);

        return $projects->getCollection()->map(function ($project) {
            return $this->transformProject($project);
        });
    }

    public function getAllProjectsByCategoryAndType($category_id, $type = null)
    {
        $projects = $this->projectRepo->getProjectsByCategoryAndType($category_id, $type);

        return $projects->getCollection()->map(function ($project) {
            return $this->transformProject($project);
        });
    }

    // تنظيم الريسبونس حسب نوع المشروع
    private function transformProject($project): array
    {
        $data = [
            'id' => $project->id,
            'title' => $project->title,
            'description' => $project->description,
            'status' => $project->status,
            'execution_date' => $project->Execution_date,
            'user' => [
                'userID' => $project->user?->id,
                'created_by' => $project->user?->name,
                'role' => $project->user?->getRoleNames()[0] ?? 'unknown',
                'userImage' => $project->user->clientProfile->image->image_url ?? 'null',
            ],
            'image_url' => $project->image?->image_url,
            'category' => $project->category?->name,
            'location' => [
                'name' => $project->location?->name,
                'latitude' => $project->location?->latitude,
                'longitude' => $project->location?->longitude,
            ],
            'votes_count' => $project->votes?->count() ?? 0,
            'likes' => $project->totalVotes?->likes ?? 0,
            'dislikes' => $project->totalVotes?->dislikes ?? 0,
            'donation_total' => $project->donationSummary?->total_donated ?? 0,
            'number_of_participants' => $project->number_of_participant,
            'joined_participants' => $project->participants?->count() ?? 0,
            'required_amount' => $project->donationSummary?->required_amount ?? 0,
            'created_at' => $project->created_at?->format('d/m/Y'),
        ];

        if ($project->type === 'مبادرة') {
            unset($data['donation_total'] , $data['joined_participants'] , $data['execution_date']);
            $data['type'] = $project->type;
        } elseif ($project->type === 'حملة رسمية') {
            unset($data['votes_count'], $data['likes'], $data['dislikes']);
            $data['type'] = $project->type;
        }
        if ($project->status == 'منجزة') {
            $ratings = $project->ratings;
            $avgRating = round($ratings->avg('rating'), 1); // rounded to one decimal

            $data['avg_rating'] = $avgRating ?? 0;
            $data['ratings'] = RatingResource::collection($project->ratings);
        }

        return $data;
    }

    /**
     * @throws Exception
     */
    public function getNearbyProjects($distanceKm = 10, $type = null, $categoryId = null)
    {
        $user = User::where('id', Auth::id())->with('clientProfile.location')->first();

        if (! $user || ! $user->clientProfile->location->latitude || ! $user->clientProfile->location->longitude) {
            throw new Exception('User location not set.');
        }

        $latitude = $user->clientProfile->location->latitude;
        $longitude = $user->clientProfile->location->longitude;

        $projects = $this->projectRepo->getNearbyProjects($latitude, $longitude, $distanceKm, $type, $categoryId);

        return $projects->getCollection()->map(function ($project) {
            return $this->transformProject($project);
        });
    }

    public function myProjects()
    {
        $userId = Auth::id();

        $query = Project::with(['category', 'location', 'image', 'ratings.user', 'user'])
            ->where('user_id', $userId);

        $user = User::where('id' , $userId)->first();

        if($user->hasRole('client'))
        {
            $projects = $query->where('type' , 'مبادرة')->latest()->get();
            return  $projects->map(fn ($project) => $this->transformProject($project));
        }

        $projects = $query->where('type', 'حملة رسمية')->latest()->get();
        return $projects->map(fn ($project) => $this->transformProject($project));
    }

    public function getProjectsUserJoined()
    {
        $userId = Auth::id();
        $projects = $this->campaignParticipantRepository->getProjectsUserJoined($userId);

        return $projects->map(fn ($project) => $this->transformProject($project));
    }

    /**
     * @throws Exception
     */
    public function deleteInitiativeProject($projectId, $userId)
    {
        return $this->projectRepo->deleteIfInitiativeOwner($projectId, $userId);
    }

    // Recommendation | Can set Status
    public function getRecommendation($status, $type)
    {

        $projects = $this->projectRepo->getRecommendations(Auth::id(), $status, $type);

        return $projects->map(fn ($project) => $this->transformProject($project));
    }

    // Promoted
    public function getPromoted()
    {
        $projects = $this->projectRepo->getPromoted();
        return $projects->map(fn ($project) => $this->transformProject($project));
    }
}
