<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('quote_webform')) {
            return;
        }

        Schema::create('quote_webform', function (Blueprint $table) {
            $table->id();

            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('site_location');
            $table->string('power_source');
            $table->string('other_power_source')->nullable();
            $table->string('project_type');

            $table->decimal('residential_roof_space', 12, 2)->nullable();
            $table->decimal('residential_ground_space', 12, 2)->nullable();
            $table->decimal('residential_current_consumption', 12, 2)->nullable();
            $table->decimal('residential_peak_load', 12, 2)->nullable();
            $table->boolean('residential_backup_needed')->default(false);
            $table->decimal('residential_backup_duration', 8, 2)->nullable();
            $table->unsignedTinyInteger('residential_backup_percentage')->nullable();

            $table->string('commercial_business_name')->nullable();
            $table->string('commercial_business_type')->nullable();
            $table->decimal('commercial_roof_space', 12, 2)->nullable();
            $table->decimal('commercial_ground_space', 12, 2)->nullable();
            $table->decimal('commercial_consumption', 12, 2)->nullable();
            $table->decimal('commercial_peak_load', 12, 2)->nullable();
            $table->decimal('commercial_working_hours', 8, 2)->nullable();
            $table->boolean('commercial_operates_at_night')->default(false);
            $table->decimal('commercial_night_hours', 8, 2)->nullable();
            $table->boolean('commercial_backup_needed')->default(false);
            $table->unsignedTinyInteger('commercial_backup_percentage')->nullable();

            $table->string('agricultural_farm_name')->nullable();
            $table->string('agricultural_activity_type')->nullable();
            $table->json('agricultural_power_usage')->nullable();
            $table->string('agricultural_other_power_usage')->nullable();
            $table->decimal('agricultural_roof_space', 12, 2)->nullable();
            $table->decimal('agricultural_ground_space', 12, 2)->nullable();
            $table->decimal('agricultural_consumption', 12, 2)->nullable();
            $table->decimal('agricultural_peak_load', 12, 2)->nullable();
            $table->decimal('agricultural_working_hours', 8, 2)->nullable();
            $table->boolean('agricultural_operates_at_night')->default(false);
            $table->decimal('agricultural_night_hours', 8, 2)->nullable();
            $table->boolean('agricultural_backup_needed')->default(false);
            $table->unsignedTinyInteger('agricultural_backup_percentage')->nullable();

            $table->unsignedTinyInteger('status')->default(0);
            $table->unsignedInteger('created_at')->nullable();

            $table->index('status');
            $table->index('project_type');
            $table->index('power_source');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_webform');
    }
};
