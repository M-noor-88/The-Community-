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
                'participants',
            ])
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
                'participants',
            ])
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

    public function getLowEngagementCampaigns()
    {
        return Project::where('type', 'حملة رسمية')
            ->where('status' , 'نشطة')
            ->where('is_archived', false)
            ->with(['user', 'category', 'participants', 'donationSummary'])
            ->withCount('participants')
            ->where('created_at', '<=', now()->subDays(10))
            ->get();

    }

    ////////////////////complaints/////////////////////
    public function getComplaintByStatus()
    {

        return Complaint::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');
    }

    public function PendingTime()
    {
        return  Complaint::where('status', 'انتظار')
            ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, NOW())) as avg_hours')
            ->value('avg_hours');
    }

    public function InProgressTime()
    {
        return Complaint::where('status', 'يتم التنفيذ')
            ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, NOW())) as avg_hours')
            ->value('avg_hours');
    }

    public function getTotalComplaints()
    {
        return Complaint::count();
    }

    public function getComplaintsByCategory()
    {
        return Complaint::select('complaint_category_id', DB::raw('COUNT(*) as count'))
            ->groupBy('complaint_category_id')
            ->with('category:id,name')
            ->get()
            ->map(function ($item) {
                return [
                    'category' => $item->category->name ?? 'Unknown',
                    'count' => $item->count,
                ];
            });
    }

    public function getMostPayment()
    {
        return  CampaignDonation::where('status', 'مدفوع')
            ->orderByDesc('amount')
            ->first(['amount', 'user_id', 'project_id']);
    }

    public function getTotalPayment()
    {
        return CampaignDonation::where('status', 'مدفوع')->sum('amount');
    }

    public function getTopCampaigns()
    {
        return  DB::table('campaign_donation_summaries')
            ->join('projects', 'campaign_donation_summaries.project_id', '=', 'projects.id')
            ->where('projects.type', 'حملة رسمية')
            ->orderByDesc('total_donated')
            ->take(5)
            ->get(['projects.title', 'total_donated', 'required_amount']);
    }

    public function getDonationTrendsByTime(): array
    {
        // Hourly trends (0–23)
        $hourly = CampaignDonation::where('status', 'مدفوع')
            ->selectRaw('HOUR(donated_at) as hour, SUM(amount) as total')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        // Daily trends (Y-m-d)
        $daily = CampaignDonation::where('status', 'مدفوع')
            ->selectRaw('DATE(donated_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Weekly trends (e.g., Monday, Tuesday)
        $weekly = CampaignDonation::where('status', 'مدفوع')
            ->selectRaw('DAYNAME(donated_at) as day_name, SUM(amount) as total')
            ->groupBy('day_name')
            ->orderByRaw("FIELD(day_name, 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday')")
            ->get();

        return [
            'hourly' => $hourly,
            'daily' => $daily,
            'weekly' => $weekly,
        ];
    }

    public function getAveragePoints()
    {
        return Complaint::avg('priority_points');
    }

    public function getScoreDistribution()
    {
        $scoreDistribution = [
            'low' => Complaint::where('priority_points', '<', 10)->count(),
            'medium' => Complaint::whereBetween('priority_points', [10, 15])->count(),
            'high' => Complaint::where('priority_points', '>', 15)->count(),
        ];

        return $scoreDistribution;
    }

    public function getMostHighComplaint()
    {
        return Complaint::orderByDesc('priority_points')
            ->first(['id', 'title', 'priority_points', 'region', 'status']);
    }
}
