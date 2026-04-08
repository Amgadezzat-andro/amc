<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->string('author')->default('Ag Energies')->after('category_id');
            $table->unsignedBigInteger('video_id')->nullable()->after('views');
            $table->json('gallery_image_ids')->nullable()->after('video_id');
        });

        Schema::table('news_lang', function (Blueprint $table) {
            $table->dropColumn('content2');
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn(['author', 'video_id', 'gallery_image_ids']);
        });

        Schema::table('news_lang', function (Blueprint $table) {
            $table->longText('content2')->nullable()->after('content');
        });
    }
};
