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
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained();
            $table->integer('deal_price');
            $table->integer('company_commission');
            $table->foreignId('posted_by')->constrained('users');   
            $table->integer('listing_commission');
            $table->foreignId('sold_by')->constrained('users');
            $table->integer('selling_commission');
            $table->json('pembayaran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
