<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('swapping_stations', function (Blueprint $table) {
            $table->id();
            $table->decimal('lat', 10, 7);
            $table->decimal('lng', 10, 7);
            $table->tinyInteger('status')->default(1);
            $table->date('published_at')->nullable();
            $table->integer('weight_order')->default(10);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('swapping_stations_lang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('swapping_station_id');
            $table->string('language', 5);
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('hours')->nullable();
            $table->foreign('swapping_station_id')->references('id')->on('swapping_stations')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('swapping_stations_lang');
        Schema::dropIfExists('swapping_stations');
    }
};
