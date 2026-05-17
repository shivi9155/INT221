<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'user_type',
        'startup_name',
        'phone',
        'is_active',
        'wants_email_notifications',
        'wants_in_app_notifications',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'wants_email_notifications' => 'boolean',
            'wants_in_app_notifications' => 'boolean',
        ];
    }

    public function grievances(): HasMany
    {
        return $this->hasMany(Grievance::class);
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')->latest();
    }

    public function unreadNotifications()
    {
        return $this->notifications()->whereNull('read_at');
    }

    public function assignedGrievances(): HasMany
    {
        return $this->hasMany(Grievance::class, 'assigned_to');
    }

    public function escalatedGrievances(): HasMany
    {
        return $this->hasMany(Grievance::class, 'escalated_to');
    }

    public function isStaff(): bool
    {
        return in_array($this->role, ['admin', 'moderator'], true);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function roleLabel(): string
    {
        return ucfirst($this->role);
    }

    public function typeLabel(): string
    {
        return ucfirst($this->user_type);
    }
}
