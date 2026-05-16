<?php

namespace Database\Seeders;

use App\Models\Grievance;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GrievanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'founder@gmail.com')->first();

        if ($user) {
            Grievance::create([
                'ticket_id' => 'GRV-001',
                'user_id' => $user->id,
                'category' => 'HR issues',
                'subject' => 'Salary delay issue',
                'description' => 'I have not received my salary for the last two months. This is causing financial difficulties.',
                'priority' => 'High',
                'status' => 'Submitted',
                'is_anonymous' => false,
            ]);

            Grievance::create([
                'ticket_id' => 'GRV-002',
                'user_id' => $user->id,
                'category' => 'Technical/IT problems',
                'subject' => 'Cannot access company email',
                'description' => 'I am unable to access my company email account. Getting authentication errors.',
                'priority' => 'Medium',
                'status' => 'Under Review',
                'is_anonymous' => false,
            ]);

            Grievance::create([
                'ticket_id' => 'GRV-003',
                'category' => 'Other',
                'subject' => 'Anonymous complaint',
                'description' => 'There are some issues with the office environment that need attention.',
                'priority' => 'Low',
                'status' => 'Submitted',
                'is_anonymous' => true,
            ]);
        }
    }
}
