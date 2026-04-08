<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('internship_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('email');
            $table->string('phone');
            $table->date('date_of_birth');
            $table->string('address');
            $table->string('university');
            $table->string('major');
            $table->string('level_of_studies');
            $table->date('date_of_availability')->nullable();
            $table->string('cv');
            $table->string('cover_letter')->nullable();
            $table->text('message')->nullable();
            $table->unsignedBigInteger('created_at')->nullable();

            $table->index('email');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internship_applications');
    }
};
