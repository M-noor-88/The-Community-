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

    private function authorizeClient(): bool
    {
        $tokenPath = storage_path('app/google-token.json');

        if (!file_exists($tokenPath)) {
            Log::error('Google token file not found.');
            return false;
        }


        $token = json_decode(file_get_contents($tokenPath), true);
        $this->client->setAccessToken($token);

        if ($this->client->isAccessTokenExpired()) {
            if (!$this->client->getRefreshToken()) {
                Log::error('Missing refresh_token.');
                return false;
            }


            $newToken = $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
            $token = array_merge($token, $newToken);
            file_put_contents($tokenPath, json_encode($token));
            $this->client->setAccessToken($token);
        }

        return true;
    }

    private function sendEmail(string $view, array $data, string $to, string $subject): \Illuminate\Http\JsonResponse
    {
        if (!$this->authorizeClient()) {
            return response()->json(['error' => 'Google token error.'], 500);
        }

        $gmail = new Gmail($this->client);

        $from = 'zed.kreshati.2001@gmail.com'; // Must be the Gmail account you're authorized with
        $htmlBody = view($view, $data)->render();

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
            Log::error('Gmail Send Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to send email: ' . $e->getMessage()], 500);

        }
    }

    public function sendVerificationEmail(array $request)
    {
        return $this->sendEmail('google_auth', [
            'verification_code' => $request['verification_code'],
            'verification_expires_at' => $request['verification_expires_at'],
        ], $request['email'], 'Verification Code');
    }



    public function sendResetPasswordEmail(array $request)
    {
        return $this->sendEmail('Reset_password', [
            'reset_code' => $request['reset_code'],
            'reset_expires_at' => $request['reset_expires_at'],
        ], $request['email'], 'Reset Password');

    }
}
