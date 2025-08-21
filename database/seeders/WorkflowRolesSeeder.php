<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class WorkflowRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $roles = ['complaint_manager', 'field_agent'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        User::factory()->create([
            'name'=> 'رامي الاسعد ',
            'email' => 'complaint_manager@example.com',
            'password' => Hash::make('password'),
        ])->assignRole('complaint_manager');

        User::factory()->create([
            'name'=> ' منصور محمد',
            'email' => 'field_agent1@example.com',
            'password' => Hash::make('password'),
        ])->assignRole('field_agent');

        User::factory()->create([
            'name'=> '  مؤيد العلي ',
            'email' => 'field_agent2@example.com',
            'password' => Hash::make('password'),
        ])->assignRole('field_agent');

        User::factory()->create([
            'name'=> '   عبدالعزيز الحسن',
            'email' => 'field_agent3@example.com',
            'password' => Hash::make('password'),
        ])->assignRole('field_agent');

    }
}
