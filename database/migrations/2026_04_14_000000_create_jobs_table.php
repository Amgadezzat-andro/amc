<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('jobs')) {
            return;
        }

        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('location');
            $table->string('department');
            $table->string('experience_level');
            $table->string('employment_type');
            $table->date('posted_at');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('is_active');
            $table->index('posted_at');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
