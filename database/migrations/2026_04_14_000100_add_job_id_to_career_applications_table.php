<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('career_applications') || Schema::hasColumn('career_applications', 'job_id')) {
            return;
        }

        Schema::table('career_applications', function (Blueprint $table) {
            $table->unsignedBigInteger('job_id')->nullable()->after('cover_letter');
            $table->index('job_id');
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('career_applications') || !Schema::hasColumn('career_applications', 'job_id')) {
            return;
        }

        Schema::table('career_applications', function (Blueprint $table) {
            $table->dropIndex(['job_id']);
            $table->dropColumn('job_id');
        });
    }
};
