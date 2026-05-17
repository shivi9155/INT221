<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_type')->default('founder');
            $table->boolean('is_active')->default(true);
            $table->boolean('wants_email_notifications')->default(true);
            $table->boolean('wants_in_app_notifications')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'user_type',
                'is_active',
                'wants_email_notifications',
                'wants_in_app_notifications',
            ]);
        });
    }
};
