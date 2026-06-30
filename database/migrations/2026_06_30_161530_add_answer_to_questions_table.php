<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->text('answer')->nullable()->after('message');
            $table->foreignId('answered_by')->nullable()->after('answer')->constrained('users');
            $table->timestamp('answered_at')->nullable()->after('answered_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn(['answered_at', 'answered_by', 'answer']);
        });
    }
};
