<?php

use App\Models\Job;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('career_jobs')) {
            return;
        }

        if (!Schema::hasColumn('career_jobs', 'status')) {
            Schema::table('career_jobs', function (Blueprint $table) {
                $table->tinyInteger('status')->default(Job::STATUS_PUBLISHED);
                $table->index('status');
            });
        }

        if (Schema::hasColumn('career_jobs', 'is_active')) {
            DB::table('career_jobs')->update([
                'status' => DB::raw('CASE WHEN is_active = 1 THEN 1 ELSE 0 END'),
            ]);
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('career_jobs') || !Schema::hasColumn('career_jobs', 'status')) {
            return;
        }

        Schema::table('career_jobs', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropColumn('status');
        });
    }
};
