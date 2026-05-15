<?php

namespace Tests\Feature;

use App\Models\Grievance;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GrievanceWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_submit_a_smart_grievance(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('grievances.store'), [
            'category' => 'Other',
            'subject' => 'Critical payroll harassment issue',
            'description' => 'This is urgent because salary is delayed and the team feels blocked by HR action.',
            'priority' => 'High',
            'is_anonymous' => '1',
        ]);

        $grievance = Grievance::first();

        $response->assertRedirect(route('grievances.show', $grievance));
        $this->assertNotNull($grievance);
        $this->assertSame('HR issues', $grievance->ai_category);
        $this->assertSame('Critical', $grievance->sentiment_label);
        $this->assertTrue($grievance->is_anonymous);
        $this->assertNotNull($grievance->due_at);
    }

    public function test_admin_can_update_user_role_and_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $member = User::factory()->create(['role' => 'user', 'is_active' => true]);

        $this->actingAs($admin)->put(route('admin.users.update-role', $member), [
            'role' => 'moderator',
        ])->assertSessionHas('status');

        $this->actingAs($admin)->put(route('admin.users.status', $member))
            ->assertSessionHas('status');

        $member->refresh();

        $this->assertSame('moderator', $member->role);
        $this->assertFalse($member->is_active);
    }

    public function test_inactive_user_cannot_log_in(): void
    {
        $password = 'password123';
        $user = User::factory()->create([
            'email' => 'legacy-admin@example.com',
            'password' => $password,
            'is_active' => false,
        ]);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => $password,
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }
}
