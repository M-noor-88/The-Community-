<?php

namespace App\Repositories;

use App\Models\CampaignDonation;
use App\Models\CampaignParticipant;
use App\Models\Category;
use App\Models\ClientProfile;
use App\Models\Complaint;
use App\Models\Location;
use App\Models\Project;
use App\Models\Rating;
use App\Models\User;
use App\Models\VolunteerProfile;
use App\Models\VoteProjectTotal;
use Illuminate\Support\Facades\DB;

class StatisticsRepository
{
    public function getBasicCounts(): array
    {
        return [
            'users' => User::count(),
            'projects' => Project::count(),
            'complaints' => Complaint::count(),
            'total_donations' => CampaignDonation::sum('amount'),
            'participants' => CampaignParticipant::count(),
            'ratings' => Rating::count(),
        ];
    }

    public function getTopRatedProjects($limit = 5)
    {
        return Project::where('type', 'حملة رسمية')->where('status', 'منجزة')
            ->with([
                'user',
                'image',
                'category',
                'location',
                'votes',
                'totalVotes',
                'donations',
                'donationSummary',
                'participants', ])
            ->withAvg('ratings', 'rating')
            ->orderByDesc('ratings_avg_rating')
            ->take($limit)
            ->get(['id', 'title']);
    }

    public function getMostParticipatedProjects($limit = 5)
    {
        return Project::where('type', 'حملة رسمية')->whereIn('status', ['منجزة', 'نشطة'])
            ->with([
                'user',
                'image',
                'category',
                'location',
                'votes',
                'totalVotes',
                'donations',
                'donationSummary',
                'participants', ])
            ->withCount('participants')
            ->orderByDesc('participants_count')
            ->take($limit)
            ->get(['id', 'title']);
    }

    public function getProjectCountByCategory()
    {
        return Category::withCount('projects')
            ->get(['id', 'name']);
    }

    public function getVotesSummary()
    {
        return VoteProjectTotal::select('project_id', 'likes', 'dislikes')
            ->with('project:id,title')
            ->get();
    }

    public function getUserRoleDistribution(): array
    {
        return [
            'volunteers' => VolunteerProfile::count(),
            'clients' => ClientProfile::count(),
        ];
    }

    // 1. حملات رسمية
    public function getOfficialCampaignsWithLocation()
    {
        return Project::where('type', 'حملة رسمية')
            ->with('location:id,latitude,longitude')
            ->get(['id', 'title',  'type', 'location_id']);
    }

    // 2. مبادرات
    public function getInitiativesWithLocation()
    {
        return Project::where('type', 'مبادرة')
            ->with('location:id,latitude,longitude')
            ->get(['id', 'title', 'type', 'location_id']);
    }

    // 3. Complaints with location and category
    public function getComplaintsWithLocationAndCategory()
    {
        return Complaint::with(['location:id,latitude,longitude', 'category:id,name'])
            ->get(['id', 'title', 'location_id', 'complaint_category_id']);
    }

    public function getMonthlyCounts()
    {
        return DB::table('projects')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month")
            ->selectRaw("SUM(type = 'حملة رسمية') as official_campaigns")
            ->selectRaw("SUM(type = 'مبادرة') as initiatives")
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($row) {
                $complaintsCount = DB::table('complaints')
                    ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$row->month])
                    ->count();

                return [
                    'month' => $row->month,
                    'official_campaigns' => (int) $row->official_campaigns,
                    'initiatives' => (int) $row->initiatives,
                    'complaints' => $complaintsCount,

                ];
            });
    }

    public function getNumberStatusProjects()
    {
        return DB::table('projects')
            ->selectRaw("SUM(status = 'تصويت') as votes")
            ->selectRaw("SUM(status = 'نشطة') as Active ")
            ->selectRaw("SUM(status = 'منجزة') as Completed")
            ->selectRaw("SUM(status = 'ملغية') as Canceled ")
            ->get()
            ->map(function ($raw) {
                return [
                    'votes' => (int) $raw->votes,
                    'Active' => (int) $raw->Active,
                    'Completed' => (int) $raw->Completed,
                    'Canceled' => (int) $raw->Canceled,
                ];
            });
    }
}
