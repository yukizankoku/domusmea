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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('title');
            $table->foreignId('provinces_id');
            $table->foreignId('regencies_id');
            $table->foreignId('districts_id');
            $table->foreignId('villages_id');
            $table->string('address');
            $table->string('url_map')->nullable();
            $table->string('type'); //sell or rent
            $table->string('category'); //house, apartment, etc
            $table->decimal('price', 20, 2);
            $table->integer('luas_tanah');
            $table->integer('luas_bangunan');
            $table->integer('jumlah_lantai');
            $table->integer('kamar_tidur');
            $table->integer('kamar_mandi');
            $table->integer('carport');
            $table->integer('listrik');
            $table->string('sertifikat');
            $table->mediumText('description');
            $table->json('amenities')->nullable(); // Fasilitas Dalam Rumah (AC, TV, dll)
            $table->json('features')->nullable(); // Fasilitas Luar Rumah (rumah sakit, sekolah, dll)
            $table->json('image')->nullable();
            $table->string('owner_name');
            $table->string('owner_phone');
            $table->string('owner_email')->nullable();
            $table->boolean('active')->default(false);
            $table->boolean('sold')->default(false);
            $table->timestamp('sold_at')->nullable();
            $table->foreignId('posted_by')->constrained('users')->onDelete('cascade'); // Diposting oleh siapa (relasi ke users)
            $table->foreignId('sold_by')->nullable()->constrained('users')->onDelete('set null'); // Dijual oleh siapa (relasi ke users)
            $table->boolean('promoted')->default(false);
            $table->boolean('premium')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
