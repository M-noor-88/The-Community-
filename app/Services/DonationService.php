<?php

namespace App\Services;

use App\Repositories\CampaignDonationSumRepository;
use Stripe\Stripe;
use App\Repositories\ProjectRepository;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Jobs\ProcessStripeDonationJob;
use Stripe\Webhook;
use App\Models\CampaignDonation;
use Illuminate\Support\Facades\Log;


class DonationService
{
    protected ProjectRepository $ProjectRepository;
    protected CampaignDonationSumRepository $campaignDonationSumRepository;

    public function __construct(ProjectRepository $ProjectRepo , CampaignDonationSumRepository $campaignDonationSumRepository)
    {
        $this->ProjectRepository  = $ProjectRepo;
        $this->campaignDonationSumRepository = $campaignDonationSumRepository;
    }

    public function donate(array $request)
    {
        $project = $this->ProjectRepository->get($request['project_id']);

        if (! $project) {
            throw new Exception('Project not found.');
        }
        Log::info('Donation rejected for project: ' . $project->type . ' ' . $project->status);

        if ($project->type != 'حملة رسمية' || $project->status != 'نشطة') {
            Log::info('Donation rejected for project: ' . $project->type . ' ' . $project->status);
            throw new Exception('Project is not active.');
        }
        $totalrequiredAmount = $project->donationSummary->required_amount;
        $totalDonatedAmount = $project->donationSummary->total_donated;
        $requiredAmount = $totalrequiredAmount - $totalDonatedAmount;

        if ($request['amount'] >= $requiredAmount) {
            throw new Exception('Donation amount exceeds the required amount.');
        }

        $user = Auth::user();
        if (! $user) {
            throw new Exception('User not authenticated.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));
        $amount = intval($request['amount']) * 100;

        // Create Checkout Session
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Donation to: ' . $project->title,
                    ],
                    'unit_amount' => $amount,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('donation.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('donation.cancel')   . '?session_id={CHECKOUT_SESSION_ID}',



            'metadata' => [
                'campaign_id' => $project->id,
                'user_id' => $user->id,
            ],
            'payment_intent_data' => [
                'metadata' => [
                    'campaign_id' => $project->id,
                    'user_id' => $user->id,
                ],
            ],

        ]);
        return ($session);
    }

    public function handle($payload, $sig_header)
    {
        $event = Webhook::constructEvent(
            $payload,
            $sig_header,
            config('services.stripe.webhook_secret')
        );

        if ($event->type === 'checkout.session.completed') {
            Log::info('Stripe checkout session completed.');
            ProcessStripeDonationJob::dispatch($event->data->object, 'success');
        }

        if ($event->type === 'payment_intent.payment_failed') {
            Log::info('Stripe payment intent failed.');
            ProcessStripeDonationJob::dispatch($event->data->object, 'failed');
        }
    }

    public function monitoring()
    {
        $donations = CampaignDonation::with('user')->get();

        $result = $donations->map(function ($donation) {
            return [
                'id' => $donation->id,
                'user_id' => $donation->user_id,
                'user_name' => $donation->user->name ?? 'Unknown',
                'project_id' => $donation->project_id,
                'amount' => $donation->amount,
                'status' => $donation->status,
                'payment_intent_id' => $donation->payment_intent_id,
                'failure_reason' => $donation->failure_reason,
                'donated_at' => $donation->donated_at,
            ];
        });

        return $result->toArray();
    }


    public function myDonations()
    {
        $user_id = (int) Auth::id();

        return $this->campaignDonationSumRepository->myDonations($user_id)->map(function ($donation)  {
           return [
               'id' => $donation->id,
               'projectID' => $donation->project_id,
               'donated_at'=> $donation->donated_at,
               'amount'=> $donation->amount,
               'status'=>$donation->status,
               'project' => [
                   'title'=> $donation->project->title,
                   'description' => $donation->project->description,
               ]

           ];
        });
    }
}
