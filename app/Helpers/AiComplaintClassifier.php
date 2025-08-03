<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class AiComplaintClassifier
{
    public static function isValidComplaint(string $description): bool
    {
        try {
            $response = Http::timeout(5)->post('http://127.0.0.1:9999/predict', [
                'description' => $description,
            ]);

            if ($response->failed()) {
                Log::error('AI service failed: '.$response->body());
                return false;
            }

            $result = $response->json()['result'][0] ?? null;

            if (!$result) {
                Log::warning('Unexpected AI response structure: '.$response->body());
                return false;
            }

            return trim($result['label']) === 'مشكلة واضحة';
        } catch (Exception $e) {
            Log::error('AI Exception: '.$e->getMessage());
            return false;
        }
    }
}
