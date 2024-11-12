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
        Schema::create('compros', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->mediumText('about');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->longText('privacy_policy')->nullable();
            $table->timestamp('privacy_policy_updated_at')->nullable();
            $table->longText('terms_and_conditions')->nullable();
            $table->timestamp('terms_and_conditions_updated_at')->nullable();
            $table->string('url_maps')->nullable();
            $table->string('url_facebook')->nullable();
            $table->string('url_instagram')->nullable();
            $table->string('url_linkedin')->nullable();
            $table->string('url_youtube')->nullable();
            $table->string('url_tiktok')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compros');
    }
};
