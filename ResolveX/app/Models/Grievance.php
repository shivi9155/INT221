<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Grievance extends Model
{
    use HasFactory;

    public const CATEGORIES = ['HR issues', 'Funding/legal issues', 'Technical/IT problems', 'Other'];
    public const PRIORITIES = ['Low', 'Medium', 'High'];
    public const STATUSES = ['Submitted', 'Under Review', 'In Progress', 'Resolved'];

    protected $fillable = [
        'ticket_id',
        'user_id',
        'assigned_to',
        'category',
        'subject',
        'description',
        'priority',
        'status',
        'is_anonymous',
        'attachment_path',
        'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'is_anonymous' => 'boolean',
            'resolved_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function updates(): HasMany
    {
        return $this->hasMany(GrievanceUpdate::class);
    }

    public function feedback(): HasOne
    {
        return $this->hasOne(Feedback::class);
    }
}
