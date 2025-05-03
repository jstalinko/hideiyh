<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *    'shorturl' => $ss['shorturl'],
            'botss_page_url' => $ss['botss_page_url'],
            'white_page_url' => $ss['white_page_url'],
            'offer_page_url' => $ss['offer_page_url'],
            'render_botss_method' => $ss['render_botss_method'],
            'render_white_method' => $ss['render_white_method'],
            'render_offer_method' => $ss['render_offer_method'],
            'allowed_country' => $ss['allowed_country'],
            'allowed_params' => $ss['allowed_params'],
            'block_no_referer' => $ss['block_no_referer'],
            'block_vpn' => $ss['block_vpn'],
            'allowed_device' => $ss['allowed_device'],
            'allowed_platform' => $ss['allowed_platform'],
            'antiLoopMax' => $ss['antiLoopMax']
     */
    public function up(): void
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('shortlink')->unique();
            $table->string('domain')->nullable();
            $table->integer('clicks')->default(0);
            $table->integer('white_page_clicks')->default(0);
            $table->integer('bot_page_clicks')->default(0);
            $table->integer('offer_page_clicks')->default(0);
            $table->string('bot_page_url')->default('https://javaradigital.com/default.html');
            $table->string('white_page_url')->default('https://javaradigital.com/default.html');
            $table->string('offer_page_url')->default('https://javaradigital.com/default.html');
            $table->string('render_bot_page_method')->default('302');
            $table->string('render_white_page_method')->default('302');
            $table->string('render_offer_page_method')->default('302');
            $table->json('allowed_country')->nullable();
            $table->json('allowed_params')->nullable();
            $table->boolean('block_no_referer')->default(false);
            $table->boolean('block_vpn')->default(false);
            $table->boolean('block_bot')->default(true);
            $table->string('allowed_device')->default('all');
            $table->string('allowed_platform')->default('all');
            $table->integer('anti_loop_max')->default(5);

            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
