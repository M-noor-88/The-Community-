<?php

namespace App\Services;

use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;
use Illuminate\Support\Facades\Log;

class MailService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client;
        $this->client->setClientId(config('services.google.client_id'));
        $this->client->setClientSecret(config('services.google.client_secret'));
        $this->client->setRedirectUri(config('services.google.redirect_uri'));
        $this->client->addScope(Gmail::GMAIL_SEND);
        $this->client->setAccessType('offline');
        $this->client->setPrompt('consent');
    }

    public function sendVerificationEmail(array $request)
    {

        $tokenPath = storage_path('app/google-access-token.json');
        $token = json_decode(file_get_contents($tokenPath), true);
        $this->client->setAccessToken($token);

        // Automatically refresh if expired
        if ($this->client->isAccessTokenExpired()) {

            $newToken = $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
            $token = array_merge($token, $newToken);
            $this->client->setAccessToken($token);

        }

        $gmail = new Gmail($this->client);

        $from = 'zed.kreshati.2001@gmail.com'; // your authorized sender (must match the authenticated Gmail account)
        $to = $request['email'];
        $subject = 'Google Authentication test';
        // ✅ Render Blade view
        $verification_code = $request['verification_code'];

        $htmlBody = view('google_auth', [
            'verification_code' => $verification_code,
            'verification_expires_at' => $request['verification_expires_at'],
        ])->render();

        // Construct raw email
        $rawMessageString = "From: $from\r\n";
        $rawMessageString .= "To: $to\r\n";
        $rawMessageString .= "Subject: $subject\r\n";
        $rawMessageString .= "MIME-Version: 1.0\r\n";
        $rawMessageString .= "Content-Type: text/html; charset=utf-8\r\n\r\n";
        $rawMessageString .= $htmlBody;

        $rawMessage = base64_encode($rawMessageString);
        $rawMessage = str_replace(['+', '/', '='], ['-', '_', ''], $rawMessage);

        $message = new Message;
        $message->setRaw($rawMessage);

        try {
          $sentMessage =  $gmail->users_messages->send('me', $message);
            Log::info('Email sent successfully', ['messageId' => $sentMessage->getId()]);

            return response()->json(['message' => 'Email sent successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Failed to send email', ['error' => $e->getMessage()]);

            return response()->json(['error' => 'Failed to send email: '.$e->getMessage()], 500);
        }

    }



    public function sendResetPasswordEmail(array $request)
    {
        $token = json_decode(env('GOOGLE_ACCESS_TOKEN'), true);
        $this->client->setAccessToken($token);

        // Automatically refresh if expired
        if ($this->client->isAccessTokenExpired()) {
            $newToken = $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
            $token = array_merge($token, $newToken);
            $this->client->setAccessToken($token);

        }

        $gmail = new Gmail($this->client);

        $from = 'zed.kreshati.2001@gmail.com'; // your authorized sender (must match the authenticated Gmail account)
        $to = $request['email'];
        $subject = 'Reset Password ';
        // ✅ Render Blade view
        $reset_code = $request['reset_code'];

        $htmlBody = view('Reset_password', [
            'reset_code' => $reset_code,
            'reset_expires_at' => $request['reset_expires_at'],
        ])->render();

        // Construct raw email
        $rawMessageString = "From: $from\r\n";
        $rawMessageString .= "To: $to\r\n";
        $rawMessageString .= "Subject: $subject\r\n";
        $rawMessageString .= "MIME-Version: 1.0\r\n";
        $rawMessageString .= "Content-Type: text/html; charset=utf-8\r\n\r\n";
        $rawMessageString .= $htmlBody;

        $rawMessage = base64_encode($rawMessageString);
        $rawMessage = str_replace(['+', '/', '='], ['-', '_', ''], $rawMessage);

        $message = new Message;
        $message->setRaw($rawMessage);

        try {
            $gmail->users_messages->send('me', $message);

            return response()->json(['message' => 'Email sent successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send email: '.$e->getMessage()], 500);
        }
    }
}
