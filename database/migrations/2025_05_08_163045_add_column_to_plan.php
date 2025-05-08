<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->boolean('is_popular')->default(false);
            $table->string('link_checkout')->default('https://javaradigital.com/product/search?query=hideiyh');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('link_checkout');
            $table->dropColumn('is_popular');
            
        });
    }
};
