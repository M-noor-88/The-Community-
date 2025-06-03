<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DonationService;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\DonationRequest;
use App\Traits\JsonResponseTrait;


class DonationController extends Controller
{
    use JsonResponseTrait;
    protected DonationService $donationService;

    public function __construct(DonationService $donationService)
    {
        $this->donationService = $donationService;
    }

    public function donate(DonationRequest $request)
    {
        try {
            $session = $this->donationService->donate($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Donation URL generated successfully',
                'data' => $session->url,
            ], 200);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');

        try {
            $this->donationService->handle($payload, $sig_header);

            return response('Webhook handled', 200);
        } catch (\Exception $e) {
            Log::error('Stripe webhook error: ' . $e->getMessage());
            return $this->error($e->getMessage(), 500);
        }
    }


    public function successview()
    {
        return view('stirpe.onboarding_success');
    }

    public function cancel()
    {
        return 'cancel';
    }

    public function monitoring()
    {
        $data = $this->donationService->monitoring();
        return $this->success($data, 'Donations retrieved successfully', 201);
    }
}
