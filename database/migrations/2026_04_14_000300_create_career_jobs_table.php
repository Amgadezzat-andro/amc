<?php

use App\Models\Job;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('career_jobs')) {
            return;
        }

        Schema::create('career_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('location');
            $table->string('department');
            $table->string('experience_level');
            $table->string('employment_type');
            $table->date('posted_at');
            $table->tinyInteger('status')->default(Job::STATUS_PUBLISHED);
            $table->unsignedInteger('sort_order')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('posted_at');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('career_jobs');
    }
};
