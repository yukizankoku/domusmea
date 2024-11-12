<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        return [
            'title' => fake()->sentence(),
            'code' => $this->generateUniqueCode(),
            'provinces_id' => 32,
            'regencies_id' => 3276,
            'districts_id' => 3276020,
            'villages_id' => 3276020009,
            'address' => fake()->address(),
            'type' => fake()->randomElement(['Jual', 'Sewa']),
            'category' => fake()->randomElement(['Rumah', 'Apartement', 'Villa', 'Kantor', 'Tanah']),
            'price' => mt_rand(50000000, 1000000000),
            'luas_tanah' => mt_rand(60,300),
            'luas_bangunan' => mt_rand(60,300),
            'jumlah_lantai' => mt_rand(1,4),
            'kamar_tidur' => mt_rand(1,4),
            'kamar_mandi' => mt_rand(1,4),
            'carport' => mt_rand(1,3),
            'listrik' => mt_rand(600,3000),
            'sertifikat' => fake()->randomElement(['SHM', 'SHGB', 'AJB']),
            'description' => fake()->sentence(),
            'active' => boolval(mt_rand(0,1)),
            'sold' => boolval(0),
            'posted_by' => User::inRandomOrder()->first()->id,
            'promoted' => boolval(mt_rand(0,1)),
            'owner_name' => fake()->name(),
            'owner_phone' => fake()->phoneNumber(),
        ];
    }

    private function generateUniqueCode()
    {
        do {
            // Generate random code with a prefix and random numbers
            $code = 'DM-' . str_pad(random_int(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (Property::where('code', $code)->exists()); // Pastikan kode unik

        return $code;
    }
}
