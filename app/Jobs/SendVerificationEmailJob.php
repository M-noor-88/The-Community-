<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;
use Illuminate\Support\Facades\Log;
use App\Services\MailService;

class SendVerificationEmailJob implements ShouldQueue
{
    use Queueable, SerializesModels, Dispatchable, InteractsWithQueue;

    protected $mailData;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->mailData=$data;
    }

    /**
     * Execute the job.
     */
    public function handle(MailService $mailService): void
    {
        $mailService->sendVerificationEmail($this->mailData);

    }
}
