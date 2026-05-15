<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('grievances', function (Blueprint $table) {
            $table->string('ai_category')->nullable()->after('category');
            $table->string('sentiment_label')->nullable()->after('priority');
            $table->decimal('sentiment_score', 5, 2)->nullable()->after('sentiment_label');
            $table->timestamp('due_at')->nullable()->after('attachment_path');
            $table->timestamp('escalated_at')->nullable()->after('due_at');
            $table->foreignId('escalated_to')->nullable()->after('escalated_at')->constrained('users')->nullOnDelete();
            $table->unsignedInteger('sla_hours')->default(72)->after('escalated_to');
            $table->text('resolution_summary')->nullable()->after('resolved_at');
        });
    }

    public function down(): void
    {
        Schema::table('grievances', function (Blueprint $table) {
            $table->dropConstrainedForeignId('escalated_to');
            $table->dropColumn([
                'ai_category',
                'sentiment_label',
                'sentiment_score',
                'due_at',
                'escalated_at',
                'sla_hours',
                'resolution_summary',
            ]);
        });
    }
};
