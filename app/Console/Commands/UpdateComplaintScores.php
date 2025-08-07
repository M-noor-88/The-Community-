<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;
use App\Services\ComplaintScoringService;
use App\Models\Complaint;

class UpdateComplaintScores extends Command
{
    protected $signature = 'complaints:update-scores';
    protected $description = 'تحديث درجات الشكاوى يوميًا';

    public function __construct(private ComplaintScoringService $scoringService)
    {
        parent::__construct();
    }

    public function handle()
    {
        Log::info('Complaint score update command executed');
        $this->info('  update score...');

        $complaints = Complaint::all();

        foreach ($complaints as $complaint) {
            try {
                $score = $this->scoringService->calculate($complaint->id);
                $complaint->update(['priority_points' => $score]);
                $this->info("complaint #{$complaint->id} score: $score");
            } catch (\Exception $e) {
                $this->error("failed to calculate #{$complaint->id}: " . $e->getMessage());
            }
        }

        $this->info(' ended.');
    }
}
