<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
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
        'escalated_to',
        'category',
        'ai_category',
        'subject',
        'description',
        'priority',
        'sentiment_label',
        'sentiment_score',
        'status',
        'is_anonymous',
        'attachment_path',
        'due_at',
        'escalated_at',
        'sla_hours',
        'resolved_at',
        'resolution_summary',
    ];

    protected function casts(): array
    {
        return [
            'is_anonymous' => 'boolean',
            'due_at' => 'datetime',
            'escalated_at' => 'datetime',
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

    public function escalatedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'escalated_to');
    }

    public function updates(): HasMany
    {
        return $this->hasMany(GrievanceUpdate::class);
    }

    public function feedback(): HasOne
    {
        return $this->hasOne(Feedback::class);
    }

    public function isOverdue(): bool
    {
        return $this->status !== 'Resolved' && $this->due_at !== null && $this->due_at->isPast();
    }
}
