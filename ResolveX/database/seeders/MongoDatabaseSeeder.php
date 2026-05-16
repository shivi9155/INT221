<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Grievance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MongoDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data (optional but good for clean start)
        User::truncate();
        Grievance::truncate();

        // Create Users
        $users = [
            ['name' => 'Admin User', 'email' => 'admin@resolvex.test', 'role' => 'admin'],
            ['name' => 'Moderator User', 'email' => 'moderator@resolvex.test', 'role' => 'moderator'],
            ['name' => 'Founder User', 'email' => 'founder@resolvex.test', 'role' => 'user'],
        ];

        foreach ($users as $u) {
            User::create([
                ...$u,
                'user_type' => $u['role'] === 'user' ? 'founder' : 'employee',
                'startup_name' => 'NovaWorks',
                'phone' => '9999999999',
                'is_active' => true,
                'wants_email_notifications' => true,
                'wants_in_app_notifications' => true,
                'password' => bcrypt('password'),
            ]);
        }

        $user = User::where('email', 'founder@resolvex.test')->first();
        $admin = User::where('email', 'admin@resolvex.test')->first();

        // Create Grievances
        $demos = [
            [
                'subject' => 'Delayed Salary Payment for March',
                'description' => 'Our team has not received salaries for March. This is causing significant distress among employees.',
                'category' => 'HR issues',
                'priority' => 'High',
                'status' => 'Under Review',
                'sentiment_label' => 'Critical',
            ],
            [
                'subject' => 'Server Downtime in Production',
                'description' => 'We are experiencing intermittent downtime in our production environment (RX-Server-01).',
                'category' => 'Technical/IT problems',
                'priority' => 'High',
                'status' => 'In Progress',
                'sentiment_label' => 'Critical',
            ],
            [
                'subject' => 'Clarification on Equity Vesting',
                'description' => 'I need more details on the accelerated vesting clause in the new employee handbook.',
                'category' => 'Funding/legal issues',
                'priority' => 'Medium',
                'status' => 'Submitted',
                'sentiment_label' => 'Neutral',
            ],
        ];

        foreach ($demos as $demo) {
            $ticketId = 'RX-'.now()->format('Ymd').'-'.Str::upper(Str::random(5));
            Grievance::create([
                ...$demo,
                'ticket_id' => $ticketId,
                'user_id' => $user->id,
                'assigned_to' => $admin?->id,
                'sentiment_score' => $demo['sentiment_label'] === 'Critical' ? -2.5 : 0.1,
                'due_at' => now()->addDays(2),
                'ai_category' => $demo['category'],
                'sla_hours' => 48,
            ]);
        }
    }
}
