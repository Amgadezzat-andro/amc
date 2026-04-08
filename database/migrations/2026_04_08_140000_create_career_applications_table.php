<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('career_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('email');
            $table->string('phone');
            $table->string('cv');
            $table->string('cover_letter')->nullable();
            $table->unsignedBigInteger('position_id');
            $table->text('message')->nullable();
            $table->unsignedBigInteger('created_at')->nullable();

            $table->index('position_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('career_applications');
    }
};
