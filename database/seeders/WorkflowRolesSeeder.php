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
            'name'=> 'مدير الشكاوي',
            'email' => 'complaint_manager@example.com',
            'password' => Hash::make('password'),
        ])->assignRole('complaint_manager');

        User::factory()->create([
            'name'=> 'مشرف ميداني',
            'email' => 'field_agent@example.com',
            'password' => Hash::make('password'),
        ])->assignRole('field_agent');

    }
}
