<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop child translation tables first because of foreign keys.
        Schema::dropIfExists('products_lang');
        Schema::dropIfExists('projects_lang');
        Schema::dropIfExists('emobility_lang');
        Schema::dropIfExists('swapping_stations_lang');

        Schema::dropIfExists('products');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('emobility');
        Schema::dropIfExists('swapping_stations');

        Schema::dropIfExists('quote_webform');
        Schema::dropIfExists('newsletter_subscriptions');
    }

    public function down(): void
    {
        // Intentionally left empty because these modules are deprecated and removed.
    }
};
