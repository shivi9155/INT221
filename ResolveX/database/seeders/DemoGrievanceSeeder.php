<?php

namespace Database\Seeders;

use App\Models\Grievance;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoGrievanceSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'user')->first() ?? User::factory()->create(['role' => 'user']);
        $admin = User::where('role', 'admin')->first();

        $demos = [
            [
                'subject' => 'Delayed Salary Payment for March',
                'description' => 'Our team has not received salaries for March. This is causing significant distress among employees. Please look into the disbursement status.',
                'category' => 'HR issues',
                'priority' => 'High',
                'status' => 'Under Review',
                'sentiment_label' => 'Critical',
            ],
            [
                'subject' => 'Server Downtime in Production',
                'description' => 'We are experiencing intermittent downtime in our production environment (RX-Server-01). This is affecting our customer onboarding flow.',
                'category' => 'Technical/IT problems',
                'priority' => 'High',
                'status' => 'In Progress',
                'sentiment_label' => 'Critical',
            ],
            [
                'subject' => 'Clarification on Equity Vesting',
                'description' => 'I need more details on the accelerated vesting clause in the new employee handbook. Does it apply to existing contracts?',
                'category' => 'Funding/legal issues',
                'priority' => 'Medium',
                'status' => 'Submitted',
                'sentiment_label' => 'Neutral',
            ],
            [
                'subject' => 'Office Ventilation Issues',
                'description' => 'The AC in the south wing is not working properly. It gets quite warm during the afternoon.',
                'category' => 'Other',
                'priority' => 'Low',
                'status' => 'Resolved',
                'sentiment_label' => 'Concerned',
            ],
        ];

        foreach ($demos as $demo) {
            $ticketId = 'RX-'.now()->format('Ymd').'-'.Str::upper(Str::random(5));
            $grievance = Grievance::create([
                ...$demo,
                'ticket_id' => $ticketId,
                'user_id' => $user->id,
                'assigned_to' => $admin?->id,
                'sentiment_score' => $demo['sentiment_label'] === 'Critical' ? -2.5 : ($demo['sentiment_label'] === 'Neutral' ? 0.1 : -0.8),
                'due_at' => now()->addDays(2),
                'ai_category' => $demo['category'],
                'sla_hours' => 48,
            ]);

            $grievance->updates()->create([
                'user_id' => $user->id,
                'status' => 'Submitted',
                'note' => 'Demo ticket created for UI testing.',
            ]);

            if ($demo['status'] !== 'Submitted') {
                $grievance->updates()->create([
                    'user_id' => $admin?->id ?? $user->id,
                    'status' => $demo['status'],
                    'note' => 'Automated status update for demo purposes.',
                ]);
            }
        }
    }
}
