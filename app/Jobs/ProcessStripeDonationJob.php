<?php

namespace App\Jobs;

use App\Models\CampaignDonation;
use App\Models\CampaignDonationSummary;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessStripeDonationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $session;
    public $eventType;

    public function __construct($session, $eventType = 'success')
    {
        $this->session = $session;
        $this->eventType = $eventType;
    }


    public function handle(): void
    {
        $metadata = $this->session->metadata ?? null;
        $projectId = $this->session->metadata->campaign_id ??$metadata->campaign_id ?? null;
        $userId = $this->session->metadata->user_id ?? $metadata->user_id ?? null;

        $paymentIntentId = $this->session->payment_intent ?? $this->session->id ?? null;
        $amount = ($this->session->amount_total ?? $this->session->amount ?? 0) / 100;
        Log::info("💵 Amount in webhook: " . $amount);

        $failureReason = $this->session->last_payment_error->message ?? null;
        $isSuccess = $this->eventType === 'success';

        try {
            DB::beginTransaction();

            if (!$projectId) {
                throw new \Exception('Missing campaign ID');
            }
            CampaignDonation::create([
                'user_id' => $userId,
                'project_id' => $projectId,
                'amount' => $amount,
                'status' => $isSuccess ? 'مدفوع' : 'فشل',
                'payment_intent_id' => $paymentIntentId,
                'failure_reason' => $isSuccess ? null : $failureReason,
                'donated_at' => now(),
            ]);

            if ($isSuccess) {
                CampaignDonationSummary::updateOrCreate(
                    ['project_id' => $projectId],
                    [
                        'required_amount' => DB::raw('required_amount'),
                        'total_donated' => DB::raw("total_donated + $amount"),
                        'total_donors' => DB::raw("total_donors + 1"),
                    ]
                );
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('🔥 Error processing Stripe donation: ' . $e->getMessage());
        }
    }
}
