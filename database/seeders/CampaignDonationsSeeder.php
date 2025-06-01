<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CampaignDonationsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('campaign_donations')->insert([
            [
                'id' => 1,
                'user_id' => 2,
                'project_id' => 1,
                'donated_at' => '2025-05-29 22:57:44',
                'amount' => 150.00,
                'status' => 'مدفوع',
                'payment_intent_id' => 'pi_3RUFOLG3P0lzddKX0C2tWuiz',
                'created_at' => '2025-05-29 19:57:44',
                'updated_at' => '2025-05-29 19:57:44',
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'project_id' => 1,
                'donated_at' => '2025-05-29 23:20:59',
                'amount' => 150.00,
                'status' => 'مدفوع',
                'payment_intent_id' => 'pi_3RUFkrG3P0lzddKX1Aqp05ZU',
                'created_at' => '2025-05-29 20:20:59',
                'updated_at' => '2025-05-29 20:20:59',
            ],
            [
                'id' => 3,
                'user_id' => 2,
                'project_id' => 1,
                'donated_at' => '2025-05-30 20:03:00',
                'amount' => 200.00,
                'status' => 'مدفوع',
                'payment_intent_id' => 'pi_3RUZ8nG3P0lzddKX1eVnw9rs',
                'created_at' => '2025-05-30 17:03:00',
                'updated_at' => '2025-05-30 17:03:00',
            ],
            [
                'id' => 4,
                'user_id' => 2,
                'project_id' => 2,
                'donated_at' => '2025-05-30 20:13:02',
                'amount' => 200.00,
                'status' => 'مدفوع',
                'payment_intent_id' => 'pi_3RUZIRG3P0lzddKX108uW0i9',
                'created_at' => '2025-05-30 17:13:02',
                'updated_at' => '2025-05-30 17:13:02',
            ],
            [
                'id' => 5,
                'user_id' => 2,
                'project_id' => 2,
                'donated_at' => '2025-05-30 21:57:20',
                'amount' => 10.00,
                'status' => 'مدفوع',
                'payment_intent_id' => 'pi_3RUavQG3P0lzddKX0tfut8Tu',
                'created_at' => '2025-05-30 18:57:20',
                'updated_at' => '2025-05-30 18:57:20',
            ],
            [
                'id' => 6,
                'user_id' => 2,
                'project_id' => 2,
                'donated_at' => '2025-05-30 22:19:24',
                'amount' => 0.00,
                'status' => 'مدفوع',
                'payment_intent_id' => null,
                'created_at' => '2025-05-30 19:19:24',
                'updated_at' => '2025-05-30 19:19:24',
            ],
            [
                'id' => 7,
                'user_id' => 2,
                'project_id' => 2,
                'donated_at' => '2025-06-01 14:47:25',
                'amount' => 0.00,
                'status' => 'مدفوع',
                'payment_intent_id' => null,
                'created_at' => '2025-06-01 11:47:25',
                'updated_at' => '2025-06-01 11:47:25',
            ],
            [
                'id' => 8,
                'user_id' => 2,
                'project_id' => 2,
                'donated_at' => '2025-06-01 14:49:08',
                'amount' => 0.00,
                'status' => 'مدفوع',
                'payment_intent_id' => null,
                'created_at' => '2025-06-01 11:49:08',
                'updated_at' => '2025-06-01 11:49:08',
            ],
            [
                'id' => 9,
                'user_id' => 2,
                'project_id' => 2,
                'donated_at' => '2025-06-01 16:49:32',
                'amount' => 15.00,
                'status' => 'مدفوع',
                'payment_intent_id' => 'pi_3RVF4hG3P0lzddKX0vx7mwuu',
                'created_at' => '2025-06-01 13:49:32',
                'updated_at' => '2025-06-01 13:49:32',
            ],
            [
                'id' => 10,
                'user_id' => 2,
                'project_id' => 2,
                'donated_at' => '2025-06-01 16:54:21',
                'amount' => 15.00,
                'status' => 'فشل',
                'payment_intent_id' => 'pi_3RVF9LG3P0lzddKX0hHnqLdQ',
                'created_at' => '2025-06-01 13:54:21',
                'updated_at' => '2025-06-01 13:54:21',
            ],
            [
                'id' => 11,
                'user_id' => 2,
                'project_id' => 2,
                'donated_at' => '2025-06-01 16:54:45',
                'amount' => 15.00,
                'status' => 'مدفوع',
                'payment_intent_id' => 'pi_3RVF9LG3P0lzddKX0hHnqLdQ',
                'created_at' => '2025-06-01 13:54:45',
                'updated_at' => '2025-06-01 13:54:45',
            ],
        ]);
    }
}
