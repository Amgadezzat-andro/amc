<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->tinyInteger('status')->default(1);
            $table->date('published_at')->nullable();
            $table->integer('weight_order')->default(10);
            $table->json('specifications')->nullable();
            $table->json('benefits')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('projects_lang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->string('language', 5);
            $table->string('title')->nullable();
            $table->text('brief')->nullable();
            $table->longText('content')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects_lang');
        Schema::dropIfExists('projects');
    }
};
