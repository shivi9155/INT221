<?php

namespace Database\Seeders;

use App\Models\Grievance;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ExtraGrievanceSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'founder@resolvex.test')->first();
        $admin = User::where('email', 'admin@resolvex.test')->first();
        $moderator = User::where('email', 'moderator@resolvex.test')->first();

        if (!$user) return;

        $extraData = [
            [
                'subject' => 'Equity Grant Letter Missing',
                'description' => 'I have not received my official equity grant letter despite completing 6 months. Please expedite.',
                'category' => 'Funding/legal issues',
                'priority' => 'Medium',
                'status' => 'In Progress',
                'sentiment_label' => 'Concerned',
            ],
            [
                'subject' => 'Harassment Complaint - Marketing Dept',
                'description' => 'I would like to report a repeated instance of unprofessional behavior during our weekly syncs.',
                'category' => 'HR issues',
                'priority' => 'High',
                'status' => 'Under Review',
                'sentiment_label' => 'Critical',
            ],
            [
                'subject' => 'VPN Connection Drops Frequently',
                'description' => 'The company VPN (RX-Connect) is dropping every 15 minutes. It makes remote work impossible.',
                'category' => 'Technical/IT problems',
                'priority' => 'Low',
                'status' => 'Submitted',
                'sentiment_label' => 'Neutral',
            ],
            [
                'subject' => 'Reimbursement for Travel Expenses',
                'description' => 'The travel portal is rejecting my receipts for the Bangalore conference. Need help with the manual process.',
                'category' => 'Other',
                'priority' => 'Medium',
                'status' => 'Resolved',
                'sentiment_label' => 'Calm',
            ],
            [
                'subject' => 'Laptop Battery Swelling',
                'description' => 'My MacBook Pro battery seems to be swelling. It is a safety hazard. I need an immediate replacement.',
                'category' => 'Technical/IT problems',
                'priority' => 'High',
                'status' => 'In Progress',
                'sentiment_label' => 'Critical',
            ],
            [
                'subject' => 'Incorrect PF Deductions',
                'description' => 'My salary slip for April shows incorrect PF deductions. It does not match the calculations provided during onboarding.',
                'category' => 'HR issues',
                'priority' => 'Medium',
                'status' => 'Submitted',
                'sentiment_label' => 'Concerned',
            ],
            [
                'subject' => 'Request for Better Health Insurance',
                'description' => 'The current health insurance policy has very low coverage for dependent parents. We should consider upgrading it.',
                'category' => 'Other',
                'priority' => 'Low',
                'status' => 'Resolved',
                'sentiment_label' => 'Calm',
            ]
        ];

        foreach ($extraData as $data) {
            $ticketId = 'RX-' . strtoupper(Str::random(8));
            $grievance = Grievance::create([
                ...$data,
                'ticket_id' => $ticketId,
                'user_id' => $user->id,
                'assigned_to' => ($data['priority'] === 'High') ? $admin->id : $moderator->id,
                'sentiment_score' => $data['sentiment_label'] === 'Critical' ? -3.0 : 0.5,
                'due_at' => now()->addDays(rand(1, 5)),
                'ai_category' => $data['category'],
                'sla_hours' => 24,
                'created_at' => now()->subDays(rand(0, 30)),
            ]);

            // Add a comment
            $grievance->updates()->create([
                'user_id' => $admin->id,
                'status' => $data['status'],
                'note' => 'Automated triage system has assigned this ticket. AI sentiment analysis: ' . $data['sentiment_label'],
            ]);
        }
    }
}
