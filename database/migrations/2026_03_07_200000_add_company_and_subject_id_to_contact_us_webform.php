<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_us_webform', function (Blueprint $table) {
            $table->string('company')->nullable()->after('phone');
            if (!Schema::hasColumn('contact_us_webform', 'subject_id')) {
                $table->unsignedBigInteger('subject_id')->nullable()->after('company');
                $table->foreign('subject_id')->references('id')->on('dropdown_list')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('contact_us_webform', function (Blueprint $table) {
            if (Schema::hasColumn('contact_us_webform', 'subject_id')) {
                $table->dropForeign(['subject_id']);
                $table->dropColumn('subject_id');
            }
            if (Schema::hasColumn('contact_us_webform', 'company')) {
                $table->dropColumn('company');
            }
        });
    }
};
