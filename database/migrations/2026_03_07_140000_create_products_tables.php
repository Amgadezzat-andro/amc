<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->tinyInteger('status')->default(1);
            $table->date('published_at')->nullable();
            $table->integer('weight_order')->default(10);
            $table->json('specifications')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('products_lang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('language', 5);
            $table->string('title')->nullable();
            $table->text('brief')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products_lang');
        Schema::dropIfExists('products');
    }
};
