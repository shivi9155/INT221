<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('grievances', function (Blueprint $table) {
            $table->string('ai_category')->nullable();
            $table->string('sentiment_label')->nullable();
            $table->decimal('sentiment_score', 5, 2)->nullable();
            $table->timestamp('due_at')->nullable();
            $table->timestamp('escalated_at')->nullable();
            $table->foreignId('escalated_to')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedInteger('sla_hours')->default(72);
            $table->text('resolution_summary')->nullable();
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
